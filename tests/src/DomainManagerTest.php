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
            "localtest", "GET", "/", null, null, "customRun"
        );

        $domainManager->run();
        $this->assertSame("custom run executed", $domainManager->getTestViewDebug());
    }






    
    public function test_check_response_to_error_404()
    {
        $domainManager = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet("localtest", "GET", "/non-exist-route/for/this");
        $domainManager->run();
        $output = $domainManager->getTestViewDebug();

        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/error404.html";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, $output);
        $this->assertSame($expected, $output);
    }


    public function test_check_response_to_error_501()
    {
        $domainManager = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet("testview", "PUT", "/");
        $domainManager->run();
        $output = $domainManager->getTestViewDebug();

        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/error501.html";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, $output);
        $this->assertSame($expected, $output);
    }


    /*
    public function test_check_response_to_GET()
    {
        $domainManager = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet("testview", "GET", "/", null, null, "0.9.0 [alpha]", true);
        $domainManager->run();
        $output = $domainManager->getTestViewDebug();

        
        $expectedViewData = (object)[
            "EndExecute_route_mid_03" => "middleware",
            "EndExecute_route_mid_02" => "middleware",
            "EndExecute_route_mid_01" => "middleware",
            "EndExecute_ctrl_mid_03" => "middleware",
            "EndExecute_ctrl_mid_02" => "middleware",
            "EndExecute_ctrl_mid_01" => "middleware",
            "appTitle" => "Application Title",
            "viewTitle" => "View Title"
        ];

        // Verifica se os middlewares foram executados.
        // o processamento deles e encadeado portanto a finalização de cada
        // qual ocorre do último para o primeiro.
        $this->assertEquals($expectedViewData, $output->getViewData());

        // Verifica informação definida no processamento da action
        // capaz de modificar a configuração da construção da view.
        $expectedMetaData = ["meta01" => "val01"];
        $this->assertEquals($expectedMetaData, $output->getViewConfig()->metaData);
        

        // Verifica o set dos modelos de  master page e view.
        $this->assertEquals("masterPage.phtml", $output->getViewConfig()->masterPage);
        $this->assertEquals("home/index.phtml", $output->getViewConfig()->view);
        
        

        // É preciso verificar todas as configurações de todos os objetos de
        // configuração para identificar quais já estão implementados,
        // quais restam implementar e os que os devs das aplicações podem vir a implementar.
        // Há métodos em "iApplicationConfig" e em "iRouteConfig" que precisam ser implementados.
        //
        // iApplication->setPathToLocales()
        // iApplication->setPathToCacheFiles()
        // iApplication->setIsUseLabels()
        // iRouteConfig->setIsSecure()
        // iRouteConfig->setIsUseCache()
        // iRouteConfig->setCacheTimeout()
        // iRouteConfig->setResponseIsPrettyPrint()
        // iRouteConfig->setForm()
        // iRouteConfig->setLocaleDictionary()
        // 

        // Verifica a criação da view
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGET.html";
        //$expected           = file_get_contents($tgtPathToExpected);

        //$objExpected    = json_decode($expected);
        $objOutput      = (string)$output->getBody();

        //file_put_contents($tgtPathToExpected, (string)$output->getBody());
        $this->assertEquals($objExpected->requestData, $objOutput->requestData);
    }
    */
}
