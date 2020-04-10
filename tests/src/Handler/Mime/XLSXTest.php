<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Handler\Mime\XLSX as XLSX;

require_once __DIR__ . "/../../../phpunit.php";







class XLSXTest extends TestCase
{



    protected function createInstance()
    {
        $serverConfig       = prov_instanceOf_EnGarde_Config_Server();
        $domainConfig       = prov_instanceOf_EnGarde_Config_Domain();
        $applicationConfig  = prov_instanceOf_EnGarde_Config_Application();
        $serverRequest      = prov_instanceOf_Http_ServerRequest_01("GET", "/");
        $rawRouteConfig     = [];
        $response           = prov_instanceOf_Http_Response();


        $initialRouteConfigData = [
            "application"       => "Application",
            "namespace"         => "Use\\Namespace",
            "controller"        => "ControllerName",
            "action"            => "ActionName",
            "method"            => "get",

            "allowedMethods"    => ["get"],
            "routes"            => ["/", "/another/route"],
            "acceptMimes"       => ["txt", "html", "xhtml"],
            "isUseXHTML"        => true,
            "middlewares"       => ["MiddlewareName_One", "MiddlewareName_Two", "MiddlewareName_Tree"],

            "relationedRoutes"  => ["/services/routes"],
            "description"       => "Text about this route.",
            "devDescription"    => "Text to developers about this route.",
            "isSecure"          => false,
            "isUseCache"        => true,

            "cacheTimeout"      => 0,
            "responseHeaders"   => [],
            "responseMime"      => "html",
            "responseMimeType"  => "text/html",
            "responseLocale"    => "pt-br",

            "responseIsPrettyPrint"     => false,
            "responseIsDownload"        => false,
            "responseDownloadFileName"  => "autocreateDownloadFileName",
            "masterPage"                => "masterPage.phtml",
            "view"                      => "home/index.phtml",

            "form"              => "form.php",
            "styleSheets"       => ["style_01", "style_02"],
            "javaScripts"       => ["script_01", "script_02"],
            "localeDictionary"  => "path/to/pt-br.php",
            "metaData"          => ["author" => "Aeon Digital"],

            "runMethodName"     => "anotherRunMethod",
            "customProperties"  => ["prop1" => "val1", "prop2" => "val2"]
        ];
        $routeConfig        = prov_instanceOf_EnGarde_Config_Route($initialRouteConfigData);
        $routeConfig->setResponseIsPrettyPrint(true);


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


        $routeConfig->setMasterPage("");
        $routeConfig->setView("");
        return new XLSX(
            $serverConfig,
            $domainConfig,
            $applicationConfig,
            $serverRequest,
            $rawRouteConfig,
            $routeConfig,
            $response
        );
    }







    public function test_constructor_ok()
    {
        $obj = $this->createInstance();
        $this->assertTrue(is_a($obj, XLSX::class));
    }


    public function test_createResponseBody()
    {
        global $dirResources;

        $obj            = $this->createInstance();
        $response       = $obj->createResponseBody();
        $expectedPath   = to_system_path($dirResources . "/responses/responseGET.xlsx");
        if (file_exists($expectedPath) === false) {
            file_put_contents($expectedPath, $response);
        }
        $expected = file_get_contents($expectedPath);
        $this->assertSame($expected, $response);
    }
}
