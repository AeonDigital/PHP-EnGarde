<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Traits;

use AeonDigital\EnGarde\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\Http\Tools\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\EnGarde\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\iRouteConfig as iRouteConfig;




/**
 * Coleção de propriedades comuns a classes que devem resolver
 * rotas de uma aplicação EnGarde.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
trait CommomProperties
{





    /**
     * Instância das configurações do Domínio.
     *
     * @var         iDomainConfig
     */
    protected $domainConfig = null;
    /**
     * Define a configuração para o Domínio.
     *
     * @param       iDomainConfig $domainConfig
     *              Configuração do Domínio.
     * 
     * @return      void
     */
    public function setDomainConfig(iDomainConfig $domainConfig) : void
    {
        if ($this->domainConfig === null) {
            $this->domainConfig = $domainConfig;
        }
    }
    
    
    
    
    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    protected $serverConfig = null;
    /**
     * Define o objeto de configuração do Servidor.
     *
     * @param       iServerConfig $serverConfig
     *              Configuração do Servidor.
     * 
     * @return      void
     */
    public function setServerConfig(iServerConfig $serverConfig) : void
    {
        if ($this->serverConfig === null) {
            $this->serverConfig = $serverConfig;
        }
    }





    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    protected $serverRequest = null;
    /**
     * Define um objeto que representa a requisição
     * que está sendo resolvida.
     *
     * @param       iServerRequest $serverRequest
     *              Requisição.
     * 
     * @return      void
     */
    public function setServerRequest(iServerRequest $serverRequest) : void
    {
        if ($this->serverRequest === null) {
            $this->serverRequest = $serverRequest;
        }
    }




    /**
     * Configuraçõs para a Aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    protected $applicationConfig = null;
    /**
     * Define a configuração para a Aplicação corrente.
     *
     * @param       iApplicationConfig $applicationConfig
     *              Configuração da Aplicação.
     * 
     * @return      void
     */
    public function setApplicationConfig(iApplicationConfig $applicationConfig) : void
    {
        // Se presente, define as propriedades padrões
        // para as rotas da aplicação.
        $const = static::class . "::defaultRouteConfig";
        if (defined($const) === true) {
            $applicationConfig->setDefaultRouteConfig(static::defaultRouteConfig);
        }
        $this->applicationConfig = $applicationConfig;
    }




    /**
     * Nome do método que deve ser usado para resolver
     * a rota que está ativa no momento.
     *
     * @var         string
     */
    protected $runMethodName = "run";
    /**
     * Objeto que representa a configuração da rota alvo.
     *
     * @var         iRouteConfig
     */
    protected $routeConfig = null;
    /**
     * Define a configuração para a rota que deve ser executada.
     *
     * @param       ?iRouteConfig $routeConfig
     *              Configuração da rota a ser executada.
     * 
     * @return      void
     */
    public function setRouteConfig(?iRouteConfig $routeConfig) : void
    {
        if ($this->routeConfig === null && $routeConfig !== null) {
            $this->routeConfig = $routeConfig;
            $this->runMethodName = $routeConfig->getRunMethodName();
        }
    }





    /**
     * Objeto que representa a configuração bruta da rota alvo.
     *
     * @var         ?array
     */
    protected $rawRouteConfig = null;
    /**
     * Define a configuração em estado bruto para a rota como um todo,
     * incluindo todas as opções relativa a seus métodos HTTP aceitos.
     *
     * @param       ?array $rawRouteConfig
     *              Configuração bruta da rota a ser executada.
     * 
     * @return      void
     */
    public function setRawRouteConfig(?array $rawRouteConfig) : void
    {
        $this->rawRouteConfig = $rawRouteConfig;
    }
}
