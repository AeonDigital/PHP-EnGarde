<?php
declare (strict_types = 1);

namespace AeonDigital\Domain\Interfaces;

use AeonDigital\Domain\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\Domain\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\Domain\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;




/**
 * Define uma interface para uma classe capaz de
 * produzir uma view a ser enviada ao UA.
 * 
 * @package     AeonDigital\Domain
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iResponseHandler
{





    /**
     * Define uma instância iDomainConfig contendo
     * as configurações atuais do domínio.
     *
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     * 
     * @return      void
     */
    public function setDomainConfig(iDomainConfig $domainConfig) : void;
 
 
    /**
     * Define uma instância iApplicationConfig contendo
     * as configurações atuais da aplicação.
     *
     * @param       iApplicationConfig $appConfig
     *              Instância "iApplicationConfig".
     * 
     * @return      void
     */
    public function setAppConfig(iApplicationConfig $appConfig) : void;


    /**
     * Define uma instância iRouteConfig contendo
     * as configurações atuais da rota.
     *
     * @param       iRouteConfig $routeConfig
     *              Instância "iRouteConfig".
     * 
     * @return      void
     */
    public function setRouteConfig(iRouteConfig $routeConfig) : void;



    /**
     * Define o objeto "request" com as exigencias do UA.
     *
     * @param       iServerRequest $serverRequest
     *              Objeto "iServerRequest".
     * 
     * @return      void
     */
    public function setServerRequest(iServerRequest $serverRequest) : void;





    /**
     * Define o objeto "response" contendo o conteúdo bruto
     * que deve ser preparado para envio ao UA.
     * 
     * O conteúdo bruto esperado deve estar especificado nas 
     * propriedades "viewData" e "routeConfig".
     *
     * @param       iResponse $response
     *              Objeto "iResponse".
     * 
     * @return      void
     */
    public function setResponse(iResponse $response) : void;





    /**
     * Efetua a negociação de conteúdo para identificar
     * de que forma os dados devem ser retornados ao UA.
     *
     * @return      void
     */
    public function executeContentNegotiation() : void;





    /**
     * Prepara o objeto "response" para responder a uma 
     * requisição em que foi usado o método http "OPTIONS"
     * 
     * @param       array $rawRouteConfigs
     *              Configurações dos diferentes métodos
     *              aceitos pela rota atual.
     *
     * @return      void
     */
    public function prepareResponseToOPTIONS(array $rawRouteConfigs) : void;


    /**
     * Efetua o envio dos dados para o UA.
     *
     * @return      void
     */
    public function sendResponse() : void;
}
