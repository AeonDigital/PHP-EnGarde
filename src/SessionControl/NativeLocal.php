<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl;

use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;
use AeonDigital\EnGarde\SessionControl\MainSession as MainSession;
use AeonDigital\EnGarde\SessionControl\Enum\SecurityStatus as SecurityStatus;
use AeonDigital\EnGarde\SessionControl\Enum\TypeOfActivity as TypeOfActivity;




/**
 * Implementa o controle de sessão para tipo "NativeLocal".
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
class NativeLocal extends MainSession
{





    /**
     * Caminho completo até o diretório que armazena os logs de
     * atividades da aplicação.
     *
     * @var         string
     */
    protected string $pathToLocalData_Log = "";
    /**
     * Caminho completo até o diretório que armazena os
     * usuários da aplicação.
     *
     * @var         string
     */
    protected string $pathToLocalData_Users = "";
    /**
     * Caminho completo até o diretório que armazena as
     * sessões ativas da aplicação.
     *
     * @var         string
     */
    protected string $pathToLocalData_Sessions = "";
    /**
     * Caminho completo até o diretório que armazena os logs de atividades consideradas
     * suspeitas por esta implementação.
     *
     * @var         string
     */
    protected string $pathToLocalData_LogSuspect = "";



    /**
     * Caminho completo até o arquivo que armazena os dados do usuário.
     *
     * @var         string
     */
    protected string $pathToLocalData_File_User = "";
    /**
     * Caminho completo até o arquivo que armazena os dados de sessão.
     *
     * @var         string
     */
    protected string $pathToLocalData_LogFile_Session = "";
    /**
     * Caminho completo até o arquivo que armazena os registros de atividade suspeita
     * vindos de um IP.
     *
     * @var         string
     */
    protected string $pathToLocalData_LogFile_SuspectIP = "";
    /**
     * Caminho completo até o arquivo que armazena os registros de atividade suspeita
     * vindos de um login em especial.
     *
     * @var         string
     */
    protected string $pathToLocalData_LogFile_SuspectLogin = "";








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
     */
    public function __construct(
        \DateTime $now,
        string $environment,
        string $applicationName,
        string $userAgent,
        string $userAgentIP,
        iSecurity $securityConfig,
        iCookie $securityCookie,
        string $pathToLocalData
    ) {
        parent::__construct(
            $now,
            $environment,
            $applicationName,
            $userAgent,
            $userAgentIP,
            $securityConfig,
            $securityCookie,
            $pathToLocalData
        );
        $this->sessionType = "NativeLocal";


        // Define os locais fisicos onde estão os dados de segurança da aplicação.
        $this->pathToLocalData_Log      = $this->pathToLocalData . DS . "log";
        $this->pathToLocalData_Users    = $this->pathToLocalData . DS . "users";
        $this->pathToLocalData_Sessions = $this->pathToLocalData . DS . "sessions";


        // Testa cada valor obrigatório
        $this->mainCheckForInvalidArgumentException(
            "pathToLocalData", $this->pathToLocalData_Log, [
                ["validate"         => "is dir exists"]
            ]
        );
        $this->mainCheckForInvalidArgumentException(
            "pathToLocalData", $this->pathToLocalData_Users, [
                ["validate"         => "is dir exists"]
            ]
        );
        $this->mainCheckForInvalidArgumentException(
            "pathToLocalData", $this->pathToLocalData_Sessions, [
                ["validate"         => "is dir exists"]
            ]
        );


        $fileSuspectIP = \str_replace([".", ":"], "_", $userAgentIP) . ".json";
        $this->pathToLocalData_LogSuspect = $this->pathToLocalData_Log . DS . "suspect";
        $this->pathToLocalData_LogFile_SuspectIP = $this->pathToLocalData_LogSuspect . DS . $fileSuspectIP;
    }





    /**
     * Identifica se o IP do UA está liberado para uso na aplicação.
     *
     * @return      void
     */
    protected function checkUserAgentIP() : void
    {
        $this->securityStatus = SecurityStatus::UserAgentIPValid;

        if(\file_exists($this->pathToLocalData_LogFile_SuspectIP)) {
            $suspectData = \AeonDigital\Tools\JSON::retrieve($this->pathToLocalData_LogFile_SuspectIP);

            if($suspectData["Blocked"] === true) {
                $unblockDate = \DateTime::createFromFormat("Y-m-d H:i:s", $suspectData["UnblockDate"]);
                if($unblockDate < $this->now) {
                    \unlink($this->pathToLocalData_LogFile_SuspectIP);
                }
                else {
                    $this->securityStatus = SecurityStatus::UserAgentIPBlocked;
                }
            }
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
        $fileUserLogin = \mb_str_to_valid_filename(\strtolower($userName)) . ".json";
        $this->pathToLocalData_File_User = $this->pathToLocalData_Users . DS . $fileUserLogin;
        $this->pathToLocalData_LogFile_SuspectLogin = $this->pathToLocalData_LogSuspect . DS . $fileUserLogin;


        if (\file_exists($this->pathToLocalData_File_User) === true) {
            $this->securityStatus = SecurityStatus::UserAccountUnchecked;
            $authenticatedUser = \AeonDigital\Tools\JSON::retrieve($this->pathToLocalData_File_User);

            if ($authenticatedUser !== null) {
                if ($authenticatedUser["Active"] === false) {
                    $this->securityStatus = SecurityStatus::UserAccountDisabledForDomain;
                }
                else {
                    $profileInUse = null;
                    $defaultProfile = null;
                    foreach ($authenticatedUser["Profiles"] as $row) {
                        if ($this->applicationName === $row["Application"]) {
                            if ($row["Default"] === true) { $defaultProfile = $row; }
                            if ($this->authenticatedSession !== null &&
                                $this->authenticatedSession["ProfileInUse"] === $row["Profile"])
                            {
                                $profileInUse = $row;
                            }
                        }
                    }
                    $authenticatedUser["ProfileInUse"] = (
                        ($profileInUse === null) ? $defaultProfile : $profileInUse
                    );


                    if ($authenticatedUser["ProfileInUse"] === null) {
                        $this->securityStatus = SecurityStatus::UserAccountDoesNotExistInApplication;
                    }
                    else if ($authenticatedUser["ProfileInUse"]["Active"] === false) {
                        $this->securityStatus = SecurityStatus::UserAccountDisabledForApplication;
                    }
                    else {
                        $this->securityStatus = SecurityStatus::UserAccountRecognizedAndActive;
                        $this->authenticatedUser = $authenticatedUser;
                    }
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
            $this->pathToLocalData_LogFile_Session = $this->pathToLocalData_Sessions . DS . $sessionHash . ".json";

            if (\file_exists($this->pathToLocalData_LogFile_Session) === true) {
                $authenticatedSession = \AeonDigital\Tools\JSON::retrieve($this->pathToLocalData_LogFile_Session);

                if ($authenticatedSession === null) {
                    $this->securityStatus = SecurityStatus::SessionInvalid;
                }
                else {
                    if ($authenticatedSession["UserAgentIP"] !== $this->userAgentIP) {
                        $this->securityStatus = SecurityStatus::SessionUnespectedUserAgentIP;
                    }
                    elseif ($authenticatedSession["UserAgent"] !== $this->userAgent) {
                        $this->securityStatus = SecurityStatus::SessionUnespectedUserAgent;
                    }
                    elseif ($authenticatedSession["ApplicationName"] !== $this->applicationName) {
                        $this->securityStatus = SecurityStatus::SessionUnespectedApplication;
                    }
                    else {
                        $sessionTimeOut = new \DateTime($authenticatedSession["SessionTimeOut"]);

                        if ($sessionTimeOut < $this->now) {
                            $this->securityStatus = SecurityStatus::SessionExpired;
                        }
                        else {
                            $this->securityStatus = SecurityStatus::SessionValid;
                            $this->authenticatedSession = $authenticatedSession;
                        }
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
    protected function checkAuthenticatedUser() : void
    {
        if ($this->authenticatedUser !== null) {
            if(\file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
                $loginSuspectData = \AeonDigital\Tools\JSON::retrieve($this->pathToLocalData_LogFile_SuspectLogin);

                if($loginSuspectData !== null && $loginSuspectData["Blocked"] === true) {
                    $unblockDate = \DateTime::createFromFormat("Y-m-d H:i:s", $loginSuspectData["UnblockDate"]);

                    if($unblockDate < $this->now) {
                        \unlink($this->pathToLocalData_LogFile_SuspectLogin);
                    }
                    else {
                        $this->securityStatus = SecurityStatus::UserAccountIsBlocked;
                    }
                }
            }
        }
    }
    /**
     * Verifica se o usuário atualmente carregado possui uma associação com a sessão.
     *
     * @return      void
     */
    protected function checkUserAndSession() : void
    {
        $this->securityStatus = SecurityStatus::UserSessionUnchecked;
        if ($this->authenticatedUser !== null && $this->authenticatedSession !== null) {
            if ($this->authenticatedUser["SessionHash"] !== $this->authenticatedSession["SessionHash"]) {
                $this->securityStatus = SecurityStatus::UserSessionUnespected;
            }
            else {
                $this->authenticatedUser["Session"] = $this->authenticatedSession;
                $this->securityStatus = SecurityStatus::UserSessionAccepted;
            }
        }
    }
    /**
     * Verifica necessidade de renovar a sessão do usuário.
     *
     * @return      void
     */
    protected function checkRenewSession() : void
    {
        if ($this->authenticatedUser !== null &&
            $this->authenticatedSession !== null &&
            $this->authenticatedUser["Session"] === $this->authenticatedSession &&
            $this->securityConfig->getIsSessionRenew() === true)
        {
            $renewUntil = new \DateTime();
            $renewUntil->add(new \DateInterval("PT" . $this->securityConfig->getSessionTimeout() . "M"));

            $this->authenticatedSession["SessionTimeOut"] = $renewUntil->format("Y-m-d H:i:s");
            if (\AeonDigital\Tools\JSON::save(
                $this->pathToLocalData_LogFile_Session,
                $this->authenticatedSession) === true)
            {
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
                    $userName,
                    $this->pathToLocalData_LogFile_SuspectIP,
                    $this->securityConfig->getAllowedFaultByIP(),
                    $this->securityConfig->getIPBlockTimeout(),
                    "IP"
                );
            }
            else {
                if ($this->securityStatus === SecurityStatus::UserAccountRecognizedAndActive) {
                    $this->checkAuthenticatedUser();

                    if ($this->securityStatus === SecurityStatus::UserAccountRecognizedAndActive) {
                        if ($this->authenticatedUser["Password"] !== $userPassword) {
                            $this->securityStatus = SecurityStatus::UserAccountUnexpectedPassword;
                            $this->registerSuspectActivity(
                                $userName,
                                $this->pathToLocalData_LogFile_SuspectLogin,
                                $this->securityConfig->getAllowedFaultByLogin(),
                                $this->securityConfig->getLoginBlockTimeout(),
                                "UserName"
                            );
                        }
                        else {
                            $this->securityStatus = SecurityStatus::UserAccountWaitingAuthorization;

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
            $this->authenticatedUser !== null &&
            \file_exists($this->pathToLocalData_LogFile_Session) === true)
        {
            \unlink($this->pathToLocalData_LogFile_Session);
            $this->authenticatedSession = null;
            $this->authenticatedUser = null;
            $r = true;
        }
        return $r;
    }





    /**
     * Gerencia a criação de um arquivo de controle de acessos de IP/UserName e efetua a contagem de
     * falhas de autenticação em uma atividade de verificação de "UserName" ou "UserPassword" além de
     * definir o IP/UserName como bloqueado em casos em que atinja o limite de falhas permitidas.
     *
     * @param       string $userName
     *              Nome do usuário.
     *
     * @param       string $registerFile
     *              Arquivo que deve ser usado para registrar as atividades monitoradas.
     *
     * @param       int $allowedFault
     *              Numero máximo de falhas permitidas para este tipo de ação.
     *
     * @param       int $blockTimeout
     *              Tempo (em minutos) que o IP/UserName será bloqueado em caso de atinjir o número máximo
     *              de falhas configuradas.
     *
     * @param       string $blockType
     *              Tipo de bloqueio possível.
     *              ["IP", "UserName"]
     *
     * @return      void
     */
    protected function registerSuspectActivity(
        string $userName,
        string $registerFile,
        int $allowedFault,
        int $blockTimeout,
        string $blockType
    ) : void {
        if (\file_exists($registerFile) === false) {
            \AeonDigital\Tools\JSON::save(
                $registerFile, [
                    "Activity"          => TypeOfActivity::MakeLogin,
                    "IP"                => $this->userAgentIP,
                    "Login"             => ($blockType === "IP") ? "" : $userName,
                    "Counter"           => 1,
                    "LastEventDateTime" => $this->now->format("Y-m-d H:i:s"),
                    "Blocked"           => false,
                    "UnblockDate"       => null
                ]
            );
        }
        else {
            $suspectData = \AeonDigital\Tools\JSON::retrieve($registerFile);
            if ($suspectData === null) {
                $suspectData = [
                    "Activity"          => TypeOfActivity::MakeLogin,
                    "IP"                => $this->userAgentIP,
                    "Login"             => ($blockType === "IP") ? "" : $userName,
                    "Counter"           => 1,
                    "LastEventDateTime" => $this->now->format("Y-m-d H:i:s"),
                    "Blocked"           => false,
                    "UnblockDate"       => null
                ];
            }
            else {
                $diffInMinutes = $this->now->diff(
                    \DateTime::createFromFormat("Y-m-d H:i:s", $suspectData["LastEventDateTime"])
                )->format("%i");

                $suspectData["Counter"]++;
                $suspectData["LastEventDateTime"] = $this->now->format("Y-m-d H:i:s");
                if ($diffInMinutes > $blockTimeout) {
                    $suspectData["Counter"] = 1;
                }

                if($suspectData["Counter"] >= $allowedFault) {
                    $unblockDate = new \DateTime();
                    $unblockDate->add(new \DateInterval("PT" . $blockTimeout . "M"));

                    if ($allowedFault > 0 && $blockTimeout > 0) {
                        $suspectData["Blocked"]       = true;
                        $suspectData["UnblockDate"]   = $unblockDate->format("Y-m-d H:i:s");

                        $this->securityStatus = (
                            ($blockType === "IP") ?
                            SecurityStatus::UserAgentIPBlocked :
                            SecurityStatus::UserAccountHasBeenBlocked
                        );
                    }
                }
            }

            \AeonDigital\Tools\JSON::save($registerFile, $suspectData);
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
            $this->securityStatus = SecurityStatus::UserAccountWaitingAuthorization)
        {
            $this->securityStatus = SecurityStatus::UserSessionLoginFail;

            $userName       = $this->authenticatedUser["Login"];
            $userProfile    = $this->authenticatedUser["ProfileInUse"]["Profile"];
            $userLoginDate  = $this->now->format("Y-m-d H:i:s");
            $sessionHash    = sha1($userName . $userProfile . $userLoginDate);


            $expiresDate = new \DateTime();
            $expiresDate->add(new \DateInterval("PT" . $this->securityConfig->getSessionTimeout() . "M"));
            $this->securityCookie->setExpires($expiresDate);
            $this->securityCookie->setValue("sessionHash=$sessionHash");


            if ($this->environment === "UTEST" ||
                $this->securityCookie->defineCookie() === true)
            {
                $this->pathToLocalData_LogFile_Session = $this->pathToLocalData_Sessions . DS . $sessionHash . ".json";

                $this->authenticatedUser["Session"] = null;
                $this->authenticatedUser["SessionHash"] = $sessionHash;
                if (\AeonDigital\Tools\JSON::save(
                    $this->pathToLocalData_File_User,
                    $this->authenticatedUser) === true)
                {
                    $this->authenticatedUser["Session"] = [
                        "SessionHash"       => $sessionHash,
                        "ApplicationName"   => $this->applicationName,
                        "LoginDate"         => $this->now->format("Y-m-d H:i:s"),
                        "SessionTimeOut"    => $expiresDate->format("Y-m-d H:i:s"),
                        "SessionRenew"      => $this->securityConfig->getSessionTimeout(),
                        "Login"             => $userName,
                        "ProfileInUse"      => $userProfile,
                        "UserAgent"         => $this->userAgent,
                        "UserAgentIP"       => $this->userAgentIP,
                        "GrantPermission"   => null
                    ];

                    if (\AeonDigital\Tools\JSON::save(
                            $this->pathToLocalData_LogFile_Session,
                            $this->authenticatedUser["Session"]) === true)
                    {
                        $r = true;
                        $this->securityStatus = SecurityStatus::UserSessionAuthorized;
                    }
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
            $this->securityStatus = SecurityStatus::UserAccountWaitingAuthorization)
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
     * @return      void
     */
    public function authenticateUserAgentSession() : void
    {
        $this->loadAuthenticatedSession();

        if ($this->securityStatus === SecurityStatus::SessionValid) {
            $this->loadAuthenticatedUser($this->authenticatedSession["Login"]);

            if ($this->securityStatus === SecurityStatus::UserAccountRecognizedAndActive) {
                $this->checkUserAndSession();

                if ($this->securityStatus === SecurityStatus::UserSessionAccepted) {
                    $this->securityStatus = SecurityStatus::UserSessionAuthorized;
                    $this->checkRenewSession();
                }
            }
        }
    }
}
