<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Engine\iSession as iSession;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;
use AeonDigital\EnGarde\SessionControl\Enum\BrowseStatus as BrowseStatus;
use AeonDigital\EnGarde\SessionControl\Enum\SecurityStatus as SecurityStatus;
use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;



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





    protected string $sessionType;
    /**
     * Retorna o tipo de sessão que a instância concreta representa.
     *
     * @return      string
     */
    public function retrieveSessionType() : string
    {
        return $this->sessionType;
    }





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
     * Nome da aplicação que deve responder a requisição ``HTTP`` atual.
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
    public function retrieveAuthenticatedSession() : ?array
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
    public function retrieveAuthenticatedUser() : ?array
    {
        return $this->authenticatedUser;
    }
    /**
     * Retorna o perfil de segurança do usuário atualmente em uso.
     *
     * @return      ?string
     */
    public function retrieveAuthenticatedUserProfile() : ?string
    {
        return ($this->authenticatedUser === null) ? null : $this->authenticatedUser["ProfileInUse"];
    }
    /**
     * Retorna uma coleção de perfis de segurança que o usuário tem autorização de utilizar.
     *
     * @return      ?array
     */
    public function retrieveAuthenticatedUserProfiles() : ?array
    {
        return ($this->authenticatedUser === null) ? null : $this->authenticatedUser["Profiles"];
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
     * Status atual da navegação do UA.
     *
     * @var         string
     */
    protected string $browseStatus = BrowseStatus::Unchecked;
    /**
     * Retorna o status atual da navegação do UA.
     *
     * @return      string
     */
    public function retrieveBrowseStatus() : string
    {
        return $this->browseStatus;
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
        $this->now              = $now;
        $this->environment      = $environment;
        $this->applicationName  = $applicationName;
        $this->userAgent        = $userAgent;
        $this->userAgentIP      = $userAgentIP;
        $this->securityConfig   = $securityConfig;
        $this->securityCookie   = $securityCookie;


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
