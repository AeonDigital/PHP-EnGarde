<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler;

use AeonDigital\Interfaces\Http\Server\iRequestHandler as iRequestHandler;
use AeonDigital\Interfaces\Http\Server\iResponseHandler as iResponseHandler;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\EnGarde\Interfaces\Engine\iController as iController;



/**
 * Manipulador padrão para resolução das rotas.
 *
 * Trata-se de uma classe ``iRequestHandler`` que tem por função iniciar e executar o
 * ``controller`` e ``action`` alvo da requisição e, ao final, entregar o objeto ``iResponse``
 * resultante para ser usado por uma implementação de ``iResponseHandler``.
 *
 * Deve ser executada após todos os ``Middlewares`` terem sido acionados.
 *
 * @codeCoverageIgnore
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
class RouteResolver implements iRequestHandler
{



    /**
     * Objeto responsável por preparar o ``iResponseHandler`` para ser servido ao ``UA``.
     *
     * @var         iResponseHandler
     */
    private iResponseHandler $responseHandler;
    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    private iServerConfig $serverConfig;
    /**
     * Instância do controller que será executado.
     *
     * @var         iController
     */
    private iController $controller;





    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância ``iServerConfig``.
     */
    function __construct(
        iServerConfig $serverConfig
    ) {
        $this->serverConfig = $serverConfig;
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
        $resultResponse = $this->serverConfig->getHttpFactory()->createResponse();


        // SE
        // o método Http que está sendo evocado deve ser executado pelo desenvolvedor...
        if (\in_array($request->getMethod(), $this->serverConfig->getDeveloperHttpMethods()) === true)
        {
            // Identifica o controller e a action que devem ser executadas.
            $targetController   = $this->serverConfig->getRouteConfig()->getControllerNamespace();
            $targetAction       = $this->serverConfig->getRouteConfig()->getAction();


            // Inicia o controller alvo e executa a action
            $this->controller = new $targetController(
                $this->serverConfig,
                $resultResponse
            );
            $this->controller->{$targetAction}();

            // Retorna o objeto "iResponse" modificado pela
            // execução da action.
            $resultResponse = $this->controller->getResponse();
        }


        // A partir do objeto "iResponse" obtido,
        // gera a view a ser enviada para o UA.
        $this->responseHandler = new \AeonDigital\EnGarde\Handler\ResponseHandler(
            $this->serverConfig,
            $resultResponse
        );

        // Prepara os headers e body do objeto "iResponse"
        return $this->responseHandler->prepareResponse();
    }
}
