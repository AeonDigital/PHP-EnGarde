<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Handlers;

use AeonDigital\EnGarde\Interfaces\iRequestHandler as iRequestHandler;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\iController as iController;







/**
 * Manipulador padrão para resolução das rotas.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
class RouteHandler implements iRequestHandler
{



    /**
     * Aplicação que será executada.
     *
     * @var         iApplication
     */
    private $application = null;


    /**
     * Controller que será executado.
     *
     * @var         iController
     */
    private $controller = null;


    /**
     * Nome da action que será executada.
     *
     * @var         string
     */
    private $action = null;










    /**
     * Inicia um manipulador de rota.
     *
     * @param       iApplication $application
     *              Instância da aplicação cuja rota
     *              deve ser executada.
     */
    public function __construct(iApplication $application)
    {
        $this->application = $application;
    }





    /**
     * A partir das configurações da rota atualmente selecionada, 
     * gera uma instância do controller alvo e retorna-o.
     *
     * @return      iController
     */
    private function createController() : iController
    {
        $controllerNS   = $this->application->getRouteConfig()->getNamespace();
        $controllerName = $this->application->getRouteConfig()->getController();
        $ctrl           = $controllerNS . "\\" . $controllerName;
        return new $ctrl();
    }





    /**
     * Inicia o objeto controller alvo e define
     * suas propriedades basicas preparando-o para a execução da rota alvo.
     * Também efetua preparativos anteriores a execução da rota em si.
     *
     * @return      void
     */
    private function prepareToExecuteRoute() : void
    {
        // Bloqueia qualquer alteração das propriedades protegidas
        // de configuração da rota.
        $this->application->getRouteConfig()->lockProperties();


        // Cria o objeto controller e inicia suas propriedades basicas
        $this->controller = $this->createController();
        $this->controller->setViewData(new \StdClass());

        $this->controller->setServerConfig($this->application->getServerConfig());
        $this->controller->setDomainConfig($this->application->getDomainConfig());
        $this->controller->setAppConfig($this->application->getAppConfig());
        $this->controller->setRouteConfig($this->application->getRouteConfig());


        // inicia um objeto "response" novo
        $this->controller->setResponse(
            $this->application->getServerConfig()->getHttpFactory()->createResponse()
        );


        // Identifica a "action" que deve ser executada.
        $this->action = $this->application->getRouteConfig()->getAction();
    }





    /**
     * Processa a requisição e produz uma resposta.
     *
     * @param       iServerRequest 
     *              $request        Requisição que está sendo executada.
     * 
     * @return      iResponse
     */
    public function handle(iServerRequest $request): iResponse
    {
        $this->prepareToExecuteRoute();

        // Executa a action alvo
        $this->controller->{$this->action}($request);

        // Retorna o objeto "response" do controller 
        // contendo os valores obtidos em "viewData"
        // e aqueles que possam ter sido alterados em "routeConfig".
        return $this->controller->getResponse();
    }
}
