<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler;

use AeonDigital\Interfaces\Http\Server\iRequestHandler as iRequestHandler;
use AeonDigital\Interfaces\Http\Server\iResponseHandler as iResponseHandler;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\Config\iDomain as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\EnGarde\Interfaces\Engine\iController as iController;





/**
 * Manipulador padrão para resolução das rotas.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 * @codeCoverageIgnore
 */
class RouteResolver implements iRequestHandler
{





    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    protected iServerConfig $serverConfig;
    /**
     * Instância das configurações do Domínio.
     *
     * @var         iDomainConfig
     */
    protected iDomainConfig $domainConfig;
    /**
     * Configuraçõs para a Aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    protected iApplicationConfig $applicationConfig;
    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    protected iServerRequest $serverRequest;
    /**
     * Objeto que representa a configuração bruta da rota alvo.
     *
     * @var         array
     */
    protected array $rawRouteConfig = [];
    /**
     * Objeto que representa a configuração da rota alvo.
     *
     * @var         iRouteConfig
     */
    protected iRouteConfig $routeConfig;
    /**
     * Objeto responsável por preparar o ``iResponseHandler`` para ser servido ao ``UA``.
     *
     * @var         iResponseHandler
     */
    private iResponseHandler $responseHandler;





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
     * @param       ?iRouteConfig $routeConfig
     *              Instância ``iRouteConfig``.
     */
    function __construct(
        iServerConfig $serverConfig,
        iDomainConfig $domainConfig,
        iApplicationConfig $applicationConfig,
        iServerRequest $serverRequest,
        array $rawRouteConfig,
        ?iRouteConfig $routeConfig = null
    ) {
        $this->serverConfig         = $serverConfig;
        $this->domainConfig         = $domainConfig;
        $this->applicationConfig    = $applicationConfig;
        $this->serverRequest        = $serverRequest;
        $this->rawRouteConfig       = $rawRouteConfig;
        if ($routeConfig !== null) {
            $this->routeConfig = $routeConfig;
        }
    }





    /**
     * A partir das configurações da rota atualmente selecionada, gera uma instância do
     * controller alvo e retorna-o.
     *
     * @param       iResponse $response
     *              Objeto ``iResponse`` a ser passado para o controller.
     *
     * @return      iController
     */
    private function createController(iResponse $response) : iController
    {
        $ctrl = $this->routeConfig->getNamespace() . "\\" . $this->routeConfig->getController();
        return new $ctrl(
            $this->serverConfig,
            $this->domainConfig,
            $this->applicationConfig,
            $this->serverRequest,
            $this->rawRouteConfig,
            $this->routeConfig,
            $response
        );
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


        // NÃO sendo uma requisição que use um método
        // do tipo "TRACE" ou "OPTIONS"
        if ($request->getMethod() !== "TRACE" && $request->getMethod() !== "OPTIONS") {
            // Bloqueia qualquer alteração das propriedades protegidas
            // de configuração da rota.
            $this->routeConfig->lockProperties();

            // Inicia uma nova instância do controller alvo
            $tgtController = $this->createController($resultResponse);

            // Executa a action alvo
            $action = $this->routeConfig->getAction();
            $tgtController->{$action}();

            // Retorna o objeto "iResponse" modificado pela
            // execução da action.
            $resultResponse = $tgtController->getResponse();
        }


        // A partir do objeto "iResponse" obtido,
        // gera a view a ser enviada para o UA.
        $this->responseHandler = new \AeonDigital\EnGarde\Handler\ResponseHandler(
            $this->serverConfig,
            $this->domainConfig,
            $this->applicationConfig,
            $this->serverRequest,
            $this->rawRouteConfig,
            $this->routeConfig,
            $resultResponse
        );

        // Prepara os headers e body do objeto "iResponse"
        return $this->responseHandler->prepareResponse();
    }
}
