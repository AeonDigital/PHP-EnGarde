<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler\Mime;

use AeonDigital\EnGarde\Handler\Mime\aMime as aMime;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
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
     * @param       iResponse $response
     *              Instância ``iResponse``.
     */
    function __construct(
        iServerConfig $serverConfig,
        iResponse $response
    ) {
        parent::__construct(
            $serverConfig,
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
        $hasTemplate = (
            $this->serverConfig->getRouteConfig()->getView() !== "" ||
            $this->serverConfig->getRouteConfig()->getMasterPage() !== ""
        );


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

            $locale = $this->serverConfig->getRouteConfig()->getResponseLocale();
            $htmlProp = "lang=\"$locale\"";
            $body = \str_replace("data-eg-html-prop=\"\"", $htmlProp, $body);
        }
        else {
            $this->viewData = $this->response->getViewData();
            if ($this->viewData !== null) {
                $body = $this->convertArrayToStructuredString((array)$this->viewData, "  ");
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
