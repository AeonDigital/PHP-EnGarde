<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl;

use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;
use AeonDigital\EnGarde\SessionControl\MainSession as MainSession;
use AeonDigital\EnGarde\SessionControl\Enum\SecurityStatus as SecurityStatus;
use AeonDigital\EnGarde\SessionControl\Enum\TypeOfActivity as TypeOfActivity;
use AeonDigital\Interfaces\DAL\iDAL as iDAL;



/**
 * Implementa o controle de sessão para tipo "NativeDataBase".
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
class NativeDataBase extends MainSession
{





    /**
     * Inicia uma nova instância de controle de sessão.
     *
     * @param       \DateTime $now
     *              Data e hora do momento em que a requisição que ativou a aplicação
     *              chegou ao domínio.
     *
     * @param       string $environment
     *              Tipo de ambiente que o domínio está rodando no momento.
     *
     * @param       string $applicationName
     *              Nome da aplicação que deve responder a requisição ``HTTP`` atual.
     *
     * @param       string $userAgent
     *              Identificação do user agent que efetuou a requisição.
     *
     * @param       string $userAgentIP
     *              IP do user agent que efetuou a requisição.
     *
     * @param       iSecurity $securityConfig
     *              Configurações de segurança para a aplicação corrente.
     *
     * @param       iCookie $securityCookie
     *              Cookie de segurança que armazena a identificação desta sessão.
     *
     * @param       string $pathToLocalData
     *              Caminho completo até o diretório de dados da aplicação.
     *
     * @param       array $dbCredentials
     *              Coleção de credenciais de acesso ao banco de dados.
     */
    function __construct(
        \DateTime $now,
        string $environment,
        string $applicationName,
        string $userAgent,
        string $userAgentIP,
        iSecurity $securityConfig,
        iCookie $securityCookie,
        string $pathToLocalData,
        array $dbCredentials
    ) {
        parent::__construct(
            $now,
            $environment,
            $applicationName,
            $userAgent,
            $userAgentIP,
            $securityConfig,
            $securityCookie,
            "",
            $dbCredentials
        );
    }





    /**
     * Identifica se o IP do UA está liberado para uso no domínio.
     *
     * @return      void
     */
    protected function checkUserAgentIP() : void
    {
        $this->securityStatus = SecurityStatus::UserAgentIPValid;

        $strSQL = " SELECT
                        COUNT(Id) as count
                    FROM
                        DomainUserBlockedAccess
                    WHERE
                        UserAgentIP=:UserAgentIP AND
                        BlockTimeOut>=:BlockTimeOut AND
                        DomainUser_Id=:DomainUser_Id;";

        $parans = [
            "UserAgentIP"   => $this->userAgentIP,
            "BlockTimeOut"  => $this->now,
            "DomainUser_Id" => $this->securityConfig->getAnonymousId()
        ];

        if ($this->DAL->getCountOf($strSQL, $parans) >= 1) {
            $this->securityStatus = SecurityStatus::UserAgentIPBlocked;
        }
    }





    /**
     * Carrega as informações do usuário indicado.
     *
     * @param       string $userName
     *              Nome do usuário.
     *
     * @return      void
     */
    protected function loadAuthenticatedUser(string $userName) : void
    {
        $this->securityStatus = SecurityStatus::UserAccountDoesNotExist;

        $strSQL = " SELECT
                        secdu.*,
                        secdup.Id as secdup_Id,
                        secdup.Active as secdup_Active,
                        secdup.ApplicationName as secdup_ApplicationName,
                        secdup.Name as secdup_Name,
                        secdup.Description as secdup_Description,
                        dupdu.DefaultProfile as secdup_DefaultProfile
                    FROM
                        DomainUser secdu
                        INNER JOIN secdup_to_secdu dupdu ON dupdu.DomainUser_Id=secdu.Id
                        INNER JOIN DomainUserProfile secdup ON secdup.Id=dupdu.DomainUserProfile_Id
                    WHERE
                        secdu.Login=:Login OR
                        secdu.ShortLogin=:ShortLogin;";

        $parans = [
            "Login" => $userName,
            "ShortLogin" => $userName
        ];

        $dtUser = $this->DAL->getDataTable($strSQL, $parans);
        if ($dtUser !== null) {
            $this->securityStatus = SecurityStatus::UserAccountUnchecked;


            $user = [
                "Id"            => (int)$dtUser[0]["Id"],
                "Active"        => (bool)$dtUser[0]["Active"],
                "RegisterDate"  => new \DateTime($dtUser[0]["RegisterDate"]),
                "Name"          => $dtUser[0]["Name"],
                "Gender"        => $dtUser[0]["Gender"],
                "Login"         => $dtUser[0]["Login"],
                "ShortLogin"    => $dtUser[0]["ShortLogin"],
                "ProfileInUse"  => null,
                "Profiles"      => [],
                "Session"       => null
            ];


            $profileActive = null;
            foreach ($dtUser as $row) {
                $prof = [
                    "Id"                => (int)$row["secdup_Id"],
                    "Active"            => (bool)$row["secdup_Active"],
                    "ApplicationName"   => $row["secdup_ApplicationName"],
                    "Name"              => $row["secdup_Name"],
                    "Description"       => $row["secdup_Description"],
                    "DefaultProfile"    => (bool)$row["secdup_DefaultProfile"],
                ];

                if ($prof["ApplicationName"] === $this->applicationName &&
                    $prof["DefaultProfile"] === true)
                {
                    $profileActive = $prof;
                    $user["ProfileInUse"] = $prof["Name"];
                }
                $user["Profiles"][] = $prof;
            }



            if ($user["Active"] === false) {
                $this->securityStatus = SecurityStatus::UserAccountDisabledForDomain;
            }
            else {
                if ($user["ProfileInUse"] === null) {
                    $this->securityStatus = SecurityStatus::UserAccountDoesNotExistInApplication; // !!
                }
                else if ($profileActive["Active"] === false) {
                    $this->securityStatus = SecurityStatus::UserAccountDisabledForApplication;
                }
                else {
                    $this->securityStatus = SecurityStatus::UserAccountRecognizedAndActive;
                    $this->authenticatedUser = $user;
                }
            }
        }
    }



    /**
     * Carrega o objeto de sessão correspondente ao hash encontrado no cookie de segurança.
     *
     * Apenas se passar por todos os critérios de segurança que a sessão será efetivamente
     * carregada.
     *
     * @return      void
     */
    protected function loadAuthenticatedSession() : void
    {
        $this->securityStatus = SecurityStatus::SessionUndefined;
        $sessionHash = $this->securityCookie->getValue();

        if ($sessionHash !== "") {
            $this->securityStatus = SecurityStatus::SessionUnchecked;

            $strSQL = " SELECT
                            *
                        FROM
                            DomainUserSession
                        WHERE
                            SessionHash=:SessionHash;";

            $parans = [
                "SessionHash" => $sessionHash
            ];

            $dtSession = $this->DAL->getDataRow($strSQL, $parans);
            if ($dtSession === null) {
                $this->securityStatus = SecurityStatus::SessionInvalid;
            }
            else {
                if ($dtSession["UserAgentIP"] !== $this->userAgentIP) {
                    $this->securityStatus = SecurityStatus::SessionUnespectedUserAgentIP;
                }
                elseif ($dtSession["UserAgent"] !== $this->userAgent) {
                    $this->securityStatus = SecurityStatus::SessionUnespectedUserAgent;
                }
                else {
                    $sessionTimeOut = new \DateTime($dtSession["SessionTimeOut"]);

                    if ($sessionTimeOut < $this->now) {
                        $this->securityStatus = SecurityStatus::SessionExpired;
                    }
                    else {
                        $this->securityStatus = SecurityStatus::SessionValid;
                        $this->authenticatedSession = $dtSession;
                    }
                }
            }
        }
    }



    /**
     * Verifica se o usuário carregado está bloqueado.
     *
     * @return      void
     */
    protected function checkIfAuthenticatedUserIsBloqued() : void
    {
        if ($this->authenticatedUser !== null) {
            $strSQL = " SELECT
                            COUNT(Id) as count
                        FROM
                            DomainUserBlockedAccess
                        WHERE
                            UserAgentIP=:UserAgentIP AND
                            BlockTimeOut>=:BlockTimeOut AND
                            DomainUser_Id=:DomainUser_Id;";

            $parans = [
                "UserAgentIP"   => $this->userAgentIP,
                "BlockTimeOut"  => $this->now,
                "DomainUser_Id" => $this->authenticatedUser["Id"]
            ];

            if ($this->DAL->getCountOf($strSQL, $parans) >= 1) {
                $this->securityStatus = SecurityStatus::UserAccountIsBlocked;
            }
        }
    }



    /**
     * Verifica se o usuário e sessão atualmente carregados possuem uma associação explicita
     * um com o outro.
     *
     * @return      void
     */
    protected function checkIfAuthenticatedUserAndAuthenticatedSessionMatchs() : void
    {
        $this->securityStatus = SecurityStatus::UserSessionUnchecked;
        if ($this->authenticatedUser !== null && $this->authenticatedSession !== null) {
            if ($this->authenticatedUser["Id"] !== $this->authenticatedSession["DomainUser_Id"]) {
                $this->securityStatus = SecurityStatus::UserSessionUnespected;
            }
            else {
                $this->authenticatedUser["Session"] = $this->authenticatedSession;
                $this->securityStatus = SecurityStatus::UserSessionAccepted;
            }
        }
    }



    /**
     * Renova a sessão carregada se tal configuração dever ser usada.
     *
     * @return      void
     */
    protected function renewAuthenticatedSession() : void
    {
        if ($this->authenticatedUser !== null &&
            $this->authenticatedSession !== null &&
            $this->authenticatedUser["Session"] === $this->authenticatedSession &&
            $this->securityConfig->getIsSessionRenew() === true)
        {
            $renewUntil = new \DateTime();
            $renewUntil->add(new \DateInterval("PT" . $this->securityConfig->getSessionTimeout() . "M"));

            $this->authenticatedSession["SessionTimeOut"] = $renewUntil->format("Y-m-d H:i:s");

            $paran = [
                "SessionTimeOut" => $renewUntil,
                "Id" => $this->authenticatedSession["Id"]
            ];

            if ($this->DAL->updateSet("DomainUserSession", $paran, "Id") === true) {
                $this->authenticatedUser["Session"] = $this->authenticatedSession;
            }
        }
    }










    /**
     * Efetua o login do usuário.
     *
     * @param       string $userName
     *              Nome do usuário.
     *
     * @param       string $userPassword
     *              Senha de autenticação.
     *
     * @param       string $grantPermission
     *              Permissão que será concedida a uma sessão autenticada
     *
     * @param       string $sessionHash
     *              Sessão autenticada que receberá a permissão especial.
     *
     * @return      bool
     *              Retornará ``true`` quando o login for realizado com
     *              sucesso e ``false`` quando falhar por qualquer motivo.
     */
    public function executeLogin(
        string $userName,
        string $userPassword,
        string $grantPermission = "",
        string $sessionHash = ""
    ) : bool {
        $r = false;

        $this->executeLogout();
        $this->checkUserAgentIP();
        if ($this->securityStatus === SecurityStatus::UserAgentIPValid)
        {
            $this->loadAuthenticatedUser($userName);
            if ($this->securityStatus === SecurityStatus::UserAccountDoesNotExist) {
                $this->registerSuspectActivity(
                    $this->securityConfig->getAnonymousId(),
                    $this->securityConfig->getAllowedFaultByIP(),
                    $this->securityConfig->getIPBlockTimeout(),
                    "IP"
                );
            }
            else {
                if ($this->securityStatus === SecurityStatus::UserAccountRecognizedAndActive) {
                    $this->checkIfAuthenticatedUserIsBloqued();

                    if ($this->securityStatus === SecurityStatus::UserAccountRecognizedAndActive) {
                        if ($this->authenticatedUser["Password"] !== $userPassword) {
                            $this->securityStatus = SecurityStatus::UserAccountUnexpectedPassword;
                            $this->registerSuspectActivity(
                                $this->authenticatedUser["Id"],
                                $this->securityConfig->getAllowedFaultByLogin(),
                                $this->securityConfig->getLoginBlockTimeout(),
                                "User"
                            );
                        }
                        else {
                            $this->securityStatus = SecurityStatus::UserAccountWaitingNewSession;

                            if ($grantPermission === "") {
                                $r = $this->inityAuthenticatedSession();
                            }
                            else {
                                $r = $this->grantSpecialPermission($grantPermission, $sessionHash);
                            }
                        }
                    }
                }
            }
        }

        return $r;
    }
    /**
     * Efetua o logout do usuário na aplicação e encerra sua sessão.
     *
     * @return      bool
     */
    public function executeLogout() : bool
    {
        $r = false;
        if ($this->authenticatedUser !== null &&
            $this->authenticatedSession !== null)
        {
            if ($this->DAL->deleteFrom("DomainUserSession", "Id", $this->authenticatedSession["Id"]) === true) {
                $this->authenticatedSession = null;
                $this->authenticatedUser = null;
                $this->securityStatus = SecurityStatus::UserAgentUndefined;
                $r = true;
            }
        }
        return $r;
    }





    /**
     * Verifica quando a tentativa sucessiva de login atinjiu algum dos limites estipulados e então
     * gera um registro de bloqueio para aquele IP/User.
     *
     * @param       int $userId
     *              Id do usuário.
     *
     * @param       int $allowedFault
     *              Numero máximo de falhas permitidas para este tipo de ação.
     *
     * @param       int $blockTimeout
     *              Tempo (em minutos) que o IP/User será bloqueado em caso de atinjir o número máximo
     *              de falhas configuradas.
     *
     * @param       string $blockType
     *              Tipo de bloqueio possível.
     *              ["IP", "User"]
     *
     * @return      void
     */
    protected function registerSuspectActivity(
        int $userId,
        int $allowedFault,
        int $blockTimeout,
        string $blockType
    ) : void {
        $userId = (
            ($this->authenticatedUser === null) ?
            $this->securityConfig->getAnonymousId() :
            $this->authenticatedUser["Id"]
        );

        $minRegisterDate = new \DateTime($this->now->format("Y-m-d H:i:s"));
        $minRegisterDate->sub(new \DateInterval("PT" . $blockTimeout . "M"));

        $strSQL = " SELECT
                        COUNT(Id) as count
                    FROM
                        DomainUserRequestLog
                    WHERE
                        RegisterDate>=:RegisterDate AND
                        UserAgentIP=:UserAgentIP AND
                        ApplicationName=:ApplicationName AND
                        Activity=:Activity AND
                        DomainUser_Id=:DomainUser_Id;";

        $parans = [
            "RegisterDate"      => $minRegisterDate,
            "UserAgentIP"       => $this->userAgentIP,
            "ApplicationName"   => $this->applicationName,
            "Activity"          => TypeOfActivity::MakeLogin,
            "DomainUser_Id"     => $userId
        ];


        if ($this->DAL->getCountOf($strSQL, $parans) >= $allowedFault) {
            $blockTimeOut = new \DateTime($this->now->format("Y-m-d H:i:s"));
            $blockTimeOut->add(new \DateInterval("PT" . $blockTimeout . "M"));

            $blockAccess = [
                "UserAgentIP"   => $this->userAgentIP,
                "BlockTimeOut"  => $blockTimeOut,
                "DomainUser_Id" => $userId
            ];

            if ($this->DAL->insertInto("DomainUserBlockedAccess", $blockAccess) === true) {
                $this->securityStatus = (
                    ($blockType === "IP") ?
                    SecurityStatus::UserAgentIPBlocked :
                    SecurityStatus::UserAccountHasBeenBlocked
                );
            }
        }
    }
    /**
     * Inicia os sets de segurança necessários para que uma
     * sessão autenticada possa iniciar.
     *
     * @return      bool
     *              Retornará ``true`` caso a ação tenha sido bem sucedida, ``false``
     *              se houver alguma falha no processo.
     */
    protected function inityAuthenticatedSession() : bool
    {
        $r = false;

        if ($this->authenticatedUser !== null &&
            $this->securityStatus = SecurityStatus::UserAccountWaitingNewSession)
        {
            $this->securityStatus = SecurityStatus::UserSessionLoginFail;

            $userName       = $this->authenticatedUser["Login"];
            $userProfile    = $this->authenticatedUser["ProfileInUse"];
            $userLoginDate  = $this->now->format("Y-m-d H:i:s");
            $sessionHash    = sha1($userName . $userProfile . $userLoginDate);


            $expiresDate = new \DateTime();
            $expiresDate->add(new \DateInterval("PT" . $this->securityConfig->getSessionTimeout() . "M"));
            $this->securityCookie->setExpires($expiresDate);
            $this->securityCookie->setValue($sessionHash);


            if ($this->environment === "UTEST" ||
                $this->securityCookie->defineCookie() === true)
            {
                $parans = [
                    "SessionHash"       => $sessionHash,
                    "SessionTimeOut"    => $expiresDate,
                    "UserAgent"         => $this->userAgent,
                    "UserAgentIP"       => $this->userAgentIP,
                    "ProfileInUse"      => $userProfile,
                    "GrantPermission"   => null,
                    "DomainUser_Id"     => $this->authenticatedUser["Id"]
                ];

                if ($this->DAL->insertInto("DomainUserSession", $parans) === true) {
                    $r = $this->authenticateUserAgentSession();
                }
            }
        }

        return $r;
    }
    /**
     * Concede um tipo especial de permissão para o usuário atualmente logado.
     *
     * @param       string $grantPermission
     *              Permissão que será concedida a uma sessão autenticada
     *
     * @param       string $sessionHash
     *              Sessão autenticada que receberá a permissão especial.
     *
     * @return      bool
     */
    protected function grantSpecialPermission(
        string $grantPermission,
        string $sessionHash
    ) : bool {
        $r = false;

        if ($this->authenticatedUser !== null &&
            $this->securityStatus = SecurityStatus::UserAccountWaitingNewSession)
        {
            $pathToLocalData_LogFile_Session = $this->pathToLocalData_Sessions . DS . $sessionHash . ".json";
            if (\file_exists($pathToLocalData_LogFile_Session) === true) {
                $authenticatedSession = \AeonDigital\Tools\JSON::retrieve($pathToLocalData_LogFile_Session);
                if ($authenticatedSession !== null) {
                    $authenticatedSession["GrantPermission"] = $grantPermission;

                    $r = \AeonDigital\Tools\JSON::save(
                        $pathToLocalData_LogFile_Session,
                        $authenticatedSession);
                }
            }
        }

        return $r;
    }










    /**
     * Verifica se o UA possui uma sessão válida para ser usada.
     *
     * @return      bool
     */
    public function authenticateUserAgentSession() : bool
    {
        $r = false;
        $this->loadAuthenticatedSession();

        if ($this->securityStatus === SecurityStatus::SessionValid) {
            $this->loadAuthenticatedUser($this->authenticatedSession["Login"]);

            if ($this->securityStatus === SecurityStatus::UserAccountRecognizedAndActive) {
                $this->checkIfAuthenticatedUserAndAuthenticatedSessionMatchs();

                if ($this->securityStatus === SecurityStatus::UserSessionAccepted) {
                    $r = true;
                    $this->securityStatus = SecurityStatus::UserSessionAuthenticated;
                    $this->renewAuthenticatedSession();
                }
            }
        }
        return $r;
    }
    /**
     * Efetua a troca do perfil de segurança atualmente em uso por outro que deve estar
     * na coleção de perfis disponíveis para este mesmo usuário.
     *
     * @return      ?array
     */
    public function changeUserProfile(string $profile) : bool
    {
        $r = false;

        if ($this->authenticatedUser !== null &&
            $this->authenticatedSession !== null &&
            $this->securityStatus === SecurityStatus::UserSessionAuthenticated)
        {
            foreach ($this->authenticatedUser["Profiles"] as $row) {
                if ($this->applicationName === $row["Application"] &&
                    $profile === $row["Profile"])
                {
                    $this->authenticatedUser["ProfileInUse"] = $row["Profile"];
                    $this->authenticatedSession["ProfileInUse"] = $row["Profile"];

                    $r = (  \AeonDigital\Tools\JSON::save(
                                $this->pathToLocalData_File_User, $this->authenticatedUser) === true &&
                            \AeonDigital\Tools\JSON::save(
                                $this->pathToLocalData_LogFile_Session, $this->authenticatedSession) === true);
                }
            }
        }

        return $r;
    }
    /**
     * Gera um registro de atividade para o usuário atual.
     *
     * @param       string $methodHTTP
     *              Método HTTP evocado.
     *
     * @param       string $fullURL
     *              URL completa evocada pelo UA.
     *
     * @param       ?array $postData
     *              Dados que foram postados na requisição.
     *
     * @param       string $controller
     *              Controller que foi acionado.
     *
     * @param       string $action
     *              Nome da action que foi executada.
     *
     * @param       string $activity
     *              Atividade executada.
     *
     * @param       string $obs
     *              Observação.
     *
     * @return      bool
     */
    public function registerLogActivity(
        string $methodHTTP,
        string $fullURL,
        ?array $postData,
        string $controller,
        string $action,
        string $activity,
        string $obs
    ) : bool {
        $r = false;

        $userId = (
            ($this->authenticatedUser === null) ?
            $this->securityConfig->getAnonymousId() :
            $this->authenticatedUser["Id"]
        );

        $logActivity = [
            "UserAgent"         => $this->userAgent,
            "UserAgentIP"       => $this->userAgentIP,
            "MethodHTTP"        => $methodHTTP,
            "FullURL"           => $fullURL,
            "PostData"          => \json_encode($postData),
            "ApplicationName"   => $this->applicationName,
            "ControllerName"    => $controller,
            "ActionName"        => $action,
            "Activity"          => $activity,
            "Note"              => $obs,
            "DomainUser_Id"     => $userId
        ];

        $r = $this->DAL->insertInto("DomainUserRequestLog", $logActivity);
        return $r;
    }
}
