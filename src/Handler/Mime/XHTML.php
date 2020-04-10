<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler\Mime;

use AeonDigital\EnGarde\Handler\Mime\aMime as aMime;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\Config\iDomain as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;


/**
 * Manipulador para gerar documentos XHTML.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class XHTML extends aMime
{





    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância ``iServerConfig``.
     *
     * @param       iDomainConfig $domainConfig
     *              Instância ``iDomainConfig``.
     *
     * @param       iApplicationConfig $applicationConfig
     *              Instância ``iApplicationConfig``.
     *
     * @param       iServerRequest $serverRequest
     *              Instância ``iServerRequest``.
     *
     * @param       array $rawRouteConfig
     *              Instância ``iServerConfig``.
     *
     * @param       iRouteConfig $routeConfig
     *              Instância ``iRouteConfig``.
     *
     * @param       iResponse $response
     *              Instância ``iResponse``.
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
     * Gera uma string que representa a resposta a ser enviada para o ``UA``, compatível com o
     * mimetype que esta classe está apta a manipular.
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


        $masterContent = (($masterContent === "") ? "<view />" : $masterContent);


        // Mescla os dados obtidos
        $body = \str_replace("<view />",          $viewContent, $masterContent);
        $body = \str_replace("<metatags />",      $strMetaData, $body);
        $body = \str_replace("<stylesheets />",   $strStyleSheet, $body);
        $body = \str_replace("<javascripts />",   $strJavaScript, $body);

        $body = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . $body;
        $htmlProp = "xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".$this->routeConfig->getResponseLocale()."\"";
        $body = \str_replace("data-eg-html-prop=\"\"", $htmlProp, $body);


        // Aplica "prettyPrint" caso seja requisitado
        if ($this->routeConfig->getResponseIsPrettyPrint() === true) {
            $body = $this->prettyPrintXHTMLDocument($body, "xhtml");
        }

        return $body;
    }
}
