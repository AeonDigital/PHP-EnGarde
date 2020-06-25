<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Engine\Router as Router;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServer;

require_once __DIR__ . "/../phpunit.php";






class RouterTest extends TestCase
{



    protected function provideRouteMock()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $serverConfig = prov_instanceOf_EnGarde_Config_Server(
            $defaultServerVariables, [], $defaultEngineVariables
        );
        $serverConfig->getApplicationConfig($defaultApplication);
        $serverConfig->getSecurityConfig($defaultSecurity);


        global $dirResources;
        include_once to_system_path($dirResources . "/apps/site/controllers/Home.php");
        if (is_file($dirResources . "/apps/site/controllers/Test.php") === true) {
            include_once to_system_path($dirResources . "/apps/site/controllers/Test.php");
        }


        return new MockRouterClass($serverConfig);
    }





    public function test_constructor_ok()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $serverConfig = prov_instanceOf_EnGarde_Config_Server(
            $defaultServerVariables, [], $defaultEngineVariables
        );
        $serverConfig->getApplicationConfig($defaultApplication);
        $serverConfig->getSecurityConfig($defaultSecurity);


        $nMock = new Router($serverConfig);
        $this->assertTrue(is_a($nMock, Router::class));
    }


    public function test_method_normalizeRouteRegEx()
    {
        $nMock = $this->provideRouteMock();

        $input = "/backstage/rec:[_a-zA-Z]+/id:[\d]+/";
        $output = "/^\/backstage\/(?P<rec>[_a-zA-Z]+)\/(?P<id>[\d]+)\//";

        $this->assertEquals(
            $output,
            $nMock->testNormalizeRouteRegEx($input)
        );
    }


    public function test_method_parseStringRouteConfiguration_fails()
    {
        $nMock = $this->provideRouteMock();

        $input = "/home";
        $fail = false;
        try {
            $nMock->testParseStringRouteConfiguration($input);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Route configuration fail. Check documentation [ \"/home\" ].",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $input = "GET /home execHome secure cache";
        $fail = false;
        try {
            $nMock->testParseStringRouteConfiguration($input);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Route configuration fail. Cache timeout must be a integer greather than zero. Given: [ \"GET /home execHome secure cache\" ].",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $input = "GET /home execHome secure cache -2";
        $fail = false;
        try {
            $nMock->testParseStringRouteConfiguration($input);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Route configuration fail. Cache timeout must be a integer greather than zero. Given: [ \"GET /home execHome secure cache -2\" ].",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_parseStringRouteConfiguration()
    {
        $nMock = $this->provideRouteMock();

        $input = "/home execHome";
        $output = [
            "allowedMethods"    => ["GET"],
            "routes"            => ["/home"],
            "action"            => "execHome"
        ];

        $this->assertEquals(
            $output,
            $nMock->testParseStringRouteConfiguration($input)
        );


        $input = "GET /home execHome secure";
        $output = [
            "allowedMethods"    => ["GET"],
            "routes"            => ["/home"],
            "action"            => "execHome",
            "isSecure"          => true
        ];

        $this->assertEquals(
            $output,
            $nMock->testParseStringRouteConfiguration($input)
        );



        $input = "GET /home execHome public";
        $output = [
            "allowedMethods"    => ["GET"],
            "routes"            => ["/home"],
            "action"            => "execHome",
            "isSecure"          => false
        ];

        $this->assertEquals(
            $output,
            $nMock->testParseStringRouteConfiguration($input)
        );



        $input = "GET /home execHome public no-cache";
        $output = [
            "allowedMethods"    => ["GET"],
            "routes"            => ["/home"],
            "action"            => "execHome",
            "isSecure"          => false,
            "isUseCache"        => false
        ];

        $this->assertEquals(
            $output,
            $nMock->testParseStringRouteConfiguration($input)
        );



        $input = "GET /home execHome public cache 1";
        $output = [
            "allowedMethods"    => ["GET"],
            "routes"            => ["/home"],
            "action"            => "execHome",
            "isSecure"          => false,
            "isUseCache"        => true,
            "cacheTimeout"      => 1
        ];

        $this->assertEquals(
            $output,
            $nMock->testParseStringRouteConfiguration($input)
        );



        $input = "GET /home execHome - cache 1";
        $output = [
            "allowedMethods"    => ["GET"],
            "routes"            => ["/home"],
            "action"            => "execHome",
            "isUseCache"        => true,
            "cacheTimeout"      => 1
        ];

        $this->assertEquals(
            $output,
            $nMock->testParseStringRouteConfiguration($input)
        );
    }


    public function test_method_mergeRouteConfigs()
    {
        global $defaultApplicationRouteConfig;
        global $defaultControllerRouteConfig;
        global $defaultRoute;

        $nMock = $this->provideRouteMock();

        $mergeAppAndController = $nMock->testMergeRouteConfigs(
            $defaultApplicationRouteConfig,
            $defaultControllerRouteConfig,
            true
        );
        $expected = [
            "application"               => "site",
            "namespace"                 => "\\site\\controller",
            "controller"                => "home",
            "allowedMethods"            => ["GET", "POST", "PUT"],
            "allowedMimeTypes"          => ["HTML", "JSON", "XML"],
            "isUseXHTML"                => false,
            "description"               => "Controller",
            "devDescription"            => "Controller - Teste unitário",
            "runMethodName"             => "run",
            "isSecure"                  => true,
            "isUseCache"                => false,
            "cacheTimeout"              => 0,
            "middlewares"               => ["mid01", "mid02", "mid03"]

        ];
        $this->assertEquals($expected, $mergeAppAndController);



        $mergeControllerAndRoute = $nMock->testMergeRouteConfigs(
            $mergeAppAndController,
            $defaultRoute
        );
        $expected = [
            "application"               => "site",
            "namespace"                 => "\\site\\controller",
            "controller"                => "home",
            "action"                    => "index",
            "allowedMethods"            => ["GET", "POST"],
            "allowedMimeTypes"          => ["HTML", "JSON"],
            "routes"                    => [
                "/",
                "/index",
                "/home"
            ],
            "isUseXHTML"                => true,
            "runMethodName"             => "",
            "customProperties"          => [],
            "description"               => "Teste",
            "devDescription"            => "Teste unitário",
            "relationedRoutes"          => [
                "/unit-test"
            ],
            "middlewares"               => ["mid01", "mid02", "mid03"],
            "isSecure"                  => false,
            "isUseCache"                => true,
            "cacheTimeout"              => (60*60*24*7),
            "responseHeaders"           => [],
            "masterPage"                => "masterPage.phtml",
            "view"                      => "/home/index.phtml",
            "styleSheets"               => [
                "main.css",
                "index.css"
            ],
            "javaScripts"               => [
                "main.js",
                "index.js"
            ],
            "metaData"                  => [
                "Framework" => "EnGarde!",
                "Copyright" => "Aeon Digital"
            ],
            "localeDictionary"          => "/locales/pt-br"
        ];
        $this->assertEquals($expected["application"],       $mergeControllerAndRoute["application"]);
        $this->assertEquals($expected["namespace"],         $mergeControllerAndRoute["namespace"]);
        $this->assertEquals($expected["controller"],        $mergeControllerAndRoute["controller"]);
        $this->assertEquals($expected["action"],            $mergeControllerAndRoute["action"]);
        $this->assertEquals($expected["allowedMethods"],    $mergeControllerAndRoute["allowedMethods"]);
        $this->assertEquals($expected["allowedMimeTypes"],  $mergeControllerAndRoute["allowedMimeTypes"]);
        $this->assertEquals($expected["routes"],            $mergeControllerAndRoute["routes"]);
        $this->assertEquals($expected["isUseXHTML"],        $mergeControllerAndRoute["isUseXHTML"]);
        $this->assertEquals($expected["runMethodName"],     $mergeControllerAndRoute["runMethodName"]);
        $this->assertEquals($expected["customProperties"],  $mergeControllerAndRoute["customProperties"]);
        $this->assertEquals($expected["devDescription"],    $mergeControllerAndRoute["devDescription"]);
        $this->assertEquals($expected["relationedRoutes"],  $mergeControllerAndRoute["relationedRoutes"]);
        $this->assertEquals($expected["middlewares"],       $mergeControllerAndRoute["middlewares"]);
        $this->assertEquals($expected["isSecure"],          $mergeControllerAndRoute["isSecure"]);
        $this->assertEquals($expected["isUseCache"],        $mergeControllerAndRoute["isUseCache"]);
        $this->assertEquals($expected["cacheTimeout"],      $mergeControllerAndRoute["cacheTimeout"]);
        $this->assertEquals($expected["responseHeaders"],   $mergeControllerAndRoute["responseHeaders"]);
        $this->assertEquals($expected["masterPage"],        $mergeControllerAndRoute["masterPage"]);
        $this->assertEquals($expected["view"],              $mergeControllerAndRoute["view"]);
        $this->assertEquals($expected["styleSheets"],       $mergeControllerAndRoute["styleSheets"]);
        $this->assertEquals($expected["javaScripts"],       $mergeControllerAndRoute["javaScripts"]);
        $this->assertEquals($expected["metaData"],          $mergeControllerAndRoute["metaData"]);
        $this->assertEquals($expected["localeDictionary"],  $mergeControllerAndRoute["localeDictionary"]);
    }


    public function test_method_registerControllerRoutes()
    {
        global $dirResources;
        $nMock = $this->provideRouteMock();

        include_once to_system_path($dirResources . "/apps/site/controllers/Home.php");
        $targetFileResult   = to_system_path($dirResources . "/router/result.php");
        $targetFileExpected = to_system_path($dirResources . "/router/expected.php");

        $processed = $nMock->testRegisterControllerRoutes("home");
        $resultProcessed = \var_export($nMock->getProcessedAppRoutes(), true);

        if (is_file($targetFileExpected) === false) {
            file_put_contents(
                $targetFileExpected,
                $resultProcessed
            );
        }

        $expectedResult = file_get_contents($targetFileExpected);
        $this->assertEquals($expectedResult, $resultProcessed);
    }


    public function test_method_isToProcessApplicationRoutes()
    {
        global $dirResources;
        global $defaultEngineVariables;
        $oIsDebugMode       = $defaultEngineVariables["isDebugMode"];
        $oIsUpdateRoutes    = $defaultEngineVariables["isUpdateRoutes"];
        $oEnvironmentType   = $defaultEngineVariables["environmentType"];


        // Retorno ``true`` por configurações do ambiente.
        $defaultEngineVariables["isDebugMode"]      = true;
        $defaultEngineVariables["isUpdateRoutes"]   = true;
        $defaultEngineVariables["environmentType"]  = "LCL";


        $nMock = $this->provideRouteMock();
        $this->assertTrue($nMock->isToProcessApplicationRoutes());



        // Retorna ``true`` devido a ausencia do arquivo de configuração
        $defaultEngineVariables["isDebugMode"] = false;
        $pathToAppRoutes = $nMock->getPathToAppRoutes();
        if (is_file($pathToAppRoutes) === true) { unlink($pathToAppRoutes); }

        $nMock = $this->provideRouteMock();
        $this->assertTrue($nMock->isToProcessApplicationRoutes());



        // Retorna ``false`` pois o arquivo existe, no entanto, não deve ser atualizado.
        $defaultEngineVariables["isDebugMode"] = true;
        $defaultEngineVariables["isUpdateRoutes"] = false;
        if (is_file($pathToAppRoutes) === false) {
            file_put_contents($pathToAppRoutes, "exists");
        }

        $nMock = $this->provideRouteMock();
        $this->assertFalse($nMock->isToProcessApplicationRoutes());



        // Retorna ``true`` pois o arquivo existe, no entanto, há uma atualização num controller
        // posterior a data de criação.
        $defaultEngineVariables["isDebugMode"] = false;
        $defaultEngineVariables["isUpdateRoutes"] = true;
        sleep(2);
        file_put_contents(
            $dirResources . "/apps/site/controllers/Test.php",
            "<?php
                declare (strict_types=1);

                namespace site\controllers;

                class Test {}"
        );

        $nMock = $this->provideRouteMock();



        $defaultEngineVariables["isDebugMode"]      = $oIsDebugMode;
        $defaultEngineVariables["isUpdateRoutes"]   = $oIsUpdateRoutes;
        $defaultEngineVariables["environmentType"]  = $oEnvironmentType;
    }



    public function test_method_processApplicationRoutes()
    {
        $nMock = $this->provideRouteMock();
        $pathToAppRoutes = $nMock->getPathToAppRoutes();

        if (is_file($pathToAppRoutes) === true) {
            unlink($pathToAppRoutes);
        }

        $nMock->testProcessApplicationRoutes();
        $this->assertTrue(is_file($pathToAppRoutes));
    }





    public function test_method_select_target_raw_route()
    {
        $nMock = $this->provideRouteMock();
        $nMock->testProcessApplicationRoutes();



        $r = $nMock->selectTargetRawRoute("/site");
        $this->assertNotNull($r);

        $this->assertTrue(is_array($r));
        $expectedParans = null;
        $this->assertSame("/^\/site\//", $r["route"]);
        $this->assertSame($expectedParans, $r["parans"]);



        $r = $nMock->selectTargetRawRoute("/site/home");
        $this->assertNotNull($r);

        $this->assertTrue(is_array($r));
        $expectedParans = null;
        $this->assertSame("/^\/site\/home\//", $r["route"]);
        $this->assertSame($expectedParans, $r["parans"]);



        $r = $nMock->selectTargetRawRoute("/site/list/nameasc/10");
        $this->assertNotNull($r);

        $this->assertTrue(is_array($r));
        $expectedParans = ["orderby" => "nameasc", "page" => "10"];
        $this->assertSame("/^\/site\/list\/(?P<orderby>[a-zA-Z]+)\/(?P<page>[0-9]+)\//", $r["route"]);
        $this->assertSame($expectedParans, $r["parans"]);



        $r = $nMock->selectTargetRawRoute("/site/configurando-uma-rota/propriedades/responseMime");
        $this->assertNotNull($r);

        $this->assertTrue(is_array($r));
        $expectedParans = ["propertie" => "responseMime"];
        $this->assertSame("/^\/site\/configurando-uma-rota\/propriedades\/(?P<propertie>[a-zA-Z]+)\//", $r["route"]);
        $this->assertSame($expectedParans, $r["parans"]);
    }
}





class MockRouterClass extends Router
{
    function __construct(iServer $serverConfig)
    {
        parent::__construct($serverConfig);
    }



    public function getProcessedAppRoutes() : array
    {
        return $this->appRoutes;
    }
    public function getPathToAppRoutes() : string
    {
        return $this->serverConfig->
            getApplicationConfig()->
            getPathToAppRoutes(true);
    }





    public function testNormalizeRouteRegEx(string $route) : string
    {
        return $this->normalizeRouteRegEx($route);
    }


    public function testParseStringRouteConfiguration(string $config) : array
    {
        return $this->parseStringRouteConfiguration($config);
    }


    public function testMergeRouteConfigs(
        array $initialRouteConfig,
        array $newRouteConfig,
        bool $isController = false
    ) : array {
        return $this->mergeRouteConfigs(
            $initialRouteConfig,
            $newRouteConfig,
            $isController
        );
    }


    public function testRegisterControllerRoutes(string $controllerName)
    {
        $this->registerControllerRoutes($controllerName);
    }




    public function testProcessApplicationRoutes() : void
    {
        $this->processApplicationRoutes();
    }


}
