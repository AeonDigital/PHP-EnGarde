<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\MimeHandler;

use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Config\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Config\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Config\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Config\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\EnGarde\MimeHandler\aMimeHandler as aMimeHandler;


/**
 * Manipulador para gerar documentos HTML.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
class HTML extends aMimeHandler
{





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
        parent::__construct(
            $serverConfig,
            $domainConfig,
            $applicationConfig,
            $serverRequest,
            $rawRouteConfig,
            $routeConfig,
            $response
        );
    }





    /**
     * Gera uma string que representa a resposta a ser enviada
     * para o UA, compatível com o mimetype que esta classe está
     * apta a manipular.
     * 
     * @return      string
     */
    public function createResponseBody() : string
    {
        $body = "";
        $viewContent    = $this->processViewContent();
        $masterContent  = $this->processMasterPageContent();
        $strMetaData    = $this->processXHTMLMetaData();
        $strStyleSheet  = $this->processXHTMLStyleSheets();
        $strJavaScript  = $this->processXHTMLJavaScripts();


        // Mescla os dados obtidos
        $body = str_replace("<view />",          $viewContent, $masterContent);
        $body = str_replace("<metatags />",      $strMetaData, $body);
        $body = str_replace("<stylesheets />",   $strStyleSheet, $body);
        $body = str_replace("<javascripts />",   $strJavaScript, $body);

        $htmlProp = "lang=\"".$this->routeConfig->getResponseLocale()."\"";
        $body = str_replace("data-eg-html-prop=\"\"", $htmlProp, $body);


        // Aplica "prettyPrint" caso seja requisitado
        if ($this->routeConfig->getResponseIsPrettyPrint() === true) {
            $body = $this->prettyPrintXHTMLDocument($body, "html");
        }

        return $body;
    }
}
