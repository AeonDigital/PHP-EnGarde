<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler\Mime;

use AeonDigital\EnGarde\Handler\Mime\aMime as aMime;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;






/**
 * Manipulador para gerar documentos CSV.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class CSV extends aMime
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
        $this->viewData = $this->response->getViewData();
        $dataTable = ((isset($this->viewData->dataTable) === true) ? $this->viewData->dataTable : []);

        $finalArray = $this->prepareArrayToCreateSpreadSheet(
            $dataTable, '"', '""', true
        );

        $tmpData    = [];
        foreach ($finalArray as $dataRow) {
            $tmpData[] = \implode(",", $dataRow);
        }
        $body = \implode("\n", $tmpData);

        return $body;
    }
}
