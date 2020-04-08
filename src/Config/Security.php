<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;








/**
 * Implementação de ``iSecurity``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Security implements iSecurity
{





    /**
     * Indica quando as configurações de segurança devem ou não serem usadas para a aplicação.
     *
     * @var         bool
     */
    private bool $active = false;
    /**
     * Retornará ``true`` se a aplicação estiver configurada para usar as definições de segurança.
     * Quando ``false`` indica que a aplicação é pública.
     *
     * @return      bool
     */
    public function isActive() : bool
    {
        return $this->active;
    }



    /**
     * Nome do cookie que carrega informações da sessão atual do usuário.
     *
     * @var         string
     */
    private string $dataCookieName = "";
    /**
     * Retornará o nome do cookie que carrega informações da sessão atual do usuário.
     *
     * @return      string
     */
    public function getDataCookieName() : string
    {
        return $this->dataCookieName;
    }



    /**
     * Nome do cookie de autenticação.
     *
     * @var         string
     */
    private string $securityCookieName = "";
    /**
     * Retornará o nome do cookie de autenticação.
     *
     * @return      string
     */
    public function getSecurityCookieName() : string
    {
        return $this->securityCookieName;
    }



    /**
     * Rota para o local onde o usuário faz login.
     *
     * @var         string
     */
    private string $routeToLogin = "";
    /**
     * Retorna a rota para o local onde o usuário faz login.
     *
     * @return      string
     */
    public function getRouteToLogin() : string
    {
        return $this->routeToLogin;
    }



    /**
     * Rota para o local onde o usuário deve ser direcionado quando efetua o login.
     *
     * @var         string
     */
    private string $routeToStart = "";
    /**
     * Retorna a rota para o local onde o usuário deve ser direcionado quando efetua o login.
     *
     * @return      string
     */
    public function getRouteToStart() : string
    {
        return $this->routeToStart;
    }



    /**
     * Rota para o local onde o usuário pode ir para efetuar o reset de sua senha.
     *
     * @var         string
     */
    private string $routeToResetPassword = "";
    /**
     * Retorna a rota para o local onde o usuário pode ir para efetuar o reset de sua senha.
     *
     * @return      string
     */
    public function getRouteToResetPassword() : string
    {
        return $this->routeToResetPassword;
    }



    /**
     * Id do usuário anonimo da aplicação.
     *
     * @var         int
     */
    private int $anonymousId = 1;
    /**
     * Retornará o Id do usuário anonimo da aplicação.
     *
     * @return      int
     */
    public function getAnonymousId() : int
    {
        return $this->anonymousId;
    }



    /**
     * Tipo de sessão/local onde ela é armazenada.
     *
     * @var         string
     */
    private string $sessionType = "local";
    /**
     * Retorna o tipo de sessão que está sendo usada.
     * - "local"     :  A sessão autenticada do usuário é armazenada na própria aplicação.
     * - "database"  :  A sessão é armazenada num banco de dados.
     *
     * O formato ``local`` deve ser utilizado apenas quando não há realmente um banco de dados
     * disponível.
     *
     * @return      string
     */
    public function getSessionType() : string
    {
        return $this->sessionType;
    }



    /**
     * Define se as sessões devem ser renovadas a cada iteração do usuário.
     *
     * @var         bool
     */
    private bool $sessionRenew = true;
    /**
     * Indica se as sessões devem ser renovar a cada iteração do usuário.
     * O padrão é ``true``.
     *
     * @return      bool
     */
    public function isSessionRenew() : bool
    {
        return $this->sessionRenew;
    }



    /**
     * Tempo (em minutos) que cada sessão deve suportar de inatividade.
     *
     * @var         int
     */
    private int $sessionTimeout = 40;
    /**
     * Retornará o tempo (em minutos) que cada sessão deve suportar de inatividade.
     * O padrão são 40 minutos.
     *
     * @return      int
     */
    public function getSessionTimeout() : int
    {
        return $this->sessionTimeout;
    }



    /**
     * Limite de falhas de login permitidas para um mesmo ``IP`` em um determinado periodo.
     *
     * @var         int
     */
    private int $allowedFaultByIP = 50;
    /**
     * Retornará o limite de falhas de login permitidas para um mesmo ``IP`` em um determinado
     * periodo. O padrão são 50 tentativas.
     *
     * @return      int
     */
    public function getAllowedFaultByIP() : int
    {
        return $this->allowedFaultByIP;
    }



    /**
     * Tempo de bloqueio para um IP [em minutos].
     *
     * @var         int
     */
    private int $ipBlockTimeout = 50;
    /**
     * Retornará o tempo de bloqueio para um ``IP`` [em minutos].
     * O padrão são 50 minutos.
     *
     * @return      int
     */
    public function getIPBlockTimeout() : int
    {
        return $this->ipBlockTimeout;
    }



    /**
     * Limite de falhas permitidas para erros sucessivos de senha para um mesmo login.
     *
     * @var         int
     */
    private int $allowedFaultByLogin = 5;
    /**
     * Retornará o limite de falhas permitidas para erros sucessivos de senha para um mesmo login.
     * O padrão são 5 tentativas.
     *
     * @return      int
     */
    public function getAllowedFaultByLogin() : int
    {
        return $this->allowedFaultByLogin;
    }



    /**
     * Tempo de bloqueio para um Login [em minutos].
     *
     * @var         int
     */
    private int $loginBlockTimeout = 20;
    /**
     * Retornará o tempo de bloqueio para um Login [em minutos].
     * O padrão são 20 minutos.
     *
     * @return      int
     */
    public function getLoginBlockTimeout() : int
    {
        return $this->loginBlockTimeout;
    }













    /**
     * Inicia uma instância que armazena as configurações de segurança para uma aplicação.
     *
     * @param       bool $active
     *              Indica quando as configurações de segurança devem ou não serem usadas para
     *              a aplicação.
     *
     * @param       string $dataCookieName
     *              Nome do cookie que carrega informações da sessão atual do usuário.
     *
     * @param       string $securityCookieName
     *              Nome do cookie de autenticação.
     *
     * @param       string $routeToLogin
     *              Rota para o local onde o usuário faz login.
     *
     * @param       string $routeToStart
     *              Rota para o local onde o usuário deve ser direcionado quando efetua o login.
     *
     * @param       string $routeToResetPassword
     *              Rota para o local onde o usuário pode ir para efetuar o reset de sua senha.
     *
     * @param       int $anonymousId
     *              Id do usuário anonimo da aplicação.
     *
     * @param       string $sessionType
     *              Tipo de sessão/local onde ela é armazenada.
     *
     * @param       bool $sessionRenew
     *              Define se as sessões devem ser renovadas a cada iteração do usuário.
     *
     * @param       int $sessionTimeout
     *              Tempo (em minutos) que cada sessão deve suportar de inatividade.
     *
     * @param       int $allowedFaultByIP
     *              Limite de falhas de login permitidas para um mesmo IP em um determinado periodo.
     *
     * @param       int $ipBlockTimeout
     *              Tempo de bloqueio para um IP [em minutos].
     *
     * @param       int $allowedFaultByLogin
     *              Limite de falhas permitidas para erros sucessivos de senha para um mesmo login.
     *
     * @param       int $loginBlockTimeout
     *              Tempo de bloqueio para um Login [em minutos].
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function __construct(
        bool $active,
        string $dataCookieName,
        string $securityCookieName,
        string $routeToLogin,
        string $routeToStart,
        string $routeToResetPassword,
        int $anonymousId = 1,
        string $sessionType = "local",
        bool $sessionRenew = true,
        int $sessionTimeout = 40,
        int $allowedFaultByIP = 50,
        int $ipBlockTimeout = 50,
        int $allowedFaultByLogin = 5,
        int $loginBlockTimeout = 20
    ) {
        if ($active === true) {
            if ($dataCookieName === "") {
                throw new \InvalidArgumentException("An active secure session must have a \"dataCookieName\" defined.");
            }
            if ($securityCookieName === "") {
                throw new \InvalidArgumentException("An active secure session must have a \"securityCookieName\" defined.");
            }
            if ($routeToLogin === "") {
                throw new \InvalidArgumentException("An active secure session must have a \"routeToLogin\" defined.");
            }
            if ($routeToStart === "") {
                throw new \InvalidArgumentException("An active secure session must have a \"routeToStart\" defined.");
            }
            if ($routeToResetPassword === "") {
                throw new \InvalidArgumentException("An active secure session must have a \"routeToResetPassword\" defined.");
            }
        }

        if ($anonymousId <= 0) {
            throw new \InvalidArgumentException("\"anonymousId\" must be a integer granther than zero.");
        }

        $sessionType = strtolower($sessionType);
        if (in_array($sessionType, ["local", "database"]) === false) {
            throw new \InvalidArgumentException("Session type must be \"local\" or \"database\".");
        }

        if ($sessionTimeout < 0) {
            throw new \InvalidArgumentException("\"sessionTimeout\" must be a integer equal or granther than zero.");
        }
        if ($allowedFaultByIP < 0) {
            throw new \InvalidArgumentException("\"allowedFaultByIP\" must be a integer equal or granther than zero.");
        }
        if ($ipBlockTimeout < 0) {
            throw new \InvalidArgumentException("\"ipBlockTimeout\" must be a integer equal or granther than zero.");
        }
        if ($allowedFaultByLogin < 0) {
            throw new \InvalidArgumentException("\"allowedFaultByLogin\" must be a integer equal or granther than zero.");
        }
        if ($loginBlockTimeout < 0) {
            throw new \InvalidArgumentException("\"loginBlockTimeout\" must be a integer equal or granther than zero.");
        }


        $this->active               = $active;
        $this->dataCookieName       = $dataCookieName;
        $this->securityCookieName   = $securityCookieName;
        $this->routeToLogin         = $routeToLogin;
        $this->routeToStart         = $routeToStart;
        $this->routeToResetPassword = $routeToResetPassword;
        $this->anonymousId          = $anonymousId;
        $this->sessionType          = $sessionType;
        $this->sessionRenew         = $sessionRenew;
        $this->sessionTimeout       = $sessionTimeout;
        $this->allowedFaultByIP     = $allowedFaultByIP;
        $this->ipBlockTimeout       = $ipBlockTimeout;
        $this->allowedFaultByLogin  = $allowedFaultByLogin;
        $this->loginBlockTimeout    = $loginBlockTimeout;
    }





    /**
     * Retorna uma instância configurada a partir de um array que contenha
     * as chaves correlacionadas a cada propriedade aqui definida.
     *
     * @param       array $config
     *              Array associativo contendo os valores a serem definidos para a instância.
     *
     * @return      iSecurity
     */
    public static function fromArray(array $config) : iSecurity
    {
        $useValues = array_merge([
            "active"                => false,
            "dataCookieName"        => "",
            "securityCookieName"    => "",
            "routeToLogin"          => "",
            "routeToStart"          => "",
            "routeToResetPassword"  => "",
            "anonymousId"           => 1,
            "sessionType"           => "local",
            "sessionRenew"          => true,
            "sessionTimeout"        => 40,
            "allowedFaultByIP"      => 50,
            "ipBlockTimeout"        => 50,
            "allowedFaultByLogin"   => 5,
            "loginBlockTimeout"     => 20
        ],
        $config);

        return new \AeonDigital\EnGarde\Config\Security(
            $useValues["active"],
            $useValues["dataCookieName"],
            $useValues["securityCookieName"],
            $useValues["routeToLogin"],
            $useValues["routeToStart"],
            $useValues["routeToResetPassword"],
            $useValues["anonymousId"],
            $useValues["sessionType"],
            $useValues["sessionRenew"],
            $useValues["sessionTimeout"],
            $useValues["allowedFaultByIP"],
            $useValues["ipBlockTimeout"],
            $useValues["allowedFaultByLogin"],
            $useValues["loginBlockTimeout"]
        );
    }
}
