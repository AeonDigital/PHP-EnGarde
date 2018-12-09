<?php
declare (strict_types = 1);

namespace site\middlewares;

use AeonDigital\EnGarde\RequestManager\Interfaces\iMiddleware as iMiddleware;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\RequestManager\Interfaces\iRequestHandler as iRequestHandler;





/**
 * Classe concreta para "iMiddleware".
 * 
 * Esta classe representa um modelo básico de como um Middleware deve
 * ser implementado para ser consumido pela aplicação.
 */
final class TestMiddleware implements iMiddleware
{
    private $from = "";
    public function setFrom($from) {
        $this->from = $from;
    }


    /**
     * Efetua uma camada do processo de resolução da requisição submetida pelo UA.
     * 
     * Se não for capaz de produzir um objeto response por si mesmo, deve delegar
     * esta responsabilidade para o manipulador padrão.
     *
     * @param       iServerRequest $request
     *              Objeto da requisição HTTP.
     * 
     * @param       iRequestHandler $handler
     *              Manipulador padrão para as requisições.
     * 
     * @return      iResponse
     */
    public function process(iServerRequest $request, iRequestHandler $handler) : iResponse
    {
        $res = $handler->handle($request);

        $viewData = $res->getViewData();
        $viewData->{"EndExecute_" . $this->from} = "middleware";
        $res = $res->withViewData($viewData);

        return $res;
    }
}
