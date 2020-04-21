<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Route as Route;

require_once __DIR__ . "/../../phpunit.php";







class ConfigRouteTest extends TestCase
{





    public function test_constructor_ok()
    {
        global $defaultRoute;
        $nMock = new Route(
            $defaultRoute["application"],
            $defaultRoute["namespace"],
            $defaultRoute["controller"],
            $defaultRoute["action"],
            $defaultRoute["allowedMethods"],
            $defaultRoute["allowedMimeTypes"],
            $defaultRoute["method"],
            $defaultRoute["routes"],
            $defaultRoute["isUseXHTML"],
            $defaultRoute["runMethodName"],
            $defaultRoute["customProperties"],
            $defaultRoute["description"],
            $defaultRoute["devDescription"],
            $defaultRoute["relationedRoutes"],
            $defaultRoute["middlewares"],
            $defaultRoute["isSecure"],
            $defaultRoute["isUseCache"],
            $defaultRoute["cacheTimeout"],
            $defaultRoute["responseIsPrettyPrint"],
            $defaultRoute["responseIsDownload"],
            $defaultRoute["responseDownloadFileName"],
            $defaultRoute["responseHeaders"],
            $defaultRoute["masterPage"],
            $defaultRoute["view"],
            $defaultRoute["styleSheets"],
            $defaultRoute["javaScripts"],
            $defaultRoute["metaData"],
            $defaultRoute["localeDictionary"]
        );
        $this->assertTrue(is_a($nMock, Route::class));


        $this->assertSame("site", $nMock->getApplication());
        $this->assertSame("\\site\\controller", $nMock->getNamespace());
        $this->assertSame("home", $nMock->getController());
        $this->assertSame("index", $nMock->getAction());
        $this->assertSame(["GET", "POST"], $nMock->getAllowedMethods());
        $this->assertSame(
            [
                "html" => "text/html",
                "json" => "application/json"
            ],
            $nMock->getAllowedMimeTypes()
        );
        $this->assertSame("GET", $nMock->getMethod());
        $this->assertSame(["/", "/index", "/home"], $nMock->getRoutes());
        $this->assertSame(true, $nMock->getIsUseXHTML());
        $this->assertSame("run", $nMock->getRunMethodName());
        $this->assertSame([], $nMock->getCustomProperties());
        $this->assertSame("Teste", $nMock->getDescription());
        $this->assertSame("Teste unitário", $nMock->getDevDescription());
        $this->assertSame(["/unit-test"], $nMock->getRelationedRoutes());
        $this->assertSame([], $nMock->getMiddlewares());
        $this->assertSame(false, $nMock->getIsSecure());
        $this->assertSame(true, $nMock->getIsUseCache());
        $this->assertSame((60*60*24*7), $nMock->getCacheTimeout());
        $this->assertSame(true, $nMock->getResponseIsPrettyPrint());
        $this->assertSame(false, $nMock->getResponseIsDownload());
        $this->assertSame([], $nMock->getResponseHeaders());
        $this->assertSame("masterPage.phtml", $nMock->getMasterPage());
        $this->assertSame("/home/index.phtml", $nMock->getView());
        $this->assertSame(["main.css", "index.css" ], $nMock->getStyleSheets());
        $this->assertSame(["main.js", "index.js" ], $nMock->getJavaScripts());
        $this->assertSame(
            [
                "Framework" => "EnGarde!",
                "Copyright" => "Aeon Digital"
            ],
            $nMock->getMetaData()
        );
        $this->assertSame("/locales/pt-br", $nMock->getLocaleDictionary());
    }





