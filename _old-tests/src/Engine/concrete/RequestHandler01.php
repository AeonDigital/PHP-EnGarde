<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Tests\Concrete;

use AeonDigital\Interfaces\EnGarde\iRequestHandler as iRequestHandler;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\Http\Data\HeaderCollection as HeaderCollection;
use AeonDigital\Http\Stream\Stream as Stream;




/**
 * Classe concreta para "iRequestHandler".
 */
class RequestHandler01 implements iRequestHandler
{
    public function handle(iServerRequest $request) : iResponse
    {
        $oBody = provider_PHPStream_InstanceOf_Stream();
        $headers = [
            "CONTENT_TYPE" => "text/html; charset=utf-8",
            "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "accept-language" => "pt-BR, pt;q=0.8, en-US;q=0.5, en;q=0.3",
        ];
        $headerCollection = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $viewData = (object)$request->getAttributes();

        $oResponse = new \AeonDigital\Http\Message\Response(200, "", "1.1", $headerCollection, $oBody, $viewData);
        return $oResponse;
    }
}
