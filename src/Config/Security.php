<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;







/**
 * Implementação de ``Config\iSecurity``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Security extends BObject implements iSecurity
{
    use \AeonDigital\Traits\MainCheckArgumentException;




    /**
     * Indica quando as configurações de segurança devem ou não serem usadas para a aplicação.
     *
     * @var         bool
     */
    private bool $isActive = false;
    /**
     * Retornará ``true`` se a aplicação estiver configurada para usar as definições de segurança.
     * Quando ``false`` indica que a aplicação é pública.
     *
     * @return      bool
     */
    public function getIsActive() : bool
    {
        return $this->isActive;
    }
    /**
     * Define se o modulo de segurança deve ou não estar ativado.
     *
     * @param       bool $isActive
     *
     * @return      void
     */
    private function setIsActive(bool $isActive) : void
    {
        $this->isActive = $isActive;
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
     * Define o nome do cookie que carrega informações da sessão atual do usuário.
     *
     * @param       string $dataCookieName
     *
     * @return      void
     */
    private function setDataCookieName(string $dataCookieName) : void
    {
        if ($this->isActive === true && $dataCookieName === "") {
            throw new \InvalidArgumentException(
                "An active secure session must have a \"dataCookieName\" defined."
            );
        }
        $this->dataCookieName = $dataCookieName;
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
     * Define o nome do cookie de autenticação.
     *
     * @param       string $securityCookieName
     *
     * @return      void
     */
    private function setSecurityCookieName(string $securityCookieName) : void
    {
        if ($this->isActive === true && $securityCookieName === "") {
            throw new \InvalidArgumentException(
                "An active secure session must have a \"securityCookieName\" defined."
            );
        }
        $this->securityCookieName = $securityCookieName;
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
     * Define a rota para o local onde o usuário faz login.
     *
     * @param       string $routeToLogin
     *
     * @return      void
     */
    private function setRouteToLogin(string $routeToLogin) : void
    {
        if ($this->isActive === true && $routeToLogin === "") {
            throw new \InvalidArgumentException(
                "An active secure session must have a \"routeToLogin\" defined."
            );
        }
        $this->routeToLogin = $routeToLogin;
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
     * Define a rota para o local onde o usuário deve ser direcionado quando efetua o login.
     *
     * @param       string $routeToStart
     *
     * @return      void
     */
    private function setRouteToStart(string $routeToStart) : void
    {
        if ($this->isActive === true && $routeToStart === "") {
            throw new \InvalidArgumentException(
                "An active secure session must have a \"routeToStart\" defined."
            );
        }
        $this->routeToStart = $routeToStart;
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
     * Define a rota para o local onde o usuário pode ir para efetuar o reset de sua senha.
     *
     * @param       string $routeToResetPassword
     *
     * @return      void
     */
    private function setRouteToResetPassword(string $routeToResetPassword) : void
    {
        if ($this->isActive === true && $routeToResetPassword === "") {
            throw new \InvalidArgumentException(
                "An active secure session must have a \"routeToResetPassword\" defined."
            );
        }
        $this->routeToResetPassword = $routeToResetPassword;
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
     * Define o Id do usuário anonimo da aplicação.
     *
     * @param       int $anonymousId
     *
     * @return      void
     */
    private function setAnonymousId(int $anonymousId) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "anonymousId", $anonymousId, ["is integer greather than zero"]
        );
        $this->anonymousId = $anonymousId;
    }





    /**
     * Namespace que aponta para uma classe que implemente a interface
     * ``AeonDigital\EnGarde\Interfaces\Engine\iSession`` e que será responsável
     * pelo controle da sessão.
     *
     * Se apresentar apenas o último nome, o mesmo será concatenado com a namespace
     * ``AeonDigital\EnGarde\SessionControl``.
     *
     * @var         string
     */
    private string $sessionNamespace = "AeonDigital\\EnGarde\\SessionControl\\NativeLocal";
    /**
     * Retorna o nome de uma classe que implemente a interface
     * ``AeonDigital\EnGarde\Interfaces\Engine\iSession`` e que será responsável pelo
     * controle das sessões de UA na aplicação.
     *
     * @return      string
     */
    public function getSessionNamespace() : string
    {
        return $this->sessionNamespace;
    }
    /**
     * Define a classe que deve ser usada para o controle das sessões de UA da aplicação.
     *
     * @param       string $sessionNamespace
     *
     * @return      void
     */
    private function setSessionNamespace(string $sessionNamespace) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "sessionNamespace", $sessionNamespace, [
                [
                    "validate" => "is class implements interface",
                    "interface" => "AeonDigital\EnGarde\Interfaces\Engine\iSession"
                ]
            ]
        );
        $this->sessionNamespace = $sessionNamespace;
    }





    /**
     * Define se as sessões devem ser renovadas a cada iteração do usuário.
     *
     * @var         bool
     */
    private bool $isSessionRenew = true;
    /**
     * Indica se as sessões devem ser renovar a cada iteração do usuário.
     * O padrão é ``true``.
     *
     * @return      bool
     */
    public function getIsSessionRenew() : bool
    {
        return $this->isSessionRenew;
    }
    /**
     * Define se as sessões devem ser renovadas a cada iteração do usuário.
     *
     * @param       bool $isSessionRenew
     *
     * @return      void
     */
    private function setIsSessionRenew(bool $isSessionRenew) : void
    {
        $this->isSessionRenew = $isSessionRenew;
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
     * Define o tempo (em minutos) que cada sessão deve suportar de inatividade.
     *
     * @param       int $sessionTimeout
     *
     * @return      void
     */
    private function setSessionTimeout(int $sessionTimeout) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "sessionTimeout", $sessionTimeout, ["is integer greather than zero"]
        );
        $this->sessionTimeout = $sessionTimeout;
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
     * Define o limite de falhas de login permitidas para um mesmo ``IP`` em um determinado periodo.
     *
     * @param       int $allowedFaultByIP
     *
     * @return      void
     */
    private function setAllowedFaultByIP(int $allowedFaultByIP) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "allowedFaultByIP", $allowedFaultByIP, ["is integer greather than zero"]
        );
        $this->allowedFaultByIP = $allowedFaultByIP;
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
     * Define o tempo de bloqueio para um IP [em minutos].
     *
     * @param       int $ipBlockTimeout
     *
     * @return      void
     */
    private function setIPBlockTimeout(int $ipBlockTimeout) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "ipBlockTimeout", $ipBlockTimeout, ["is integer greather than zero"]
        );
        $this->ipBlockTimeout = $ipBlockTimeout;
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
     * Define o limite de falhas permitidas para erros sucessivos de senha para um mesmo login.
     *
     * @param       int $allowedFaultByLogin
     *
     * @return      void
     */
    private function setAllowedFaultByLogin(int $allowedFaultByLogin) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "allowedFaultByLogin", $allowedFaultByLogin, ["is integer greather than zero"]
        );
        $this->allowedFaultByLogin = $allowedFaultByLogin;
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
     * Define o tempo de bloqueio para um Login [em minutos].
     *
     * @param       int $loginBlockTimeout
     *
     * @return      void
     */
    private function setLoginBlockTimeout(int $loginBlockTimeout) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "loginBlockTimeout", $loginBlockTimeout, ["is integer greather than zero"]
        );
        $this->loginBlockTimeout = $loginBlockTimeout;
    }





    /**
     * Coleção de intervalos de IPs que tem permissão de acessar a aplicação.
     *
     * @var         array
     */
    private array $allowedIPRanges = [];
    /**
     * Retorna uma coleção de intervalos de IPs que tem permissão de acessar a aplicação.
     *
     * Isto implica em dizer que a regra de segurança excluirá de acesso toda requisição que
     * venha de um IP que não esteja na lista previamente definida.
     * [tudo é proibido até que seja liberado]
     *
     * @return      array
     */
    public function getAllowedIPRanges() : array
    {
        return $this->allowedIPRanges;
    }
    /**
     * Define uma coleção de intervalos de IPs que tem permissão de acessar a aplicação.
     *
     * @param       array $allowedIPRanges
     *              Coleção de IPs válidos.
     *
     * @return      void
     */
    private function setAllowedIPRanges(array $allowedIPRanges) : void
    {
        $this->allowedIPRanges = $allowedIPRanges;
    }



    /**
     * Coleção de intervalos de IPs que estão bloqueados de acessar a aplicação.
     *
     * @var         array
     */
    private array $deniedIPRanges = [];
    /**
     * Retorna uma coleção de intervalos de IPs que estão bloqueados de acessar a aplicação.
     *
     * Isto implica em dizer que a regra de segurança permitirá o acesso de toda requisição que
     * venha de um IP que não esteja na lista previamente definida.
     * [tudo é permitido até que seja bloqueado]
     *
     * @return      array
     */
    public function getDeniedIPRanges() : array
    {
        return $this->deniedIPRanges;
    }
    /**
     * Define uma coleção de intervalos de IPs que estão bloqueados de acessar a aplicação.
     *
     * @param       array $deniedIPRanges
     *              Coleção de IPs válidos.
     *
     * @return      void
     */
    private function setDeniedIPRanges(array $deniedIPRanges) : void
    {
        $this->deniedIPRanges = $deniedIPRanges;
    }





    /**
     * Identifia se o IP informado está dentro dos ranges definidos como válidos para o
     * acesso a esta aplicação.
     *
     * As regras ``AllowedIPRanges`` e ``DeniedIPRanges`` são auto-excludentes, ou seja, apenas
     * uma delas pode estar valendo e, na presença de ambos conjuntos existirem, a regra
     * ``AllowedIPRanges`` (que é mais restritiva) é que prevalecerá para este teste.
     *
     * Se nenhuma das regras estiver definido, todas as requisições serão aceitas.
     *
     * @param       string $ip
     *              IP que será testado em seu formato ``human readable``.
     *
     * @return      bool
     */
    public function isAllowedIP(string $ip) : bool
    {
        $addrIP = inet_pton($ip);
        $allowedIPRanges = $this->getAllowedIPRanges();
        $deniedIPRanges = $this->getDeniedIPRanges();


        if ($allowedIPRanges !== []) {
            $matchRange = false;

            foreach ($allowedIPRanges as $range) {
                if ($matchRange === false) {
                    $matchRange = ($addrIP >= inet_pton($range[0]) && $addrIP <= inet_pton($range[1]));
                }
            }
            return $matchRange;
        }
        elseif ($deniedIPRanges !== []) {
            $matchRange = false;

            foreach ($deniedIPRanges as $range) {
                if ($matchRange === false) {
                    $matchRange = ($addrIP >= inet_pton($range[0]) && $addrIP <= inet_pton($range[1]));
                }
            }
            return !$matchRange;
        }

        return true;
    }










    /**
     * Inicia uma instância que armazena as configurações de segurança para uma aplicação.
     *
     * @param       bool $isActive
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
     * @param       string $sessionNamespace
     *              Namespace da classe de controle de sessão.
     *
     * @param       bool $isSessionRenew
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
     * @param       array $allowedIPRanges
     *              Coleção de intervalos de Ips que tem acesso a aplicação.
     *
     * @param       array $deniedIPRanges
     *              Coleção de intervalos de Ips que devem ser bloqueados de acesso.
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function __construct(
        bool $isActive,
        string $dataCookieName,
        string $securityCookieName,
        string $routeToLogin,
        string $routeToStart,
        string $routeToResetPassword,
        int $anonymousId,
        string $sessionNamespace,
        bool $isSessionRenew,
        int $sessionTimeout,
        int $allowedFaultByIP,
        int $ipBlockTimeout,
        int $allowedFaultByLogin,
        int $loginBlockTimeout,
        array $allowedIPRanges,
        array $deniedIPRanges
    ) {
        $this->setIsActive($isActive);
        $this->setDataCookieName($dataCookieName);
        $this->setSecurityCookieName($securityCookieName);
        $this->setRouteToLogin($routeToLogin);
        $this->setRouteToStart($routeToStart);
        $this->setRouteToResetPassword($routeToResetPassword);
        $this->setAnonymousId($anonymousId);
        $this->setSessionNamespace($sessionNamespace);
        $this->setIsSessionRenew($isSessionRenew);
        $this->setSessionTimeout($sessionTimeout);
        $this->setAllowedFaultByIP($allowedFaultByIP);
        $this->setIpBlockTimeout($ipBlockTimeout);
        $this->setAllowedFaultByLogin($allowedFaultByLogin);
        $this->setLoginBlockTimeout($loginBlockTimeout);
        $this->setAllowedIPRanges($allowedIPRanges);
        $this->setDeniedIPRanges($deniedIPRanges);
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
        // Define os valores padrões para a instância e
        // sobrescreve-os com os valores informados em $config
        $useValues = array_merge([
            "isActive"              => false,
            "dataCookieName"        => "dateg",
            "securityCookieName"    => "seceg",
            "routeToLogin"          => "/login",
            "routeToStart"          => "/home",
            "routeToResetPassword"  => "/resetpassword",
            "anonymousId"           => 1,
            "sessionNamespace"      => "AeonDigital\\EnGarde\\SessionControl\\NativeLocal",
            "isSessionRenew"        => true,
            "sessionTimeout"        => 40,
            "allowedFaultByIP"      => 50,
            "ipBlockTimeout"        => 50,
            "allowedFaultByLogin"   => 5,
            "loginBlockTimeout"     => 20,
            "allowedIPRanges"       => [],
            "deniedIPRanges"        => []
        ],
        $config);

        return new Security(
            $useValues["isActive"],
            $useValues["dataCookieName"],
            $useValues["securityCookieName"],
            $useValues["routeToLogin"],
            $useValues["routeToStart"],
            $useValues["routeToResetPassword"],
            $useValues["anonymousId"],
            $useValues["sessionNamespace"],
            $useValues["isSessionRenew"],
            $useValues["sessionTimeout"],
            $useValues["allowedFaultByIP"],
            $useValues["ipBlockTimeout"],
            $useValues["allowedFaultByLogin"],
            $useValues["loginBlockTimeout"],
            $useValues["allowedIPRanges"],
            $useValues["deniedIPRanges"]
        );
    }
}
