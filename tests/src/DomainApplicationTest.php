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


    public function test_method_getset_server_config()
    {
        $nMock = new AppConfig();
        $serverConfig = $this->retrieveServerConfig();
        $nMock->setServerConfig($serverConfig);

        $this->assertSame($serverConfig, $nMock->getServerConfig());
    }


    public function test_method_getset_domain_config()
    {
        $nMock = new AppConfig();
        $domainConfig = $this->retrieveDomainConfig();
        $nMock->setDomainConfig($domainConfig);

        $this->assertSame($domainConfig, $nMock->getDomainConfig());
    }


    public function test_method_getset_application_config()
    {
        $nMock = new AppConfig();
        $domainConfig       = $this->retrieveDomainConfig();
        $applicationConfig  = $this->retrieveApplicationConfig(
                                $domainConfig->getApplicationName(),
                                $domainConfig->getRootPath());

        $nMock->setApplicationConfig($applicationConfig);

        $this->assertSame($applicationConfig, $nMock->getApplicationConfig());
    }


    public function test_method_getset_route_config()
    {
        $nMock = new AppConfig();
        $routeConfig = $this->retrieveRouteConfig();
        
        $nMock->setRouteConfig($routeConfig);
        $this->assertSame($routeConfig, $nMock->getRouteConfig());
    }


    public function test_method_getset_raw_route_config()
    {
        $nMock = new AppConfig();
        $val = ["prop1" => "val1", "prop2" => "val2"];
        
        $nMock->setRawRouteConfig($val);
        $this->assertSame($val, $nMock->getRawRouteConfig());
    }


}
