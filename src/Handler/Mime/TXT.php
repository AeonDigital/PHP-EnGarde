<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler\Mime;

use AeonDigital\EnGarde\Handler\Mime\aMime as aMime;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;






/**
 * Manipulador para gerar documentos TXT.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class TXT extends aMime
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
        $body = "";
        $hasTemplate = (
            $this->serverConfig->getRouteConfig()->getView() !== "" ||
            $this->serverConfig->getRouteConfig()->getMasterPage() !== ""
        );


        if ($hasTemplate === true) {
            $viewContent    = $this->processViewContent();
            $masterContent  = $this->processMasterPageContent();

            $masterContent = (($masterContent === "") ? "<view />" : $masterContent);
            // Mescla os dados obtidos
            $body = \str_replace("<view />", $viewContent, $masterContent);
        }
        else {
            $this->viewData = $this->response->getViewData();
            if ($this->viewData !== null) {
                $body = $this->convertArrayToStructuredString((array)$this->viewData, "  ");
            }
        }

        return $body;
    }
}
