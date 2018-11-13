<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Tools\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\iRouteConfig as iRouteConfig;



/**
 * Interface para uma classe que tem por objetivo produzir
 * uma View a ser enviada para o UA.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iResponseHandler
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
     * @param       iDomainConfig $applicationConfig
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
     * Define o objeto "response" contendo o conteúdo bruto
     * que deve ser preparado para envio ao UA.
     * 
     * O conteúdo bruto esperado deve estar especificado nas 
     * propriedades "viewData" e "routeConfig".
     *
     * @param       iResponse 
     *              $response       Objeto "iResponse".
     * 
     * @return      void
     */
    function setResponse(iResponse $response) : void;
    /**
     * Resgata o objeto "iResponse" atualmente definido.
     *
     * @return      iResponse
     */
    function getResponse() : iResponse;





    /**
     * Efetua a negociação de conteúdo para identificar
     * de que forma os dados devem ser retornados ao UA.
     * 
     * Deve ser executado após o processamento da rota.
     *
     * @return      void
     */
    function executeContentNegotiation() : void;



    /**
     * Prepara o objeto "response" para responder a uma
     * requisição em que foi usado o método HTTP OPTIONS.
     *
     * @return      void
     */
    function prepareResponseToOPTIONS() : void;



    /**
     * Prepara o objeto "response" para responder a uma
     * requisição em que foi usado o método HTTP TRACE.
     *
     * @return      void
     */
    function prepareResponseToTRACE() : void;



    /**
     * Efetua o envio dos dados para o UA.
     * 
     * Deve ser executado após o processamento da rota.
     *
     * @return      void
     */
    function sendResponse() : void;
}
