<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Handlers;

use AeonDigital\EnGarde\Interfaces\iRequestHandler as iRequestHandler;
use AeonDigital\EnGarde\Interfaces\iMiddleware as iMiddleware;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use Psr\Http\Server\MiddlewareInterface as MiddlewareInterface;




/**
 * Responsável por receber e executar uma lista de processos 
 * (middlewares e rota) a serem executados durante o processamento 
 * de uma requisição.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
final class MainHandler implements iRequestHandler
{





    /**
     * Coleção de objetos Middleware que devem ser executados
     * para o completo processamento da rota.
     *
     * @var         iMiddleware[]|MiddlewareInterface[]
     */
    private $middlewares = [];



    /**
     * Manipulador executado ao final da lista de tarefas.
     *
     * @var         iRequestHandler
     */
    private $finalHandler;










    /**
     * Inicia um manipulador de requisições.
     *
     * @param       iRequestHandler $finalHandler
     *              Manipulador padrão.
     *              Será executado sempre ao finalizar
     *              a lista de tarefas de uma rota.
     */
    public function __construct(iRequestHandler $finalHandler)
    {
        $this->finalHandler = $finalHandler;
    }





    /**
     * Adiciona um novo Middleware na lista de execuções da rota.
     *
     * @param       iMiddleware|MiddlewareInterface $middleware
     *              Objeto Middleware a ser adicionado na lista de tarefas.
     * 
     * @return      void
     */
    public function add($middleware)
    {
        if ($middleware instanceof MiddlewareInterface ||
            $middleware instanceof iMiddleware) 
        {
            $this->middlewares[] = $middleware;
        }
    }





    /**
     * Processa a requisição e produz uma resposta.
     *
     * @param       iServerRequest $request
     *              Requisição que está sendo executada.
     * 
     * @return      iResponse
     */
    public function handle(iServerRequest $request) : iResponse
    {
        // Quando não houverem mais Middlewares a serem executados
        // evoca a ação que corresponde a rota alvo.
        if (count($this->middlewares) === 0) {
            return $this->finalHandler->handle($request);
        }

        $middleware = array_shift($this->middlewares);
        return $middleware->process($request, $this);
    }
}