    public function test_method_set_application_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["application"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"application\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_namespace_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["namespace"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"namespace\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_controller_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["controller"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"controller\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_action_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["action"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"action\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_allowedmethods_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["allowedMethods"] = [""];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"allowedMethods['0']\". Expected [ GET, HEAD, POST, PUT, PATCH, DELETE, CONNECT, OPTIONS, TRACE ].",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testRoute["allowedMethods"] = ["INVALID"];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"allowedMethods['0']\". Expected [ GET, HEAD, POST, PUT, PATCH, DELETE, CONNECT, OPTIONS, TRACE ]. Given: [ INVALID ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_allowedmimetypes_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["allowedMimeTypes"] = [""];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"allowedMimeTypes['0']\". Expected [ txt, html, xhtml, json, xml, pdf, csv, xls, xlsx ].",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testRoute["allowedMimeTypes"] = ["INVALID"];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"allowedMimeTypes['0']\". Expected [ txt, html, xhtml, json, xml, pdf, csv, xls, xlsx ]. Given: [ invalid ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_method_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["method"] = "invalid";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"method\". Expected [ GET, POST ]. Given: [ invalid ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_routes_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["routes"] = [];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"routes\". Expected a non-empty array.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testRoute["routes"] = [""];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"routes['0']\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_middlewares_fails()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["middlewares"] = [""];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"middlewares['0']\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }




    /*
    public function test_method_negotiate_locale()
    {

        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $requestLocales     = ["pt-BR", "en-us", "es-es"];
        $requestLanguages   = ["pt", "en", "es"];
        $applicationLocales = ["pt-br", "en-US"];
        $defaultLocale      = "pt-br";
        $forceLocale        = null;

        $expected = "pt-br";
        $result = $nMock->negotiateLocale(
            $requestLocales, $requestLanguages, $applicationLocales, $defaultLocale, $forceLocale
        );

        $this->assertSame($expected, $result);



        // Força um locale ainda que ele não esteja definido entre aqueles
        // que a aplicação é capaz de prover.
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $requestLocales     = ["pt-BR", "en-us", "es-es"];
        $requestLanguages   = ["pt", "en", "es"];
        $applicationLocales = ["pt-br", "en-US"];
        $defaultLocale      = "pt-br";
        $forceLocale        = "pt-pt";

        $expected = "pt-pt";
        $result = $nMock->negotiateLocale(
            $requestLocales, $requestLanguages, $applicationLocales, $defaultLocale, $forceLocale
        );

        $this->assertSame($expected, $result);



        // Prioriza a seleção dos locales buscando aquele que primeiro responda
        // às opções de linguagens.
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $requestLocales     = null;
        $requestLanguages   = ["ch", "en", "pt", "es"];
        $applicationLocales = ["pt-br", "en-US", "es-es"];
        $defaultLocale      = "pt-br";
        $forceLocale        = null;

        $expected = "en-us";
        $result = $nMock->negotiateLocale(
            $requestLocales, $requestLanguages, $applicationLocales, $defaultLocale, $forceLocale
        );

        $this->assertSame($expected, $result);

    }


    public function test_method_negotiate_mimetype()
    {

        // Força um mimetype inválido
        $nMock = prov_instanceOf_EnGarde_Config_Route([
            "acceptMimes" => ["txt", "html", "pdf", "xml"]
        ]);

        $requestMimes     = [
            [ "mime" => "html",     "mimetype" => "text/html" ],
            [ "mime" => "xhtml",    "mimetype" => "application/xhtml+xml" ],
            [ "mime" => "xml",      "mimetype" => "application/xml" ],
            [ "mime" => "* /*",      "mimetype" => "* /*" ]
        ];
        $forceMime = "jpge";

        $expected = [
            "valid"     => false,
            "mime"      => null,
            "mimetype"  => null
        ];
        $result = $nMock->negotiateMimeType($requestMimes, $forceMime);
        $this->assertSame($expected, $result);



        // Força um mimetype válido
        $nMock = prov_instanceOf_EnGarde_Config_Route([
            "acceptMimes" => ["txt", "html", "pdf", "xml"]
        ]);

        $requestMimes     = [
            [ "mime" => "html",     "mimetype" => "text/html" ],
            [ "mime" => "xhtml",    "mimetype" => "application/xhtml+xml" ],
            [ "mime" => "xml",      "mimetype" => "application/xml" ],
            [ "mime" => "* /*",      "mimetype" => "* /*" ]
        ];
        $forceMime = "xml";

        $expected = [
            "valid"     => true,
            "mime"      => "xml",
            "mimetype"  => "application/xml"
        ];
        $result = $nMock->negotiateMimeType($requestMimes, $forceMime);
        $this->assertSame($expected, $result);



        // Seleciona o primeiro compatível com a definição do UA
        $nMock = prov_instanceOf_EnGarde_Config_Route([
            "acceptMimes" => ["txt", "html", "pdf", "xml"]
        ]);

        $requestMimes     = [
            [ "mime" => "xml",      "mimetype" => "application/xml" ],
            [ "mime" => "html",     "mimetype" => "text/html" ],
            [ "mime" => "xhtml",    "mimetype" => "application/xhtml+xml" ],
            [ "mime" => "* /*",      "mimetype" => "* /*" ]
        ];
        $forceMime = null;

        $expected = [
            "valid"     => true,
            "mime"      => "xml",
            "mimetype"  => "application/xml"
        ];
        $result = $nMock->negotiateMimeType($requestMimes, $forceMime);
        $this->assertSame($expected, $result);



        // Seleciona o primeiro que a rota está apto a responder
        $nMock = prov_instanceOf_EnGarde_Config_Route([
            "acceptMimes" => ["txt", "html", "pdf", "xml"]
        ]);

        $requestMimes     = [
            [ "mime" => "* /*",      "mimetype" => "* /*" ]
        ];
        $forceMime = null;

        $expected = [
            "valid"     => true,
            "mime"      => "txt",
            "mimetype"  => "text/plain"
        ];
        $result = $nMock->negotiateMimeType($requestMimes, $forceMime);
        $this->assertSame($expected, $result);



        // Verifica forçar usar XHTML
        $nMock = prov_instanceOf_EnGarde_Config_Route([
            "acceptMimes"   => ["txt", "html", "pdf", "xml"],
            "isUseXHTML"    => true
        ]);

        $requestMimes     = [
            [ "mime" => "html",     "mimetype" => "text/html" ],
            [ "mime" => "xml",      "mimetype" => "application/xml" ],
            [ "mime" => "* /*",      "mimetype" => "* /*" ]
        ];
        $forceMime = null;

        $expected = [
            "valid"     => true,
            "mime"      => "xhtml",
            "mimetype"  => "application/xhtml+xml"
        ];
        $result = $nMock->negotiateMimeType($requestMimes, $forceMime);
        $this->assertSame($expected, $result);

    }
    public function test_method_getset_responsemime()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame("", $nMock->getResponseMime());

        $nMock->setResponseMime("txt");
        $this->assertSame("txt", $nMock->getResponseMime());
    }


    public function test_method_getset_responsemimetype()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame("", $nMock->getResponseMimeType());

        $nMock->setResponseMimeType("text/plain");
        $this->assertSame("text/plain", $nMock->getResponseMimeType());
    }


    public function test_method_getset_responselocale()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame("", $nMock->getResponseLocale());

        $nMock->setResponseLocale("pt-br");
        $this->assertSame("pt-br", $nMock->getResponseLocale());
    }

    */





    public function test_method_getsetadd_responseheaders()
    {
        global $defaultRoute;
        $nMock = prov_instanceOf_EnGarde_Config_Route($defaultRoute);
        $this->assertSame([], $nMock->getResponseHeaders());

        $nMock->setResponseHeaders(["META_01" => "value_01", "meta_02" => "value_02", "meta_01" => "value_nha"]);
        $this->assertSame(["META_01" => "value_01", "meta_02" => "value_02"], $nMock->getResponseHeaders());

        $nMock->addResponseHeaders(["META_02" => "value_nha", "meta_03" => "value_03"]);
        $this->assertSame(["META_01" => "value_01", "meta_02" => "value_02", "meta_03" => "value_03"], $nMock->getResponseHeaders());

        $nMock->setResponseHeaders(["meta_03" => "value_03"]);
        $this->assertSame(["meta_03" => "value_03"], $nMock->getResponseHeaders());
    }


    public function test_method_getsetadd_stylesheets()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["styleSheets"] = [];
        $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        $this->assertSame([], $nMock->getStyleSheets());

        $nMock->setStyleSheets(["style_01", "style_02"]);
        $this->assertSame(["style_01", "style_02"], $nMock->getStyleSheets());

        $nMock->addStyleSheets(["style_03"]);
        $this->assertSame(["style_01", "style_02", "style_03"], $nMock->getStyleSheets());

        $nMock->setStyleSheets(["style_03"]);
        $this->assertSame(["style_03"], $nMock->getStyleSheets());
    }


    public function test_method_getsetadd_javascripts()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["javaScripts"] = [];
        $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        $this->assertSame([], $nMock->getJavaScripts());

        $nMock->setJavaScripts(["script_01", "script_02"]);
        $this->assertSame(["script_01", "script_02"], $nMock->getJavaScripts());

        $nMock->addJavaScripts(["script_03"]);
        $this->assertSame(["script_01", "script_02", "script_03"], $nMock->getJavaScripts());

        $nMock->setJavaScripts(["script_03"]);
        $this->assertSame(["script_03"], $nMock->getJavaScripts());
    }


    public function test_method_getsetadd_metadata()
    {
        global $defaultRoute;
        $testRoute = array_merge([], $defaultRoute);
        $testRoute["metaData"] = [];
        $nMock = prov_instanceOf_EnGarde_Config_Route($testRoute);
        $this->assertSame([], $nMock->getMetaData());

        $nMock->setMetaData(["META_01" => "value_01", "meta_02" => "value_02", "meta_01" => "value_nha"]);
        $this->assertSame(["META_01" => "value_01", "meta_02" => "value_02"], $nMock->getMetaData());

        $nMock->addMetaData(["META_02" => "value_nha", "meta_03" => "value_03"]);
        $this->assertSame(["META_01" => "value_01", "meta_02" => "value_02", "meta_03" => "value_03"], $nMock->getMetaData());

        $nMock->setMetaData(["meta_03" => "value_03"]);
        $this->assertSame(["meta_03" => "value_03"], $nMock->getMetaData());
    }
}
