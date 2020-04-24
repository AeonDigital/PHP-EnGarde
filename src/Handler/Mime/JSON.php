<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler\Mime;

use AeonDigital\EnGarde\Handler\Mime\aMime as aMime;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;






/**
 * Manipulador para gerar documentos JSON.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class JSON extends aMime
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
        // Converte o valor de "viewData" em uma representação JSON
        $jsonOptions = (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        if ($this->serverConfig->getRouteConfig()->getResponseIsPrettyPrint() === true) {
            $jsonOptions = (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES |
                            JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
        }

        return \json_encode(
            $this->response->getViewData(),
            $jsonOptions
        );
    }
}
