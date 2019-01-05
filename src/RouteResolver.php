<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\EnGarde\Interfaces\iRequestHandler as iRequestHandler;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Config\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Config\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Config\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Config\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\iController as iController;






/**
 * Manipulador padrão para resolução das rotas.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
class RouteResolver implements iRequestHandler
{





    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    protected $serverConfig = null;
    /**
     * Instância das configurações do Domínio.
     *
     * @var         iDomainConfig
     */
    protected $domainConfig = null;
    /**
     * Configuraçõs para a Aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    protected $applicationConfig = null;
    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    protected $serverRequest = null;
    /**
     * Objeto que representa a configuração bruta da rota alvo.
     *
     * @var         ?array
     */
    protected $rawRouteConfig = null;
    /**
     * Objeto que representa a configuração da rota alvo.
     *
     * @var         iRouteConfig
     */
    protected $routeConfig = null;
    /**
     * Objeto responsável por preparar o "iResponse" para
     * ser servido ao UA.
     *
     * @var         iResponseHandler
     */
    private $responseHandler = null;





    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     * 
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     * 
     * @param       iApplicationConfig $applicationConfig
     *              Instância "iApplicationConfig".
     * 
     * @param       iServerRequest $serverRequest
     *              Instância "iServerRequest".
     * 
     * @param       array $rawRouteConfig
     *              Instância "iServerConfig".
     * 
     * @param       ?iRouteConfig $routeConfig
     *              Instância "iRouteConfig".
     */
    function __construct(
        iServerConfig $serverConfig,
        iDomainConfig $domainConfig,
        iApplicationConfig $applicationConfig,
        iServerRequest $serverRequest,
        array $rawRouteConfig,
        ?iRouteConfig $routeConfig
    ) {
        $this->serverConfig         = $serverConfig;
        $this->domainConfig         = $domainConfig;
        $this->applicationConfig    = $applicationConfig;
        $this->serverRequest        = $serverRequest;
        $this->rawRouteConfig       = $rawRouteConfig;
        $this->routeConfig          = $routeConfig;
    }





    /**
     * A partir das configurações da rota atualmente selecionada, 
     * gera uma instância do controller alvo e retorna-o.
     * 
     * @param       iResponse $response
     *              Objeto "iResponse" a ser passado para o controller.
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
        $response = $this->serverConfig->getHttpFactory()->createResponse();
        

        // Se a requisição está executando um método HTTP
        // do tipo TRACE ou OPTIONS
        if ($request->getMethod() === "TRACE" || $request->getMethod() === "OPTIONS") {
            return $response;
        } 
        // Se está executando um método comum
        else {
            // Bloqueia qualquer alteração das propriedades protegidas
            // de configuração da rota.
            $this->routeConfig->lockProperties();

            // Inicia uma nova instância do controller alvo
            $tgtController = $this->createController($response);
            
            // Executa a action alvo
            $action = $this->routeConfig->getAction();
            $tgtController->{$action}();

            // Retorna o objeto "iResponse" modificado pela 
            // execução da action.
            $resultResponse = $tgtController->getResponse();

            // A partir do objeto "iResponse" obtido, 
            // gera a view a ser enviada para o UA.
            $this->responseHandler = new \AeonDigital\EnGarde\ResponseHandler(
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
}
