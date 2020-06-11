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
                        dupdu.ProfileDefault as secdup_ProfileDefault,
                        dupdu.ProfileSelected as secdup_ProfileSelected
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

        $dtDomainUser = $this->DAL->getDataTable($strSQL, $parans);
        if ($dtDomainUser !== null) {
            $this->securityStatus = SecurityStatus::UserAccountUnchecked;

            if ((bool)$dtDomainUser[0]["Active"] === false) {
                $this->securityStatus = SecurityStatus::UserAccountDisabledForDomain;
            }
            else {
                $user = [
                    "Id"            => (int)$dtDomainUser[0]["Id"],
                    "Active"        => (bool)$dtDomainUser[0]["Active"],
                    "RegisterDate"  => new \DateTime($dtDomainUser[0]["RegisterDate"]),
                    "Name"          => $dtDomainUser[0]["Name"],
                    "Gender"        => $dtDomainUser[0]["Gender"],
                    "Login"         => $dtDomainUser[0]["Login"],
                    "ShortLogin"    => $dtDomainUser[0]["ShortLogin"],
                    "Password"      => $dtDomainUser[0]["Password"],
                    "Profiles"      => []
                ];


                $hasProfileForThisApplication = false;
                foreach ($dtDomainUser as $row) {
                    $user["Profiles"][] = [
                        "Id"                => (int)$row["secdup_Id"],
                        "Active"            => (bool)$row["secdup_Active"],
                        "ApplicationName"   => $row["secdup_ApplicationName"],
                        "Name"              => $row["secdup_Name"],
                        "Description"       => $row["secdup_Description"],
                        "Default"           => (bool)$row["secdup_ProfileDefault"],
                        "Selected"          => (bool)$row["secdup_ProfileSelected"],
                    ];
                    if ($this->applicationName === $row["secdup_ApplicationName"]) {
                        $hasProfileForThisApplication = true;
                    }
                }


                if ($hasProfileForThisApplication === false) {
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
     * Verifica se o usuário carregado está bloqueado.
     *
     * @return      void
     */
    protected function checkIfAuthenticatedUserIsBlocked() : void
    {
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



    /**
     * Inicia os sets de segurança necessários para que uma
     * sessão autenticada possa iniciar.
     *
     * @return      bool
     *              Retornará ``true`` caso a ação tenha sido bem sucedida, ``false``
     *              se houver alguma falha no processo.
     */
    protected function registerAuthenticatedSession() : bool
    {
        $r = false;

        $this->securityStatus = SecurityStatus::UserSessionLoginFail;

        $userName       = $this->authenticatedUser["Login"];
        $userPassword   = $this->authenticatedUser["Password"];
        $userLoginDate  = $this->now->format("Y-m-d H:i:s");
        $sessionHash    = sha1($userName . $userPassword . $userLoginDate);


        $expiresDate = new \DateTime();
        $expiresDate->add(new \DateInterval("PT" . $this->securityConfig->getSessionTimeout() . "M"));
        $this->securityCookie->setExpires($expiresDate);
        $this->securityCookie->setValue($sessionHash);


        if ($this->environment === "UTEST" ||
            $this->securityCookie->defineCookie() === true)
        {
            $strSQL = " DELETE FROM
                            DomainUserSession
                        WHERE
                            DomainUser_Id=:DomainUser_Id;";

            $parans = [
                "DomainUser_Id"     => $this->authenticatedUser["Id"]
            ];
            $this->DAL->executeInstruction($strSQL, $parans);


            $parans = [
                "SessionHash"       => $sessionHash,
                "SessionTimeOut"    => $expiresDate,
                "UserAgent"         => $this->userAgent,
                "UserAgentIP"       => $this->userAgentIP,
                "GrantPermission"   => null,
                "DomainUser_Id"     => $this->authenticatedUser["Id"]
            ];

            $r = $this->DAL->insertInto("DomainUserSession", $parans);
        }

        return $r;
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
                            secdus.*,
                            secdu.Login as DomainUser
                        FROM
                            DomainUserSession secdus
                            INNER JOIN DomainUser secdu ON secdu.Id=secdus.DomainUser_Id
                        WHERE
                            secdus.SessionHash=:SessionHash
                        ORDER BY
                            secdus.Id DESC;";

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
                        $this->authenticatedSession["Id"] = (int)$this->authenticatedSession["Id"];
                    }
                }
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
        if ($this->securityConfig->getIsSessionRenew() === true) {
            $renewUntil = new \DateTime();
            $renewUntil->add(new \DateInterval("PT" . $this->securityConfig->getSessionTimeout() . "M"));

            $this->authenticatedSession["SessionTimeOut"] = $renewUntil->format("Y-m-d H:i:s");

            $paran = [
                "SessionTimeOut" => $renewUntil,
                "Id" => $this->authenticatedSession["Id"]
            ];

            $this->DAL->updateSet("DomainUserSession", $paran, "Id");
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

        $this->getDAL();
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
                    $this->checkIfAuthenticatedUserIsBlocked();

                    if ($this->securityStatus === SecurityStatus::UserAccountRecognizedAndActive) {
                        if ($this->authenticatedUser["Password"] !== $userPassword) {
                            $this->securityStatus = SecurityStatus::UserAccountUnexpectedPassword;
                            $this->registerSuspectActivity(
                                $this->authenticatedUser["Id"],
                                $this->securityConfig->getAllowedFaultByLogin(),
                                $this->securityConfig->getLoginBlockTimeout(),
                                "UserName"
                            );
                        }
                        else {
                            $this->securityStatus = SecurityStatus::UserAccountWaitingNewSession;

                            if ($grantPermission === "") {
                                if ($this->registerAuthenticatedSession() === true) {
                                    $r = $this->checkUserAgentSession();
                                }
                            }
                            else {
                                $r = $this->grantSpecialPermission($grantPermission, $sessionHash);
                            }
                        }
                    }
                }
            }
        }


        if ($r === false) {
            $this->authenticatedUser = null;
            $this->authenticatedSession = null;
        }

        return $r;

    }
    /**
     * Verifica se o UA possui uma sessão válida para ser usada.
     *
     * @return      bool
     */
    public function checkUserAgentSession() : bool
    {
        $r = false;
        $this->getDAL();
        $this->loadAuthenticatedSession();

        if ($this->securityStatus === SecurityStatus::SessionValid) {
            $this->securityStatus = SecurityStatus::UserAccountRecognizedAndActive;

            if ($this->authenticatedUser === null) {
                $this->loadAuthenticatedUser($this->authenticatedSession["DomainUser"]);
            }

            if ($this->securityStatus === SecurityStatus::UserAccountRecognizedAndActive) {
                $this->securityStatus = SecurityStatus::UserSessionUnchecked;

                if ($this->authenticatedSession["DomainUser"] !== $this->authenticatedUser["Login"]) {
                    $this->securityStatus = SecurityStatus::UserSessionUnespected;
                }
                else {
                    $r = true;
                    $this->securityStatus = SecurityStatus::UserSessionAuthenticated;
                    $this->renewAuthenticatedSession();
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
        if ($this->securityStatus === SecurityStatus::UserSessionAuthenticated)
        {
            $this->getDAL();
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


        $parans = [
            "UserAgent"         => $this->userAgent,
            "UserAgentIP"       => $this->userAgentIP,
            "MethodHTTP"        => "-",
            "FullURL"           => "-",
            "PostData"          => "{}",
            "ApplicationName"   => $this->applicationName,
            "ControllerName"    => "-",
            "ActionName"        => "-",
            "Activity"          => TypeOfActivity::MakeLogin,
            "Note"              => null,
            "DomainUser_Id"     => $userId,
        ];
        $r = $this->DAL->insertInto("DomainUserRequestLog", $parans);



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
                    SecurityStatus::UserAgentIPHasBeenBlocked :
                    SecurityStatus::UserAccountHasBeenBlocked
                );
            }
        }
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

        $parans = [
            "GrantPermission"   => $grantPermission,
            "SessionHash"       => $sessionHash
        ];

        if ($this->DAL->updateSet("DomainUserSession", $parans, "SessionHash") === true) {
            $r = true;
            $this->authenticatedSession["GrantPermission"] = $grantPermission;
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
        if ($this->securityStatus === SecurityStatus::UserSessionAuthenticated) {
            $profilesObjects = [];
            $DomainUserProfile_Id = null;
            foreach ($this->authenticatedUser["Profiles"] as $row) {
                if ($row["ApplicationName"] === $this->applicationName) {
                    $row["Selected"] = false;
                    if ($row["Name"] === $profile) {
                        $DomainUserProfile_Id = $row["Id"];
                        $row["Selected"] = true;
                    }
                }
                $profilesObjects[] = $row;
            }

            if ($DomainUserProfile_Id !== null) {
                $strSQL = " UPDATE
                                secdup_to_secdu dupdu
                                INNER JOIN DomainUserProfile secdup ON dupdu.DomainUserProfile_Id=secdup.Id
                            SET
                                dupdu.ProfileSelected=0
                            WHERE
                                dupdu.DomainUser_Id=:DomainUser_Id AND
                                secdup.ApplicationName=:ApplicationName;";

                $parans = [
                    "DomainUser_Id"     => $this->authenticatedUser["Id"],
                    "ApplicationName"   => $this->applicationName
                ];
                if ($this->DAL->executeInstruction($strSQL, $parans) === true) {
                    $strSQL = " UPDATE
                                    secdup_to_secdu dupdu
                                    INNER JOIN DomainUserProfile secdup ON dupdu.DomainUserProfile_Id=secdup.Id
                                SET
                                    dupdu.ProfileSelected=1
                                WHERE
                                    dupdu.DomainUser_Id=:DomainUser_Id AND
                                    dupdu.DomainUserProfile_Id=:DomainUserProfile_Id AND
                                    secdup.ApplicationName=:ApplicationName;";
                    $parans = [
                        "DomainUser_Id"         => $this->authenticatedUser["Id"],
                        "DomainUserProfile_Id"  => $DomainUserProfile_Id,
                        "ApplicationName"       => $this->applicationName
                    ];
                    if ($this->DAL->executeInstruction($strSQL, $parans) === true) {
                        $r = true;
                        $this->authenticatedUser["Profiles"] = $profilesObjects;
                    }
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
     * @param       string $note
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
        string $note
    ) : bool {
        $r = false;

        $userId = (
            ($this->authenticatedUser === null) ?
            $this->securityConfig->getAnonymousId() :
            $this->authenticatedUser["Id"]
        );

        $parans = [
            "UserAgent"         => $this->userAgent,
            "UserAgentIP"       => $this->userAgentIP,
            "MethodHTTP"        => $methodHTTP,
            "FullURL"           => $fullURL,
            "PostData"          => \json_encode($postData),
            "ApplicationName"   => $this->applicationName,
            "ControllerName"    => $controller,
            "ActionName"        => $action,
            "Activity"          => $activity,
            "Note"              => $note,
            "DomainUser_Id"     => $userId
        ];

        $this->getDAL();
        return $this->DAL->insertInto("DomainUserRequestLog", $parans);
    }
}
