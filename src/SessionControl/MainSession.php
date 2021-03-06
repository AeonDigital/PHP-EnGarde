<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Engine\iSession as iSession;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;
use AeonDigital\EnGarde\SessionControl\Enum\SecurityStatus as SecurityStatus;
use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;
use AeonDigital\Interfaces\DAL\iDAL as iDAL;



/**
 * Classe abstrata, base para uma implementação de um controle de sessão
 * do tipo "Native" para aplicações "EnGarde".
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
abstract class MainSession extends BObject implements iSession
{
    use \AeonDigital\Traits\MainCheckArgumentException;





    /**
     * Data e hora do momento em que a requisição que ativou a aplicação
     * chegou ao domínio.
     *
     * @var      \DateTime
     */
    protected \DateTime $now;
    /**
     * Tipo de ambiente que o domínio está rodando no momento.
     *
     * Valores Esperados:
     *  - ``PRD``   : Production
     *  - ``HML``   : Homolog
     *  - ``QA``    : Quality Assurance
     *  - ``DEV``   : Development
     *  - ``LCL``   : Local
     *  - ``UTEST`` : Unit Test
     *
     * @return      string
     */
    protected string $environment;
    /**
     * Nome da aplicação que deve responder a requisição ``Http`` atual.
     *
     * @return      string
     */
    protected string $applicationName;
    /**
     * Identificação do user agent que efetuou a requisição.
     *
     * @return      string
     */
    protected string $userAgent;
    /**
     * IP do user agent que efetuou a requisição.
     *
     * @return      string
     */
    protected string $userAgentIP;
    /**
     * Configurações de segurança para a aplicação corrente.
     *
     * @var         iSecurity
     */
    protected iSecurity $securityConfig;
    /**
     * Objeto do perfil de usuário atualmente em uso.
     *
     * @var         ?array
     */
    protected ?array $profileInUse = null;





    /**
     * Cookie de segurança que armazena a identificação desta sessão.
     *
     * @var         iCookie
     */
    protected iCookie $securityCookie;
    /**
     * Cookie de segurança que identifica a sessão atualmente setada.
     *
     * @return      iCookie
     */
    public function retrieveSecurityCookie() : iCookie
    {
        return $this->securityCookie;
    }



    /**
     * Caminho completo até o diretório de dados da aplicação.
     *
     * @var         string
     */
    protected string $pathToLocalData = "";
    /**
     * Caminho completo até o diretório de dados da aplicação.
     * Usado em casos onde as informações de sessão estão armazenadas fisicamente
     * junto com a aplicação.
     *
     * @return      string
     */
    public function retrievePathToLocalData() : string
    {
        return $this->pathToLocalData;
    }



    /**
     * Dados da sessão autenticada que está atualmente reconhecida,
     * ativa e válida.
     *
     * @var         ?array
     */
    protected ?array $authenticatedSession = null;
    /**
     * Retorna os dados da sessão autenticada que está atualmente reconhecida,
     * ativa e válida.
     *
     * @return      ?array
     */
    public function retrieveSession() : ?array
    {
        return $this->authenticatedSession;
    }



    /**
     * Dados de um usuário autenticado que esteja associado a sessão
     * que está reconhecida, ativa e válida.
     *
     * @var         ?array
     */
    protected ?array $authenticatedUser = null;
    /**
     * Retorna os dados de um usuário autenticado que esteja associado a sessão
     * que está reconhecida, ativa e válida.
     *
     * @return      ?array
     */
    public function retrieveUser() : ?array
    {
        return $this->authenticatedUser;
    }
    /**
     * Retorna o objeto completo do perfil de usuário atualmente em uso.
     *
     * @return      ?array
     */
    public function retrieveUserProfile() : ?array
    {
        return $this->profileInUse;
    }
    /**
     * Retorna o perfil de segurança do usuário atualmente em uso.
     *
     * @return      ?string
     */
    public function retrieveUserProfileName() : ?string
    {
        return (($this->profileInUse === null) ? null : $this->profileInUse["Name"]);
    }
    /**
     * Retorna uma coleção de perfis de segurança que o usuário tem autorização de utilizar.
     *
     * @param       string $applicationName
     *              Se definido, retornará apenas os profiles que correspondem ao nome da
     *              aplicação indicada.
     *
     * @return      ?array
     */
    public function retrieveUserProfiles(string $applicationName = "") : ?array
    {
        $r = null;

        if ($this->authenticatedUser !== null) {
            if ($applicationName === "") {
                $r = $this->authenticatedUser["Profiles"];
            }
            else {
                $r = [];
                foreach ($this->authenticatedUser["Profiles"] as $i => $profileData) {
                    if ($profileData["ApplicationName"] === $applicationName) {
                        $r[] = $profileData;
                    }
                }
            }
        }

        return $r;
    }



    /**
     * Status atual da navegação do UA.
     *
     * @var         string
     */
    protected string $securityStatus = SecurityStatus::UserAgentUndefined;
    /**
     * Retorna o status atual relativo a identificação e autenticação do UA
     * para a sessão atual.
     *
     * @return      string
     */
    public function retrieveSecurityStatus() : string
    {
        return $this->securityStatus;
    }





    /**
     * Informará ``true`` caso a implementação esteja apta a utilizar um
     * banco de dados.
     *
     * @return      bool
     */
    public function hasDataBase() : bool
    {
        return ($this->dbCredentials !== []);
    }



    /**
     * Coleção de credenciais de acesso ao banco de dados.
     *
     * @var         array
     */
    protected array $dbCredentials;
    /**
     * Objeto de conexão com o banco de dados para o UA atual.
     *
     * @var         iDAL
     */
    protected iDAL $DAL;
    /**
     * Retorna um objeto ``iDAL`` configurado com as credenciais correlacionadas
     * ao atual perfil de usuário sendo usado pelo UA.
     *
     * @return      iDAL
     */
    public function getDAL() : iDAL
    {
        if (isset($this->DAL) === false) {
            $userProfile = (
                ($this->retrieveUserProfileName() === null) ? "Anonymous" : $this->retrieveUserProfileName()
            );
            if (\key_exists($userProfile, $this->dbCredentials) === true) {
                $dbCredentials = $this->dbCredentials[$userProfile];

                $this->DAL = new \AeonDigital\DAL\DAL(
                    $dbCredentials["dbType"],
                    $dbCredentials["dbHost"],
                    $dbCredentials["dbName"],
                    $dbCredentials["dbUserName"],
                    $dbCredentials["dbUserPassword"],
                    ($dbCredentials["dbSSLCA"] ?? null),
                    ($dbCredentials["dbConnectionString"] ?? null)
                );
            }
        }
        return $this->DAL;
    }










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
     *              Nome da aplicação que deve responder a requisição ``Http`` atual.
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
        $this->now              = $now;
        $this->environment      = $environment;
        $this->applicationName  = $applicationName;
        $this->userAgent        = $userAgent;
        $this->userAgentIP      = $userAgentIP;
        $this->securityConfig   = $securityConfig;
        $this->securityCookie   = $securityCookie;

        if ($dbCredentials !== [] &&
            \key_exists($environment, $dbCredentials) === true &&
            \key_exists($applicationName, $dbCredentials[$environment]) === true) {
            $this->dbCredentials = $dbCredentials[$environment][$applicationName];
        }
        else {
            $this->dbCredentials = [];
        }

        if (\substr_count($userAgentIP, ":") === 1) {
            $this->userAgentIP = \strtok($userAgentIP, ":");
        }


        $this->mainCheckForInvalidArgumentException(
            "pathToLocalData", $pathToLocalData, [
                [
                    "conditions"    => "is string not empty",
                    "validate"      => "is dir exists"
                ]
            ]
        );
        $this->pathToLocalData  = \to_system_path($pathToLocalData);
    }
}
