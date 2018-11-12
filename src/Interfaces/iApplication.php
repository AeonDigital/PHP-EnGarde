<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Tools\Interfaces\iServerConfig as iServerConfig;
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
     * Retorna o objeto de configuração do Servidor.
     * 
     * @return      iServerConfig
     */
    function getServerConfig() : iServerConfig;
    /**
     * Define o objeto de configuração do servidor.
     *
     * @param       iServerConfig $serverConfig
     *              Configuração do Servidor.
     * 
     * @return      void
     */
    function setServerConfig(iServerConfig $serverConfig) : void;



    /**
     * Retorna o objeto de configuração do domínio.
     * 
     * @return      iDomainConfig
     */
    function getDomainConfig() : iDomainConfig;
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
     * Retorna o objeto de configuração para a aplicação corrente.
     * 
     * @return      iApplicationConfig
     */
    function getApplicationConfig() : iApplicationConfig;
    /**
     * Define a configuração para esta Aplicação.
     *
     * @param       iDomainConfig $applicationConfig
     *              Configuração da Aplicação.
     * 
     * @return      void
     */
    function setApplicationConfig(iApplicationConfig $applicationConfig) : void;




    /**
     * Retorna o objeto de configuração para a rota que deve ser
     * executada por esta aplicação.
     * Será retornado "null" caso nenhuma rota tenha sido identificada.
     *
     * @return      ?iRouteConfig
     */
    function getRouteConfig() : ?iRouteConfig;
    /**
     * Define a configuração para esta Aplicação.
     *
     * @param       ?iRouteConfig $routeConfig
     *              Configuração da rota a ser executada.
     * 
     * @return      void
     */
    function setRouteConfig(?iRouteConfig $routeConfig) : void;



    /**
     * Retorna um array associativo que traz as configurações
     * brutas para a rota que deve ser executada pela aplicação.
     *
     * @return      ?array
     */
    function getRawRouteConfig() : ?array;
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
     * Efetivamente inicia o processamento da rota.
     *
     * @return      void
     */
    function run() : void;
}
