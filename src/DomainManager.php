<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\Http\Tools\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\EnGarde\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\iApplicationRouter as iApplicationRouter;
use AeonDigital\EnGarde\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\iApplication as iApplication;

use AeonDigital\EnGarde\ErrorListening as ErrorListening;
use AeonDigital\EnGarde\Config\RouteConfig as RouteConfig;






/**
 * Gerenciador principal do domínio.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 * 
 * @codeCoverageIgnore
 */
final class DomainManager
{





    /**
     * Instância de configuração do Domínio
     *
     * @var         iDomainConfig
     */
    private $domainConfig = null;
    /**
     * Configuração do Servidor.
     *
     * @var         iServerConfig
     */
    private $serverConfig = null;
    /**
     * Instância de configuração da Aplicação alvo.
     *
     * @var         iApplicationConfig
     */
    private $applicationConfig = null;
    /**
     * Instância de um roteador a ser usado
     * pela Aplicação alvo.
     *
     * @var         iApplicationRouter
     */
    private $applicationRouter = null;
    /**
     * Instância que representa a requisição feita pelo UA.
     *
     * @var         iServerRequest
     */
    private $serverRequest = null;
    /**
     * Instância da Aplicação a ser executada.
     *
     * @var         iApplication
     */
    private $targetApplication = null;






    /**
     * Registra as configurações vasicas para o manipulador de erros
     * e exceções do domínio.
     *
     * @return      void
     */
    private function registerErrorListening() : void 
    {
        ErrorListening::setContext(
            $this->domainConfig->getRootPath(),
            $this->domainConfig->getEnvironmentType(),
            $this->domainConfig->getIsDebugMode(),
            $this->serverConfig->getRequestProtocol(),
            $this->serverConfig->getRequestMethod(),
            $this->domainConfig->getFullPathToErrorView()
        );
        
        // Registra os manipuladores de erros do domínio
        set_exception_handler([ErrorListening::class, "onException"]);
        set_error_handler([ErrorListening::class, "onError"], E_ALL);
    }





