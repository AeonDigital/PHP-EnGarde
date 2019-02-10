<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\DomainManager as DomainManager;

require_once __DIR__ . "/../phpunit.php";







class DomainManagerTest extends TestCase
{




    public function test_constructor()
    {
        $serverConfig = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $httpFactory = provider_PHPEnGardeConfig_InstanceOf_HttpFactory();
        $serverConfig->setHttpFactory($httpFactory);

        $domainConfig = provider_PHPEnGardeConfig_InstanceOf_DomainConfig(
            true, "0.9.0 [alpha]", "test", false, false, to_system_path(__DIR__ . "/apps")
        );
        $domainConfig->setPathToErrorView("errorView.phtml");

        $obj = new DomainManager($serverConfig, $domainConfig);
        $this->assertTrue(is_a($obj, DomainManager::class));
    }
    

    
    public function test_constructor_register_errorlistening()
    {
        $domainManager  = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet("localtest");
        $rootPath       = to_system_path(__DIR__ . DIRECTORY_SEPARATOR . "apps");

        $expected = [
            "rootPath"          => $rootPath . DS,
            "environmentType"   => "localtest",
            "isDebugMode"       => false,
            "protocol"          => "http",
            "method"            => "GET",
            "pathToErrorView"   => $rootPath . DS . "errorView.phtml"
        ];

        $errorContext = \AeonDigital\EnGarde\Config\ErrorListening::getContext();
        $this->assertSame($expected, $errorContext);
    }

    
    public function test_constructor_register_routes()
    {
        $domainManager      = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet("localtest", "GET", "/");
        $rootPath           = to_system_path(__DIR__ . DIRECTORY_SEPARATOR . "apps");
        $pathToAppRoutes    = $rootPath . DS . "site/AppRoutes.php";

        if (file_exists($pathToAppRoutes) === true) {
            unlink($pathToAppRoutes);
        }

        $domainManager->run();
        $this->assertTrue(file_exists($pathToAppRoutes));
    }

    
    public function test_method_starttargetapplication()
    {
        $domainManager  = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet("localtest");
        $rootPath       = to_system_path(__DIR__ . DIRECTORY_SEPARATOR . "apps");

        $expected = [
            "rootPath"          => $rootPath . DS,
            "environmentType"   => "localtest",
            "isDebugMode"       => false,
            "protocol"          => "http",
            "method"            => "GET",
            "pathToErrorView"   => $rootPath . DS . "errorView.phtml"
        ];

        $errorContext = \AeonDigital\EnGarde\Config\ErrorListening::getContext();
        $this->assertSame($expected, $errorContext);


        // Roda a aplicação alvo
        $domainManager->run();

        $expected = [
            "rootPath"          => $rootPath . DS,
            "environmentType"   => "localtest",
            "isDebugMode"       => false,
            "protocol"          => "http",
            "method"            => "GET",
            "pathToErrorView"   => to_system_path($rootPath . DS . "site/views/_shared/errorView.phtml")
        ];
        
        $errorContext = \AeonDigital\EnGarde\Config\ErrorListening::getContext();
        $this->assertSame($expected, $errorContext);
    }


    public function test_method_custom_run() 
    {
        $domainManager  = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet(
            "localtest", "GET", "/customrun", null, null
        );

        $domainManager->run();
        $this->assertSame("custom run executed", $domainManager->getTestViewDebug());
    }
}
