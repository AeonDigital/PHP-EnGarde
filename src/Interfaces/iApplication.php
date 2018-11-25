<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Tools\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\EnGarde\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\iRouteConfig as iRouteConfig;




/**
 * Define uma aplicação que pode ser manipulada pelo 
 * Gerenciador de Domínio **AeonDigital/EnGarde/DomainManager**.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iApplication
{





    /**
     * Define a configuração para o Domínio.
     *
     * @param       iDomainConfig $domainConfig
     *              Configuração do Domínio.
     * 
     * @return      void
     */
    function setDomainConfig(iDomainConfig $domainConfig) : void;


    /**
     * Define o objeto de configuração do Servidor.
     *
     * @param       iServerConfig $serverConfig
     *              Configuração do Servidor.
     * 
     * @return      void
     */
    function setServerConfig(iServerConfig $serverConfig) : void;


    /**
     * Define um objeto que representa a requisição
     * que está sendo resolvida.
     *
     * @param       iServerRequest $serverRequest
     *              Requisição.
     * 
     * @return      void
     */
    function setServerRequest(iServerRequest $serverRequest) : void;


    /**
     * Define a configuração para a Aplicação corrente.
     *
     * @param       iApplicationConfig $applicationConfig
     *              Configuração da Aplicação.
     * 
     * @return      void
     */
    function setApplicationConfig(iApplicationConfig $applicationConfig) : void;


    /**
     * Define a configuração para a rota que deve ser executada.
     *
     * @param       ?iRouteConfig $routeConfig
     *              Configuração da rota a ser executada.
     * 
     * @return      void
     */
    function setRouteConfig(?iRouteConfig $routeConfig) : void;


    /**
     * Define a configuração em estado bruto para a rota como um todo,
     * incluindo todas as opções relativa a seus métodos HTTP aceitos.
     *
     * @param       ?array $rawRouteConfig
     *              Configuração bruta da rota a ser executada.
     * 
     * @return      void
     */
    function setRawRouteConfig(?array $rawRouteConfig) : void;





    /**
     * Permite configurar ou redefinir o objeto de configuração
     * da aplicação na classe concreta da mesma.
     */
    function configureApplication() : void;



    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
    function run() : void;
}
