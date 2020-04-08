<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\Interfaces\EnGarde\iRequestHandler as iRequestHandler;
use AeonDigital\Interfaces\EnGarde\iMiddleware as iMiddleware;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use Psr\Http\Server\MiddlewareInterface as MiddlewareInterface;




/**
 * Responsável por coordenar e executar uma lista de processos (Middlewares) a serem efetuados
 * para uma requisição e ao fim, executar o próprio manipulador da requisição realizada pelo ``UA``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 * @codeCoverageIgnore
 */
final class RequestHandler implements iRequestHandler
{





    /**
     * Coleção de objetos Middleware que devem ser executados para o completo processamento
     * da requisição.
     * Os Middlewares são executados em ordem de registro.
     *
     * @var         iMiddleware[]|MiddlewareInterface[]
     */
    private array $middlewares = [];

    /**
     * Manipulador que executará a action alvo.
     *
     * @var         iRequestHandler
     */
    private iRequestHandler $actionHandler;










    /**
     * Inicia um gerenciador de processos para requisições.
     *
     * @param       iRequestHandler $actionHandler
     *              Manipulador da action alvo.
     *              Será executado sempre ao finalizar a lista de Middlewares programados para a
     *              requisição.
     */
    public function __construct(iRequestHandler $actionHandler)
    {
        $this->actionHandler = $actionHandler;
    }





    /**
     * Adiciona um novo Middleware na lista de processos da requisição.
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
     * Processa a lista de Middlewares e após o próprio manipulador da requisição e produz uma
     * resposta.
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
        if (\count($this->middlewares) === 0) {
            return $this->actionHandler->handle($request);
        }
        else {
            $middleware = \array_shift($this->middlewares);
            return $middleware->process($request, $this);
        }
    }
}
