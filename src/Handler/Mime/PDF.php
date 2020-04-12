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
 * Manipulador para gerar documentos PDF.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class PDF extends aMime
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
        $this->setDocumentMetaData();

        $body = "";
        $hasTemplate = ($this->routeConfig->getView() !== null || $this->routeConfig->getMasterPage() !== null);


        if ($hasTemplate === true) {
            $viewContent    = $this->processViewContent();
            $masterContent  = $this->processMasterPageContent();
            $strMetaData    = $this->processXHTMLMetaData();
            $strStyleSheet  = $this->processXHTMLStyleSheets();


            $masterContent = (($masterContent === "") ? "<view />" : $masterContent);


            // Mescla os dados obtidos
            $body = \str_replace("<view />",          $viewContent, $masterContent);
            $body = \str_replace("<metatags />",      $strMetaData, $body);
            $body = \str_replace("<stylesheets />",   $strStyleSheet, $body);
            $body = \str_replace("<javascripts />",   "", $body);

            $htmlProp = "lang=\"".$this->routeConfig->getResponseLocale()."\"";
            $body = \str_replace("data-eg-html-prop=\"\"", $htmlProp, $body);
        }
        else {
            $viewData = $this->response->getViewData();
            if ($viewData !== null) {
                $body = $this->convertArrayToStructuredString((array)$viewData, "  ");
            }
        }



        $msgError = null;
        if (\class_exists("Dompdf\Dompdf") === false) {
            $msgError = "To create PDF documents using the native resources, please, install the \"dompdf/dompdf\" library.";
        }
        else {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($body);
            $dompdf->setPaper("A4", "portrait");

            $dompdf->add_info("Author", $this->companyName . " | " . $this->authorName);
            $dompdf->add_info("Keywords", $this->keywords);
            $dompdf->add_info("Subject", $this->description);

            $dompdf->render();
            $body = $dompdf->output();
        }


        // Havendo algum erro, mostra a falha.
        if ($msgError !== null) {
            throw new \Exception($msgError);
        }

        return $body;
    }
}