    /**
     * Define e retorna um objeto "iServerConfig" caso nenhum tenha sido passado.
     *
     * @param       ?iServerConfig $serverConfig
     *              Instância "iServerConfig" para ser usada pelo domínio. 
     *              Se nenhuma for definida então uma nova será instanciada usando
     *              os valores encontrados nas variáveis globais.
     *
     * @return      iServerConfig
     */
    private function defineServerConfig(?iServerConfig $serverConfig = null) : iServerConfig
    {
        if ($serverConfig === null) {
            $serverConfig = new \AeonDigital\Http\Tools\ServerConfig($_SERVER, (ENVIRONMENT === "test"));
            $serverConfig->setHttpTools(new \AeonDigital\Http\Tools\Tools());
        }
        return $serverConfig;
    }
    /**
     * Define e retorna um objeto de configuração de Domínio "iDomainConfig".
     * 
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     *
     * @return      iDomainConfig
     */
    private function defineDomainConfig(iServerConfig $serverConfig) : iDomainConfig
    {
        $domainConfig = new \AeonDigital\EnGarde\Config\DomainConfig();
        $domainConfig->setVersion("0.9.0 [alpha]");


        $domainConfig->setEnvironmentType(ENVIRONMENT);
        $domainConfig->setIsDebugMode(DEBUG_MODE);
        $domainConfig->setIsUpdateRoutes(UPDATE_ROUTES);
        $domainConfig->setRootPath($serverConfig->getRootPath());
        $domainConfig->setHostedApps(HOSTED_APPS);
        $domainConfig->setDefaultApp(DEFAULT_APP);
        $domainConfig->setDateTimeLocal(DATETIME_LOCAL);
        $domainConfig->setTimeOut(REQUEST_TIMEOUT);
        $domainConfig->setMaxFileSize(REQUEST_MAX_FILESIZE);
        $domainConfig->setMaxPostSize(REQUEST_MAX_POSTSIZE);
        $domainConfig->setApplicationClassName(APPLICATION_CLASSNAME);
        $domainConfig->setPathToErrorView(DEFAULT_ERROR_VIEW);


        $domainConfig->setPHPDomainConfiguration();
        $domainConfig->defineTargetApplication($serverConfig->getRequestPath());


        return $domainConfig;
    }
    /**
     * Define e retorna um objeto de configuração da Aplicação 
     * que deve ser executada.
     *
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     * 
     * @return      iApplicationConfig
     */
    private function defineApplicationConfig(iDomainConfig $domainConfig) : iApplicationConfig
    {
        return new \AeonDigital\EnGarde\Config\ApplicationConfig(
            $domainConfig->getApplicationName(), 
            $domainConfig->getRootPath());
    }
    /**
     * Define e retorna um objeto Roteador configurado para ser
     * usado na Aplicação alvo.
     *
     * @param       iApplicationConfig $applicationConfig
     *              Instância "iApplicationConfig".
     * 
     * @return      iApplicationRouter
     */
    private function defineApplicationRouter(iApplicationConfig $applicationConfig) : iApplicationRouter
    {
        return new ApplicationRouter(
            $applicationConfig->getName(),
            $applicationConfig->getPathToAppRoutes(),
            $applicationConfig->getPathToControllers(),
            $applicationConfig->getControllersNamespace(),
            $applicationConfig->getDefaultRouteConfig()
        );
    }
    /**
     * Define e retorna uma instância que representa a requisição
     * que o UA está fazendo ao servidor.
     *
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     * 
     * @return      iServerRequest
     */
    private function defineServerRequest(iServerConfig $serverConfig) : iServerRequest
    {
        return $this->serverConfig->getHttpTools()->createServerRequest(
            $this->serverConfig->getRequestMethod(),
            $this->serverConfig->getCurrentURI(),
            $this->serverConfig->getRequestHTTPVersion(),
            $this->serverConfig->getHttpTools()->createHeaderCollection($this->serverConfig->getRequestHeaders()),
            $this->serverConfig->getHttpTools()->createStreamFromBodyRequest(),
            $this->serverConfig->getHttpTools()->createCookieCollection($this->serverConfig->getRequestCookies()),
            $this->serverConfig->getHttpTools()->createQueryStringCollection($this->serverConfig->getRequestQueryStrings()),
            $this->serverConfig->getHttpTools()->createFileCollection($this->serverConfig->getRequestFiles()),
            $this->serverConfig->getServerVariables(),
            $this->serverConfig->getHttpTools()->createCollection(),
            $this->serverConfig->getHttpTools()->createCollection()
        );
    }
    /**
     * Define e retorna uma instância da Aplicação que a requisição
     * deseja executar.
     * 
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     *
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     *
     * @param       iServerRequest $serverRequest
     *              Instância "iServerRequest".
     * 
     * @param       iApplicationConfig $applicationConfig
     *              Instância "iApplicationConfig".
     * 
     * @param       ?iRouteConfig $routeConfig
     *              Instância "iRouteConfig".
     * 
     * @param       ?array $rawRouteConfig
     *              Configuração bruta da rota selecionada.
     * 
     * @return      void
     */
    private function defineTargetApplication(
        iDomainConfig $domainConfig,
        iServerConfig $serverConfig,
        iServerRequest $serverRequest,
        iApplicationConfig $applicationConfig,
        ?iRouteConfig $routeConfig,
        ?array $rawRouteConfig
    ) : iApplication {
        $applicationNS      = $domainConfig->retrieveApplicationNS();
        $targetApplication  = new $applicationNS();
        
        $targetApplication->setDomainConfig($domainConfig);
        $targetApplication->setServerConfig($serverConfig);
        $targetApplication->setServerRequest($serverRequest);
        $targetApplication->setApplicationConfig($applicationConfig);
        $targetApplication->setRouteConfig($routeConfig);
        $targetApplication->setRawRouteConfig($rawRouteConfig);

        return $targetApplication;
    }










    /**
     * Inicia um domínio.
     *
     * @param       ?iServerConfig $serverConfig
     *              Instância "iServerConfig" para ser usada pelo domínio. 
     *              Se nenhuma for definida então uma nova será instanciada usando
     *              os valores encontrados nas variáveis globais.
     */
    function __construct(?iServerConfig $serverConfig = null)
    {
        $this->serverConfig         = $this->defineServerConfig($serverConfig);
        $this->domainConfig         = $this->defineDomainConfig($this->serverConfig);
        $this->registerErrorListening();

        $this->applicationConfig    = $this->defineApplicationConfig($this->domainConfig);
        $this->applicationRouter    = $this->defineApplicationRouter($this->applicationConfig);
        $this->serverRequest        = $this->defineServerRequest($this->serverConfig);
    }





    /**
     * Indica se o método "run()" já foi ativado alguma vez.
     *
     * @var         bool
     */
    private $isRun = false;
    /**
     * Array associativo contendo as configurações da rota que 
     * corresponde a requição da URL que está sendo executada.
     *
     * @var         array
     */
    private $rawRouteConfig = null;
    /**
     * Instância que representa as configurações da rota que
     * deve ser executada.
     *
     * @var         iRouteConfig
     */
    private $routeConfig = null;





