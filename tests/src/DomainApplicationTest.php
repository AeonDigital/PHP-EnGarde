<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Tests\Concrete\AppConfig as AppConfig;

require_once __DIR__ . "/../phpunit.php";







class DomainApplicationTest extends TestCase
{



    private function retrieveServerConfig()
    {
        return new \AeonDigital\Http\Tools\ServerConfig($_SERVER);
    }

    private function retrieveServerRequest()
    {
        $serverConfig = new \AeonDigital\Http\Tools\ServerConfig(null, true);
        $serverConfig->setHttpTools(new \AeonDigital\Http\Tools\Tools());

        return $serverConfig->getHttpTools()->createServerRequest(
            $serverConfig->getRequestMethod(),
            $serverConfig->getCurrentURI(),
            $serverConfig->getRequestHTTPVersion(),
            $serverConfig->getHttpTools()->createHeaderCollection($serverConfig->getRequestHeaders()),
            $serverConfig->getHttpTools()->createStreamFromBodyRequest(),
            $serverConfig->getHttpTools()->createCookieCollection($serverConfig->getRequestCookies()),
            $serverConfig->getHttpTools()->createQueryStringCollection($serverConfig->getRequestQueryStrings()),
            $serverConfig->getHttpTools()->createFileCollection($serverConfig->getRequestFiles()),
            $serverConfig->getServerVariables(),
            $serverConfig->getHttpTools()->createCollection(),
            $serverConfig->getHttpTools()->createCollection()
        );
    }

    private function retrieveDomainConfig()
    {
        $domainConfig = new \AeonDigital\EnGarde\Config\DomainConfig();
        $ds = DIRECTORY_SEPARATOR;
        $rootPath = dirname(__FILE__) . $ds . "apps";
        
        // Configura o domínio
        // com seus valores iniciais.
        $domainConfig->setVersion("0.9.0 [alpha]");

        $domainConfig->setEnvironmentType("test");
        $domainConfig->setIsDebugMode(true);
        $domainConfig->setIsUpdateRoutes(true);
        $domainConfig->setRootPath($rootPath);
        $domainConfig->setHostedApps(["site", "blog"]);
        $domainConfig->setDefaultApp("site");
        $domainConfig->setDateTimeLocal("America/Sao_Paulo");
        $domainConfig->setTimeOut(1200);
        $domainConfig->setMaxFileSize(100);
        $domainConfig->setMaxPostSize(100);
        $domainConfig->setApplicationClassName("AppStart");


        $domainConfig->setPHPDomainConfiguration();

        // Identifica qual aplicação deve ser iniciada.
        $domainConfig->defineTargetApplication("http://aeondigital.com.br");


        return $domainConfig;
    }

    private function retrieveApplicationConfig($appName, $rootPath)
    {
        return new \AeonDigital\EnGarde\Config\ApplicationConfig($appName, $rootPath);
    }

    private function retrieveRouteConfig()
    {
        return new \AeonDigital\EnGarde\Config\RouteConfig();
    }





    public function test_constructor_ok()
    {
        $nMock = new AppConfig();
        $this->assertTrue(is_a($nMock, AppConfig::class));
    }


    public function test_method_set_commom_properties()
    {
        $nMock = new AppConfig();
        
        $domainConfig = $this->retrieveDomainConfig();
        $nMock->setDomainConfig($domainConfig);

        $serverConfig = $this->retrieveServerConfig();
        $nMock->setServerConfig($serverConfig);

        $serverRequest = $this->retrieveServerRequest();
        $nMock->setServerRequest($serverRequest);

        $applicationConfig  = $this->retrieveApplicationConfig(
                                $domainConfig->getApplicationName(),
                                $domainConfig->getRootPath());
        $nMock->setApplicationConfig($applicationConfig);


        $routeConfig = $this->retrieveRouteConfig();
        $nMock->setRouteConfig($routeConfig);


        $val = ["prop1" => "val1", "prop2" => "val2"];
        $nMock->setRawRouteConfig($val);

        $this->assertTrue(true);
    }
}
