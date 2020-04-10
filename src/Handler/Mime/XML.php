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
 * Manipulador para gerar documentos XML.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class XML extends aMime
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
        $hasTemplate = (
            $this->routeConfig->getView() !== "" ||
            $this->routeConfig->getMasterPage() !== ""
        );


        if ($hasTemplate === true) {
            $viewContent    = $this->processViewContent();
            $masterContent  = $this->processMasterPageContent();

            $masterContent = (($masterContent === "") ? "<view />" : $masterContent);
            // Mescla os dados obtidos
            $body = \str_replace("<view />", $viewContent, $masterContent);
        }
        else {
            $viewData = $this->response->getViewData();
            if ($viewData !== null) {
                $xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\"?><root></root>");
                $this->convertArrayToXML((array)$viewData, $xml);
                $body = $xml->asXML();
            }
        }


        // Aplica "prettyPrint" caso seja requisitado
        if ($this->routeConfig->getResponseIsPrettyPrint() === true) {
            $body = $this->prettyPrintXMLDocument($body);
        }

        return $body;
    }
}
