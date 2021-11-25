<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Handler\Mime\TXT as TXT;

require_once __DIR__ . "/../../../phpunit.php";







class TXTTest extends TestCase
{



    protected function createInstance()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;

        $serverConfig = prov_instanceOf_EnGarde_Config_Server(
            $defaultServerVariables, [], $defaultEngineVariables
        );
        $serverConfig->getApplicationConfig($defaultApplication);


        $serverConfig->getRouteConfig([
            "application"               => "site",
            "namespace"                 => "\\site\\controller",
            "controller"                => "home",
            "resourceId"                => "rId",
            "action"                    => "index",
            "allowedMethods"            => ["GET", "POST"],
            "allowedMimeTypes"          => ["HTML", "JSON", "TXT"],
            "method"                    => "GET",
            "routes"                    => [
                "/",
                "/index",
                "/home"
            ],
            "activeRoute"               => "/",
            "isUseXHTML"                => true,
            "runMethodName"             => "",
            "customProperties"          => ["prop1" => "val1", "prop2" => "val2"],
            "description"               => "Text about this route.",
            "devDescription"            => "Text to developers about this route.",
            "relationedRoutes"          => [
                "/unit-test"
            ],
            "middlewares"               => [
                "MiddlewareName_One", "MiddlewareName_Two", "MiddlewareName_Tree"
            ],
            "isSecure"                  => false,
            "isUseCache"                => true,
            "cacheTimeout"              => (60*60*24*7),
            "responseIsPrettyPrint"     => true,
            "responseIsDownload"        => false,
            "responseDownloadFileName"  => "",
            "responseHeaders"           => [],
            "masterPage"                => "masterPage.phtml",
            "view"                      => "/home/index.phtml",
            "styleSheets"               => [
                "/css/main.css",
                "/css/index.css"
            ],
            "javaScripts"               => [
                "/js/main.js",
                "/js/index.js"
            ],
            "metaData"                  => [
                "Framework" => "EnGarde!",
                "Copyright" => "Aeon Digital"
            ],
            "localeDictionary"          => "/locales/pt-br"
        ]);
        $serverConfig->getRouteConfig()->setMasterPage("");
        $serverConfig->getRouteConfig()->setView("");



        $response = prov_instanceOf_Http_Response();
        $response = $response->withViewData((object)[
            "viewTitle" => "Página de teste",
            "prop1" => true,
            "prop2" => false,
            "prop3" => 0,
            "prop4" => 0.552,
            "prop5" => new DateTime("2000-01-01 00:00:00"),
            "prop6" => [1, 2, 3, "4", "teste"],
            "prop7" => ["p7.1" => 1, "p7.2" => 2],
            "dataTable" => [
                ["col1", "col2", "col3", "col4"],
                ["a1", "a2", "a3", "a4"],
                ["b1", "b2", "b3", "b4"],
                ["c1", "c2", "c3", "c4"],
            ]
        ]);


        return new TXT(
            $serverConfig,
            $response
        );
    }



    public function test_constructor_ok()
    {
        $obj = $this->createInstance();
        $this->assertTrue(is_a($obj, TXT::class));
    }



    public function test_createResponseBody()
    {
        global $dirResources;

        $obj            = $this->createInstance();
        $response       = $obj->createResponseBody();
        $expectedPath   = to_system_path($dirResources . "/responses/responseGET.txt");
        if (file_exists($expectedPath) === false) {
            file_put_contents($expectedPath, $response);
        }
        $expected = file_get_contents($expectedPath);
        $this->assertSame($expected, $response);
    }
}
