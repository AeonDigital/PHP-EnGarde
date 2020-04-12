<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Domain\Engine as Engine;

require_once __DIR__ . "/../../phpunit.php";







class DomainEngineTest extends TestCase
{




    public function test_constructor()
    {
        global $dirResources;

        $serverConfig = prov_instanceOf_EnGarde_Config_Server(true);
        $serverConfig->setHttpFactory(
            prov_instanceOf_Http_Factory()
        );
        $domainConfig = prov_instanceOf_EnGarde_Config_Engine(
            true, "0.9.0 [alpha]", "test", false, false, $dirResources . "/apps"
        );
        $domainConfig->setPathToErrorView("errorView.phtml");

        $obj = new Engine($serverConfig, $domainConfig);
        $this->assertTrue(is_a($obj, Engine::class));
    }



    public function test_constructor_register_errorlistening()
    {
        global $dirResources;

        $domainEngine  = prov_instanceOf_EnGarde_Domain_Engine("localtest");
        $rootPath       = to_system_path($dirResources . "/apps");

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
        global $dirResources;

        $domainEngine      = prov_instanceOf_EnGarde_Domain_Engine("localtest", "GET", "/");
        $rootPath           = to_system_path($dirResources . "/apps");
        $pathToAppRoutes    = $rootPath . "/site/AppRoutes.php";

        if (file_exists($pathToAppRoutes) === true) {
            unlink($pathToAppRoutes);
        }

        $domainEngine->run();
        $this->assertTrue(file_exists($pathToAppRoutes));
    }

/*
    public function test_method_starttargetapplication()
    {
        $domainEngine  = prov_instanceOf_EnGarde_Domain_Engine("localtest");
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
        $domainEngine->run();

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
        $domainEngine  = prov_instanceOf_EnGarde_Domain_Engine(
            "localtest", "GET", "/customrun", null, null
        );

        $domainEngine->run();
        $this->assertSame("custom run executed", $domainEngine->getTestViewDebug());
    }
    */
}
