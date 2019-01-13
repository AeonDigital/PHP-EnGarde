<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Config\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Config\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Config\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Config\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\iController as iController;







/**
 * Classe abstrata que deve ser herdada pelos controllers
 * das aplicações.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
abstract class DomainController implements iController
{





    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    protected $serverConfig = null;
    /**
     * Instância das configurações do Domínio.
     *
     * @var         iDomainConfig
     */
    protected $domainConfig = null;
    /**
     * Configuraçõs para a Aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    protected $applicationConfig = null;
    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    protected $serverRequest = null;
    /**
     * Objeto que representa a configuração bruta da rota alvo.
     *
     * @var         ?array
     */
    protected $rawRouteConfig = null;
    /**
     * Objeto que representa a configuração da rota alvo.
     *
     * @var         iRouteConfig
     */
    protected $routeConfig = null;
    /**
     * Objeto "iResponse".
     *
     * @var         iResponse
     */
    protected $response = null;
    /**
     * Objeto "StdClass".
     * Deve ser preenchido durante a execução da Action 
     * e poderá ser acessado nas views.
     * 
     * Tem como finalidade agregar todas as informações que o UA
     * está requisitando.
     *
     * @var         \StdClass
     */
    protected $viewData = null;
    /**
     * Objeto "StdClass".
     * Deve ser preenchido durante a execução da Action 
     * e poderá ser acessado nas views.
     * 
     * Tem como finalidade agregar informações que sirvam para
     * a criação da view e não devem ser expostas ao UA.
     *
     * @var         \StdClass
     */
    protected $viewConfig = null;










    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     * 
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     * 
     * @param       iApplicationConfig $applicationConfig
     *              Instância "iApplicationConfig".
     * 
     * @param       iServerRequest $serverRequest
     *              Instância "iServerRequest".
     * 
     * @param       array $rawRouteConfig
     *              Instância "iServerConfig".
     * 
     * @param       iRouteConfig $routeConfig
     *              Instância "iRouteConfig".
     * 
     * @param       iResponse $response
     *              Instância "iResponse".
     */
    function __construct(
        iServerConfig $serverConfig,
        iDomainConfig $domainConfig,
        iApplicationConfig $applicationConfig,
        iServerRequest $serverRequest,
        array $rawRouteConfig,
        iRouteConfig $routeConfig,
        iResponse $response
    ) {
        $this->serverConfig         = $serverConfig;
        $this->domainConfig         = $domainConfig;
        $this->applicationConfig    = $applicationConfig;
        $this->serverRequest        = $serverRequest;
        $this->rawRouteConfig       = $rawRouteConfig;
        $this->routeConfig          = $routeConfig;
        $this->response             = $response;

        $this->viewData = new \StdClass();
        $this->viewConfig = new \StdClass();
    }





    /**
     * Retorna a instância "iResponse".
     * Aplica no objeto "iResponse" as propriedades 
     * "viewData" (obtido do resultado da execução da action);
     * "viewConfig" (obtido com a manipulação das propriedades variáveis do objeto "routeConfig");
     * "headers" (padrões + os definidos pela action)
     * 
     * @return      iResponse
     */
    public function getResponse() : iResponse
    {
        $useViewConfig = $this->routeConfig->getActionAttributes();
        foreach ($this->viewConfig as $key => $value) {
            if (isset($useViewConfig[$key]) === false) {
                $useViewConfig[$key] = $value;
            }
        }

        return $this->response->withActionProperties(
            $this->viewData, 
            (object)$useViewConfig,
            $this->routeConfig->getResponseHeaders()
        );
    }
}
