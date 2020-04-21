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
            "route"             => "/home",
            "action"            => "execHome"
        ];

        $this->assertEquals(
            $output,
            $nMock->testParseStringRouteConfiguration($input)
        );


        $input = "GET /home execHome secure";
        $output = [
            "allowedMethods"    => ["GET"],
            "route"             => "/home",
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
            "route"             => "/home",
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
            "route"             => "/home",
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
            "route"             => "/home",
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
            "route"             => "/home",
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

    /*
    public function test_method_set_default_route_config()
    {
        $nMock = prov_instanceOf_EnGarde_Engine_Router();
        $nMock->setDefaultRouteConfig(["property" => "value"]);
        $this->assertTrue(is_a($nMock, Router::class));
    }


    public function test_method_set_is_update_routes()
    {
        $nMock = prov_instanceOf_EnGarde_Engine_Router();
        $nMock->setIsUpdateRoutes(true);
        $this->assertTrue(is_a($nMock, Router::class));
    }


    public function test_method_force_update_routes()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $nMock = prov_instanceOf_EnGarde_Engine_Router();

        $baseAppDirectory = $dirResources . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        file_put_contents($appRoutes, "cfg-");

        $this->assertTrue(file_exists($appRoutes));
        $nMock->forceUpdateRoutes();
        $this->assertFalse(file_exists($appRoutes));


        file_put_contents($appRoutes, "cfg-");
        $this->assertTrue(file_exists($appRoutes));
    }


    public function test_method_check_for_update_application_routes()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $baseAppDirectory = $dirResources . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        $ctrlTest1 = $baseAppDirectory . "controllers" . $ds . "Test1.php";
        $ctrlTest2 = $baseAppDirectory . "controllers" . $ds . "Test2.php";

        if (file_exists($appRoutes)) {
            unlink($appRoutes);
        }
        if (file_exists($ctrlTest1)) {
            unlink($ctrlTest1);
        }
        if (file_exists($ctrlTest2)) {
            unlink($ctrlTest2);
        }

        file_put_contents($ctrlTest1, "test1-");
        file_put_contents($ctrlTest2, "test2-");



        $nMock = prov_instanceOf_EnGarde_Engine_Router();
        $nMock->setIsUpdateRoutes(true);
        $this->assertTrue($nMock->checkForUpdateApplicationRoutes());


        sleep(1);
        // Readiciona o arquivo de configuração 2 segundos após o
        // início do teste, fazendo com que ele seja mais recente que
        // os arquivos dos controllers.
        file_put_contents($appRoutes, "cfg-");
        $this->assertFalse($nMock->checkForUpdateApplicationRoutes());


        sleep(1);
        // Altera um dos controllers 2 segundos após o arquivo de configuração
        // ser alterado, para que assim, a atualização das rotas seja requerida.
        file_put_contents($ctrlTest1, "test1-", FILE_APPEND);
        $this->assertTrue($nMock->checkForUpdateApplicationRoutes(true));
    }


    public function test_method_update_application_routes()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $baseAppDirectory = $dirResources . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        $ctrlTest1 = $baseAppDirectory . "controllers" . $ds . "Test1.php";
        $ctrlTest2 = $baseAppDirectory . "controllers" . $ds . "Test2.php";
        $ctrlHome = $baseAppDirectory . "controllers" . $ds . "Home.php";

        if (file_exists($appRoutes)) {
            unlink($appRoutes);
        }
        if (file_exists($ctrlTest1)) {
            unlink($ctrlTest1);
        }
        if (file_exists($ctrlTest2)) {
            unlink($ctrlTest2);
        }



        require_once($ctrlHome);
        $nMock = prov_instanceOf_EnGarde_Engine_Router();
        $nMock->updateApplicationRoutes();
        $this->assertTrue(file_exists($appRoutes));
    }


    public function test_method_select_target_raw_route()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $baseAppDirectory = $dirResources . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        $ctrlHome = $baseAppDirectory . "controllers" . $ds . "Home.php";

        if (file_exists($appRoutes)) {
            unlink($appRoutes);
        }


        require_once($ctrlHome);
        $nMock = prov_instanceOf_EnGarde_Engine_Router();
        $nMock->updateApplicationRoutes();
        $this->assertTrue(file_exists($appRoutes));


        $r = $nMock->selectTargetRawRoute("/site");
        $this->assertNotNull($r);
        $this->assertTrue(is_array($r));


        $r = $nMock->selectTargetRawRoute("/site/list/nameasc/10");
        $this->assertNotNull($r);
        $this->assertTrue(is_array($r));


        $r = $nMock->selectTargetRawRoute("/site/configurando-uma-rota/propriedades/responseMime");
        $this->assertNotNull($r);
        $this->assertTrue(is_array($r));

        $expected = ["propertie" => "responseMime"];
        $this->assertSame($expected, $nMock->getSelectedRouteParans());
    }
    */
}





class MockRouterClass extends Router
{
    function __construct(iServer $serverConfig)
    {
        parent::__construct($serverConfig);
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


    public function testRegisterControllerRoutes(string $controllerName) {
        $this->registerControllerRoutes($controllerName);
    }
}