    /**
     * Verifica a necessidade de atualizar o arquivo de configuração
     * das rotas da Aplicação Alvo.
     *
     * @return      void
     */
    private function checkForUpdateRoutes() : void
    {
        $this->applicationRouter->setIsUpdateRoutes($this->domainConfig->getIsUpdateRoutes());


        // Sendo para atualizar as rotas
        // E
        // Estando com o debug mode ligado...
        // E
        // Estando em um ambiente definido como "local"
        //
        // força o update de rotas em toda requisição
        if ($this->domainConfig->getIsUpdateRoutes() === true &&
            $this->domainConfig->getIsDebugMode() === true &&
            $this->domainConfig->getEnvironmentType() === "local") 
        {
            $this->applicationRouter->forceUpdateRoutes();
        }


        // Efetua a recomposição do arquivo de rotas caso
        // seja necessário
        $this->applicationRouter->updateApplicationRoutes();
    }
    /**
     * Identifica e retorna as configurações de execução da rota alvo.
     *
     * @param       string $applicationName
     *              Nome da Aplicação alvo.
     * 
     * @param       string $requestMethod
     *              Método HTTP que está sendo usado.
     * 
     * @param       string $requestURIPath
     *              Parte relativa da URL que está sendo executada.
     * 
     * @param       iApplicationRouter $applicationRouter
     *              Roteador da aplicação.
     * 
     * @return      ?array
     */
    private function selectTargetRawRouteConfig(
        string $applicationName,
        string $requestMethod,
        string $requestURIPath,
        iApplicationRouter $applicationRouter
    ) : ?array  {
        // Se o nome da aplicação não foi definido no caminho 
        // relativo da URI que está sendo executada, adiciona-o
        $executePath = "/" . ltrim($requestURIPath, "/");
        if ($this->domainConfig->isApplicationNameOmitted() === true) {
            $executePath = "/" . $applicationName . "/" . ltrim($requestURIPath, "/");
        }

        // Seleciona os dados da rota que deve ser executada.
        return $applicationRouter->selectTargetRawRoute($executePath);
    }
    /** 
     * A partir dos dados brutos definidos como configuração de uma rota,
     * retorna uma instância "iRouteConfig".
     * 
     * @param       array $rawRouteConfig
     *              Configurações brutas da rota.
     */
    private function createRouteConfig(array $rawRouteConfig) : iRouteConfig
    {
        return new RouteConfig($rawRouteConfig);
    }
    /**
     * Deve ser executado imediatamente ANTES de executar a rota em si.
     * Efetuará todos os preparos necessários referentes as rotas da 
     * Aplicação para captura-la adequadamente.
     *
     * @return void
     */
    public function prepareRouteBeforeRun() : void
    {
        if ($this->isRun === false) {
            // Atualiza o arquivo de rotas da aplicação.
            $this->checkForUpdateRoutes();


            // Identifica os dados de configuração para 
            // a rota que deve ser acionada.
            $this->rawRouteConfig = $this->selectTargetRawRouteConfig(
                $this->applicationConfig->getName(),
                $this->serverRequest->getMethod(),
                $this->serverRequest->getUri()->getPath(),
                $this->applicationRouter
            );


            // Identificando exatamente a configuração da rota alvo
            $targetMethod = strtoupper($this->serverRequest->getMethod());
            if ($this->rawRouteConfig !== null && isset($this->rawRouteConfig[$targetMethod]) === true) {
                $this->routeConfig = $this->createRouteConfig($this->rawRouteConfig[$targetMethod]);
            }
        }
    }




    /**
     * Efetivamente inicia o processamento da 
     * requisição HTTP identificando qual aplicação deve ser iniciada
     * e então executada.
     *
     * @return      void
     */
    public function run() : void
    {
        if ($this->isRun === false) {
            $this->prepareRouteBeforeRun();
            $this->isRun = true;


            // Inicia a aplicação e define para ela
            // as configurações do servidor e do domínio.
            $this->targetApplication = $this->defineTargetApplication(
                $this->domainConfig,
                $this->serverConfig,
                $this->serverRequest,
                $this->applicationConfig,
                $this->routeConfig,
                $this->rawRouteConfig
            );


            // Seta para a Aplicação iniciada as 
            // suas próprias configurações
            $this->targetApplication->configureApplication();


            // Se a Aplicação iniciada tem uma página própria para
            // amostragem de erros, registra-a no manipulador de erros.
            $fullPathToErrorView = $this->applicationConfig->getFullPathToErrorView();
            if ($fullPathToErrorView !== null) {
                ErrorListening::setPathToErrorView($fullPathToErrorView);
            }


            // Inicia a resolução da rota selecionada
            // pela própria Aplicação
            $this->targetApplication->run();
        }
    }





    /**
     * Usado para testes em desenvolvimento.
     * Retorna um valor interno que poderá ser aferido
     * em ambiente de testes.
     *
     * @return      mixed
     */
    public function getTestViewDebug()
    {
        return $this->targetApplication->getTestViewDebug();
    }
}
