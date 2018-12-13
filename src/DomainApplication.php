<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\EnGarde\Config\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Config\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\iApplication as iApplication;






/**
 * Classe abstrata que deve ser herdada pelas classes
 * concretas em cada Aplicações *EnGarde*.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
abstract class DomainApplication implements iApplication
{
    use \AeonDigital\Traits\MimeTypeData;





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
     * Guarda a parte relativa da URI que está sendo
     * executada no momento
     *
     * @var         string
     */
    protected $executePath = null;
    /**
     * Nome do método que deve ser usado para resolver
     * a rota que está ativa no momento.
     *
     * @var         string
     */
    protected $runMethodName = "run";





    /**
     * Define o objeto "iServerRequest" para esta instância.
     *
     * @return      void
     */
    private function defineServerRequest() : void
    {
        $this->serverRequest = $this->serverConfig->getHttpFactory()->createServerRequest(
            $this->serverConfig->getRequestMethod(),
            $this->serverConfig->getCurrentURI(),
            $this->serverConfig->getRequestHTTPVersion(),
            $this->serverConfig->getHttpFactory()->createHeaderCollection($this->serverConfig->getRequestHeaders()),
            $this->serverConfig->getHttpFactory()->createStreamFromBodyRequest(),
            $this->serverConfig->getHttpFactory()->createCookieCollection($this->serverConfig->getRequestCookies()),
            $this->serverConfig->getHttpFactory()->createQueryStringCollection($this->serverConfig->getRequestQueryStrings()),
            $this->serverConfig->getHttpFactory()->createFileCollection($this->serverConfig->getRequestFiles()),
            $this->serverConfig->getServerVariables(),
            $this->serverConfig->getHttpFactory()->createCollection(),
            $this->serverConfig->getHttpFactory()->createCollection()
        );
    }
    /**
     * Define o objeto "iApplicationConfig" para esta instância.
     * 
     * @return      void
     */
    private function defineApplicationConfig() : void
    {
        $this->applicationConfig = new \AeonDigital\EnGarde\Config\ApplicationConfig(
            $this->domainConfig->getApplicationName(), 
            $this->domainConfig->getRootPath()
        );

        // Aplica as configurações específicas de cada aplicação.
        $this->configureApplication();

        // Se a Aplicação tem uma página própria para
        // amostragem de erros, registra-a no manipulador de erros.
        $fullPathToErrorView = $this->applicationConfig->getFullPathToErrorView();
        if ($fullPathToErrorView !== null) {
            \AeonDigital\EnGarde\Config\ErrorListening::setPathToErrorView($fullPathToErrorView);
        }

    }
    /**
     * Define o objeto "ApplicationRouter" para esta instância.
     * 
     * @return      void
     */
    private function defineApplicationRouter() : void
    {
        $this->applicationRouter = new \AeonDigital\EnGarde\Config\ApplicationRouter(
            $this->applicationConfig->getName(),
            $this->applicationConfig->getPathToAppRoutes(),
            $this->applicationConfig->getPathToControllers(),
            $this->applicationConfig->getControllersNamespace(),
            $this->applicationConfig->getDefaultRouteConfig()
        );
    }
    /**
     * Seleciona o objeto "iRouteConfig" para esta instância.
     *
     * @return      void
     */
    private function selectTargetRouteConfig() : void
    {
        if ($this->routeConfig === null) {
            // P1 - Verifica necessidade de atualizar o arquivo de rotas da aplicação.
            $this->applicationRouter->setIsUpdateRoutes($this->domainConfig->getIsUpdateRoutes());

            // Sendo para atualizar as rotas
            // E
            // Estando com o debug mode ligado...
            // E
            // Estando em um ambiente definido como "local" ou "localtest"
            //
            // força o update de rotas em toda requisição
            if ($this->domainConfig->getIsUpdateRoutes() === true &&
                $this->domainConfig->getIsDebugMode() === true &&
                ($this->domainConfig->getEnvironmentType() === "local" || $this->domainConfig->getEnvironmentType() === "localtest")) 
            {
                $this->applicationRouter->forceUpdateRoutes();
            }

            // Efetua a recomposição do arquivo de rotas caso
            // seja necessário
            $this->applicationRouter->updateApplicationRoutes();




            // P2 - Identifica as configurações de execução da rota alvo.
            $requestURIPath = $this->serverRequest->getUri()->getPath();

            // Se o nome da aplicação não foi definido no caminho 
            // relativo da URI que está sendo executada, adiciona-o
            $executePath = "/" . ltrim($requestURIPath, "/");
            if ($this->domainConfig->isApplicationNameOmitted() === true) {
                $executePath = "/" . $this->applicationConfig->getName() . "/" . ltrim($requestURIPath, "/");
            }
            $this->executePath = $executePath;


            // Seleciona os dados da rota que deve ser executada.
            $this->rawRouteConfig = $this->applicationRouter->selectTargetRawRoute($executePath);


            // P3 - Identificando exatamente a configuração da rota alvo
            $targetMethod = strtoupper($this->serverRequest->getMethod());
            if ($this->rawRouteConfig !== null && isset($this->rawRouteConfig[$targetMethod]) === true) {
                $this->routeConfig = new \AeonDigital\EnGarde\Config\RouteConfig($this->rawRouteConfig[$targetMethod]);
            }
        }
    }





    /**
     * Permite configurar ou redefinir o objeto de configuração
     * da aplicação na classe concreta da mesma.
     */
    abstract public function configureApplication() : void;










    /**
     * Inicia uma Aplicação.
     *
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     * 
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     */
    function __construct(
        iServerConfig $serverConfig,
        iDomainConfig $domainConfig
    ) {
        $this->serverConfig = $serverConfig;
        $this->domainConfig = $domainConfig;

        $this->defineServerRequest();
        $this->defineApplicationConfig();
        $this->defineApplicationRouter();
        $this->selectTargetRouteConfig();

        if ($this->routeConfig !== null) {
            $this->executeContentNegotiation();
            $this->initiCacheResponse();
        }
    }










    /**
     * Efetua a negociação de conteúdo para identificar
     * de que forma os dados devem ser retornados ao UA.
     *
     * @return      void
     */
    private function executeContentNegotiation() : void
    {
        // Verifica qual locale deve ser usado para responder 
        // esta requisição
        $useLocale = $this->routeConfig->negotiateLocale(
            $this->serverRequest->getResponseLocales(),
            $this->serverRequest->getResponseLanguages(),
            $this->applicationConfig->getLocales(),
            $this->applicationConfig->getDefaultLocale(),
            $this->serverRequest->getParam("_locale")
        );

        if ($useLocale === null) {
            $msg = "Locale \"$useLocale\" is not supported by this Application.";
            \AeonDigital\EnGarde\Config\ErrorListening::throwHTTPError(415, $msg);
        } else {
            $this->routeConfig->setResponseLocale($useLocale);
        }


        // Verifica qual mimetype deve ser usado para responder 
        // esta requisição
        $routeMime = $this->routeConfig->negotiateMimeType(
            $this->serverRequest->getResponseMimes(),
            $this->serverRequest->getParam("_mime")
        );


        if ($routeMime["valid"] === false) {
            $useMime        = $routeMime["mime"];
            $useMimeType    = $routeMime["mimetype"];

            $msg            = "Media type \"$useMime | $useMimeType\" is not supported by this URL.";
            \AeonDigital\EnGarde\Config\ErrorListening::throwHTTPError(415, $msg);
        } else {
            $this->routeConfig->setResponseMime($routeMime["mime"]);
            $this->routeConfig->setResponseMimeType($routeMime["mimetype"]);
        }


        // Identifica se a rota é "naturalmente" um download.
        $isDownload_route = $this->routeConfig->getResponseIsDownload();
        // Identifica se há um parametro que force o download do resultado da rota.
        $isDownload_param = $this->serverRequest->getParam("_download");
        if ($isDownload_param !== null) {
            $isDownload_param = ($isDownload_param === "true" || $isDownload_param === "1");
        }
        // Aplica a regra conforme as prioridades pré-estipuladas.
        // O parametro encontrado na querystring é prioritário e pode ser usado para
        // negar o download de uma rota cuja configuração seja naturalmente a obtenção
        // de um documento.
        $this->routeConfig->setResponseIsDownload(
            ($isDownload_param === true || (($isDownload_param === null || $isDownload_param === true) && $isDownload_route === true))
        );



        // Identifica se é para usar "pretty print" no código fonte de retorno
        $prettyPrint = $this->serverRequest->getParam("_pretty_print");
        $this->routeConfig->setResponseIsPrettyPrint(($prettyPrint === "true" || $prettyPrint === "1"));
    }





    /**
     * Inicia as verificações para o caso de o sistema de cache
     * estar ativado para a rota atualmente sendo executada.
     *
     * @return      void
     */
    private function initiCacheResponse() : void
    {
        // Aguardar para implementar via Middleware
        if ($this->routeConfig->getIsUseCache() === true) {
            // P1 - Identifica o nome do arquivo que deve responder
            //      a esta requisição.
            $httpMethod     = $this->serverRequest->getMethod();

            $executePath    = str_replace("/" . $this->applicationConfig->getName(), "", $this->executePath);
            $useRoute       = str_replace("/", "-", trim($executePath, "/"));
            $useRoute       = (($useRoute === "") ? "home" : $useRoute);
            $useAction      = $this->routeConfig->getAction();
            $useQuery       = http_build_query($this->serverRequest->getQueryParams());
            $useQuery       = (($useQuery === "") ? "" : "§$routeQuery");

            $cacheFileName  =   $httpMethod . "-" . $useRoute . "-" . 
                                $useAction . $routeQuery . "-" . $this->useLocale . "." . $this->useMime;
        }
    }










    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
    public function run() : void
    {
        // Se este não for o método a ser executado para 
        // resolver esta rota, evoca o método alvo.
        if ($this->runMethodName !== "run") {
            $exec = $this->runMethodName;
            $this->$exec();
        } 
        else {
            if ($this->checkRouteErrors() === true) {
                $targetMethod = strtoupper($this->serverRequest->getMethod());

               

                // Inicia uma instância "iRequestHandler" responsável
                // por iniciar o controller alvo e executar o método correspondente
                // a rota.
                $resolver = new \AeonDigital\EnGarde\RouteResolver(
                    $this->serverConfig,
                    $this->domainConfig,
                    $this->applicationConfig,
                    $this->serverRequest,
                    $this->rawRouteConfig,
                    $this->routeConfig
                );


                // Inicia a instância do manipulador da requisição.
                // e passa para ele o resolver da rota para ser executado após
                // os middlewares
                $requestManager = new \AeonDigital\EnGarde\RequestManager\RequestManager($resolver);


                // Registra os middlewares caso existam
                if ($this->routeConfig !== null) {
                    $middlewares = $this->routeConfig->getMiddlewares();
                    foreach ($middlewares as $callMiddleware) {
                        
                        // Se o middleware está registrado com seu nome completo
                        if (class_exists($callMiddleware) === true) {
                            $requestManager->add(new $callMiddleware());
                        } 
                        // Senão, o middleware registrado deve corresponder a um
                        // método da aplicação atual.
                        else {
                            $requestManager->add($this->{$callMiddleware}());
                        }
                    }
                }


                // Ocultará qualquer saida de dados dos middlewares
                // ou das actions quando estiver em um ambiente de produção
                // OU
                // quando o debug mode estiver ativo
                $hideAllOutputs = ( $this->domainConfig->getEnvironmentType() === "production" ||
                                    $this->domainConfig->getIsDebugMode() === false);


                // Caso necessário, inicia o buffer
                // Com isso, esconderá todas as saídas explicitas originarias
                // dos middlewares e da action.
                if ($hideAllOutputs === true) { ob_start(); }


                // Executa os middlewares e action alvo retornando 
                // um objeto "iResponse" contendo as informações 
                // "viewData" e "routeConfig" devidamente processadas 
                //
                // A partir deste objeto e dos dados retornados a view
                // será produzida e entregue ao UA.
                $resultResponse = $requestManager->handle($this->serverRequest);


                // Caso necessário, esvazia o buffer e encerra-o
                if ($hideAllOutputs === true) { ob_end_clean(); }


                // A partir do objeto "iResponse" obtido, 
                // gera a view a ser enviada para o UA.
                $responseHandler = new \AeonDigital\EnGarde\ResponseHandler(
                    $this->serverConfig,
                    $this->domainConfig,
                    $this->applicationConfig,
                    $this->serverRequest,
                    $this->rawRouteConfig,
                    $this->routeConfig,
                    $resultResponse
                );


                $this->testViewDebug = $responseHandler->sendResponse();
            }
        }
    }





    /**
     * Verifica se há erros na seleção da 
     * configuração da rota alvo.
     *
     * @return      bool
     */
    private function checkRouteErrors() : bool
    {
        $targetMethod       = strtoupper($this->serverRequest->getMethod());
        $httpErrorCode      = null;
        $httpErrorMessage   = null;


        // Se a rota acessada não for encontrada.
        if ($this->rawRouteConfig === null) {
            $httpErrorCode = 404;
            $httpErrorMessage = "Not Found";
        }
        // Senão, se
        // A rota a ser acessada está configurada
        else {
            $hasTargetMethod = (
                isset($this->rawRouteConfig[$targetMethod]) === true ||
                $targetMethod === "OPTIONS" || 
                $targetMethod === "TRACE"
            );


            // Se a rota não está preparada para servir
            // a uma requisição com o método especificado...
            if ($hasTargetMethod === false) {
                $httpErrorCode      = 501;
                $httpErrorMessage   = "Method \"$targetMethod\" is not implemented in this route.";
            } 
        }


        // Havendo capturado alguma falha que não pode ser 
        // resolvida e precisa entregar ao UA uma mensagem
        // do que ocorreu...
        if ($httpErrorCode !== null) {
            $this->testViewDebug = \AeonDigital\EnGarde\Config\ErrorListening::throwHTTPError($httpErrorCode, $httpErrorMessage);
            return false;
        } else {
            return true;
        }
    }










    protected $testViewDebug = null;
    /**
     * Usado para testes em desenvolvimento.
     * Retorna um valor interno que poderá ser aferido
     * em ambiente de testes.
     *
     * @return      mixed
     */
    public function getTestViewDebug()
    {
        return $this->testViewDebug;
    }
}
