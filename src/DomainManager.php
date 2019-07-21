<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\EnGarde\Config\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Config\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\iApplication as iApplication;






/**
 * Gerenciador principal do domínio.
 * 
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @license     GNUv3
 * @copyright   Aeon Digital
 * @codeCoverageIgnore
 */
class DomainManager
{





    /**
     * Configurações do Servidor.
     *
     * @var         iServerConfig
     */
    private $serverConfig = null;
    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    private $serverRequest = null;
    /**
     * Configurações do Domínio
     *
     * @var         iDomainConfig
     */
    private $domainConfig = null;
    /**
     * Instância da Aplicação alvo.
     *
     * @var         iApplication
     */
    private $targetApplication = null;










    /**
     * Define o objeto "iServerConfig" para esta instância.
     *
     * @param       ?iServerConfig $serverConfig
     *              Instância "iServerConfig" para ser usada pelo domínio. 
     *              Se nenhuma for definida então uma nova será instanciada usando
     *              os valores encontrados nas variáveis globais.
     *
     * @return      void
     */
    private function defineServerConfig(?iServerConfig $serverConfig = null) : void
    {
        if ($serverConfig === null) {
            $isTestEnv = (ENVIRONMENT === "test" || ENVIRONMENT === "testview" || ENVIRONMENT === "localtest");
            $serverConfig = new \AeonDigital\EnGarde\Config\ServerConfig($_SERVER, $isTestEnv);
            $serverConfig->setHttpFactory(new \AeonDigital\EnGarde\Config\HttpFactory());
        }
        $this->serverConfig = $serverConfig;
    }
    /**
     * Define o objeto "iDomainConfig" para esta instância.
     * 
     * @param       ?iDomainConfig $domainConfig
     *              Instância "iDomainConfig" para ser usado pelo domínio.
     *              Se nenhuma for definida então uma nova será instanciada usando
     *              os valores encontrados nas constantes globais.
     *
     * @return      void
     */
    private function defineDomainConfig(?iDomainConfig $domainConfig = null) : void 
    {
        if ($domainConfig === null) {
            $domainConfig = new \AeonDigital\EnGarde\Config\DomainConfig();

            $domainConfig->setVersion("0.9.0 [alpha]");
            $domainConfig->setEnvironmentType(ENVIRONMENT);
            $domainConfig->setIsDebugMode(DEBUG_MODE);
            $domainConfig->setIsUpdateRoutes(UPDATE_ROUTES);
            $domainConfig->setRootPath($this->serverConfig->getRootPath());
            $domainConfig->setHostedApps(HOSTED_APPS);
            $domainConfig->setDefaultApp(DEFAULT_APP);
            $domainConfig->setDateTimeLocal(DATETIME_LOCAL);
            $domainConfig->setTimeOut(REQUEST_TIMEOUT);
            $domainConfig->setMaxFileSize(REQUEST_MAX_FILESIZE);
            $domainConfig->setMaxPostSize(REQUEST_MAX_POSTSIZE);
            $domainConfig->setApplicationClassName(APPLICATION_CLASSNAME);
            $domainConfig->setPathToErrorView(DEFAULT_ERROR_VIEW);
        }

        $domainConfig->setPHPDomainConfiguration();
        $domainConfig->defineTargetApplication($this->serverConfig->getRequestPath());
        $this->domainConfig = $domainConfig;
    }
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
     * Registra as configurações básicas para o manipulador de erros
     * e exceções do domínio.
     *
     * @return      void
     */
    private function registerErrorListening() : void 
    {
        \AeonDigital\EnGarde\Config\ErrorListening::setContext(
            $this->domainConfig->getRootPath(),
            $this->domainConfig->getEnvironmentType(),
            $this->domainConfig->getIsDebugMode(),
            $this->serverConfig->getRequestProtocol(),
            $this->serverRequest->getMethod(),
            $this->domainConfig->getFullPathToErrorView()
        );
        
        // Registra os manipuladores de erros do domínio
        set_exception_handler([\AeonDigital\EnGarde\Config\ErrorListening::class,   "onException"]);
        set_error_handler([\AeonDigital\EnGarde\Config\ErrorListening::class,       "onError"], E_ALL);
    }










    /**
     * Inicia um domínio.
     *
     * @param       ?iServerConfig $serverConfig
     *              Instância "iServerConfig" para ser usada pelo domínio. 
     *              Se nenhuma for definida então uma nova será instanciada usando
     *              os valores encontrados nas variáveis globais.
     * 
     * @param       ?iDomainConfig $domainConfig
     *              Instância "iDomainConfig" para ser usado pelo domínio.
     *              Se nenhuma for definida então uma nova será instanciada usando
     *              os valores encontrados nas constantes globais.
     */
    function __construct(
        ?iServerConfig $serverConfig = null,
        ?iDomainConfig $domainConfig = null
    ) {
        $this->defineServerConfig($serverConfig);
        $this->defineDomainConfig($domainConfig);
        $this->defineServerRequest();
        
        $this->registerErrorListening();
    }










    /**
     * Indica se o método "run()" já foi ativado alguma vez.
     *
     * @var         bool
     */
    private $isRun = false;
    /**
     * Efetivamente inicia o processamento da 
     * requisição HTTP identificando qual aplicação 
     * deve ser iniciada e então executada.
     *
     * @return      void
     */
    public function run() : void
    {
        if ($this->isRun === false) {
            $this->isRun = true;

            // Inicia uma instância da aplicação alvo.
            $this->targetApplication = $this->startTargetApplication();
            $this->targetApplication->run();
        }
    }





    /**
     * Retorna uma instância da aplicação que deve ser utilizada
     * para responder a requisição realizada.
     *
     * @return      iApplication
     */
    private function startTargetApplication() : iApplication
    {
        // Inicia a aplicação e define para ela
        // as configurações do servidor e do domínio.
        $applicationNS = $this->domainConfig->retrieveApplicationNS();
        return new $applicationNS(
            $this->serverConfig,
            $this->domainConfig,
            $this->serverRequest
        );
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
