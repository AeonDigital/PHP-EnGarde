<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Route as Route;

require_once __DIR__ . "/../../phpunit.php";







class ConfigRouteTest extends TestCase
{





    public function test_constructor_ok()
    {
        $nMock = new Route();
        $this->assertTrue(is_a($nMock, Route::class));
    }





    public function test_method_set_application_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setApplication("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid Application. Must be a not empty string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_application()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setApplication("Application");
        $this->assertSame("Application", $nMock->getApplication());

        $nMock->setApplication("NotOverwrite");
        $this->assertSame("Application", $nMock->getApplication());
    }


    public function test_method_set_namespace_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setNamespace("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid Namespace. Must be a not empty string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_namespace()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setNamespace("Application");
        $this->assertSame("Application", $nMock->getNamespace());

        $nMock->setNamespace("NotOverwrite");
        $this->assertSame("Application", $nMock->getNamespace());
    }


    public function test_method_set_controller_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setController("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid Controller. Must be a not empty string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_controller()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setController("Controller");
        $this->assertSame("Controller", $nMock->getController());

        $nMock->setController("NotOverwrite");
        $this->assertSame("Controller", $nMock->getController());
    }


    public function test_method_set_action_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setAction("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid Action. Must be a not empty string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_action()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setAction("Action");
        $this->assertSame("Action", $nMock->getAction());

        $nMock->setAction("NotOverwrite");
        $this->assertSame("Action", $nMock->getAction());
    }


    public function test_method_set_method_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setMethod("");
        } catch (\Exception $ex) {
            $fail = true;
            $validMethod = ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "CONNECT", "OPTIONS", "TRACE"];
            $this->assertSame("Invalid Method. Expected one of : \"" . implode("\", \"", $validMethod) . "\".", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_method()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setMethod("post");
        $this->assertSame("POST", $nMock->getMethod());

        $nMock->setMethod("GET");
        $this->assertSame("POST", $nMock->getMethod());
    }


    public function test_method_set_allowedmethods_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setAllowedMethods(["GETS"]);
        } catch (\Exception $ex) {
            $fail = true;
            $validMethod = ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "CONNECT", "OPTIONS", "TRACE"];
            $this->assertSame("Invalid Method. Expected one of : \"" . implode("\", \"", $validMethod) . "\".", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_allowedmethods()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setAllowedMethods(["post", "get"]);
        $this->assertSame(["POST", "GET"], $nMock->getAllowedMethods());
    }


    public function test_method_set_routes_empty_array_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setRoutes([]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid Routes. The array must have at last one value.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_routes_invalid_route_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setRoutes([""]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid Route definition. Empty strings are not valid.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_routes()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $expected = ["/route-one", "/another-route"];

        $nMock->setRoutes(["/route-one", "another-route"]);
        $this->assertSame($expected, $nMock->getRoutes());

        $nMock->setRoutes(["not-overwrite-route"]);
        $this->assertSame($expected, $nMock->getRoutes());
    }


    public function test_method_set_accept_mimes_empty_array_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setAcceptMimes([]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid definition of AcceptMimes. The array must have at last one value.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_accept_mimes_invalid_value_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setAcceptMimes([null]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Unsuported mime [ \"\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_accept_mimes()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $expected = ["txt" => "text/plain", "html" => "text/html", "xhtml" => "application/xhtml+xml"];

        $nMock->setAcceptMimes(["txt", "html"]);
        $this->assertSame($expected, $nMock->getAcceptMimes());

        $nMock->setAcceptMimes(["json"]);
        $this->assertSame($expected, $nMock->getAcceptMimes());
    }


    public function test_method_getset_is_use_xhtml()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame(false, $nMock->getIsUseXHTML());

        $nMock->setIsUseXHTML(true);
        $this->assertSame(true, $nMock->getIsUseXHTML());

        $nMock->setIsUseXHTML(false);
        $this->assertSame(false, $nMock->getIsUseXHTML());
    }





    public function test_method_all_middlewares_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setMiddlewares([""]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid Middleware definition. Empty strings are not valid.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }

    public function test_method_all_middlewares()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame([], $nMock->getMiddlewares());

        $nMock->setMiddlewares(["MiddleWare_one", "MiddleWare_two"]);
        $this->assertSame(["MiddleWare_one", "MiddleWare_two"], $nMock->getMiddlewares());

        $nMock->addMiddlewares(["MiddleWare_tree"]);
        $this->assertSame(["MiddleWare_one", "MiddleWare_two", "MiddleWare_tree"], $nMock->getMiddlewares());

        $nMock->setMiddlewares(["MiddleWare_tree"]);
        $this->assertSame(["MiddleWare_tree"], $nMock->getMiddlewares());
    }





    public function test_method_getset_relationed_routes()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $expected = ["/relationed-one", "/another-relationed"];

        $nMock->setRelationedRoutes(["relationed-one", "another-relationed", null, "", 222]);
        $this->assertSame($expected, $nMock->getRelationedRoutes());

        $nMock->setRelationedRoutes([]);
        $this->assertSame([], $nMock->getRelationedRoutes());
    }


    public function test_method_getset_description()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $nMock->setDescription("Only a description.");
        $this->assertSame("Only a description.", $nMock->getDescription());

        $nMock->setDescription("");
        $this->assertSame("", $nMock->getDescription());
    }


    public function test_method_getset_dev_description()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $nMock->setDevDescription("Only a dev description.");
        $this->assertSame("Only a dev description.", $nMock->getDevDescription());

        $nMock->setDevDescription("");
        $this->assertSame("", $nMock->getDevDescription());
    }


    public function test_method_getset_is_secure()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame(false, $nMock->getIsSecure());

        $nMock->setIsSecure(true);
        $this->assertSame(true, $nMock->getIsSecure());

        $nMock->setIsSecure(false);
        $this->assertSame(false, $nMock->getIsSecure());
    }


    public function test_method_getset_is_use_cache()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame(false, $nMock->getIsUseCache());

        $nMock->setIsUseCache(true);
        $this->assertSame(false, $nMock->getIsUseCache());

        $nMock->setCacheTimeout(10);
        $this->assertSame(true, $nMock->getIsUseCache());

        $nMock->setCacheTimeout(0);
        $this->assertSame(false, $nMock->getIsUseCache());
    }


    public function test_method_getset_cache_timeout()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame(0, $nMock->getCacheTimeout());

        $nMock->setCacheTimeout(-50);
        $this->assertSame(0, $nMock->getCacheTimeout());

        $nMock->setCacheTimeout(10);
        $this->assertSame(10, $nMock->getCacheTimeout());

        $nMock->setCacheTimeout(100);
        $this->assertSame(100, $nMock->getCacheTimeout());
    }


    public function test_method_all_responseheaders()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame([], $nMock->getResponseHeaders());

        $nMock->setResponseHeaders(["META_01" => "value_01", "meta_02" => "value_02", "meta_01" => "value_nha"]);
        $this->assertSame(["META_01" => "value_01", "meta_02" => "value_02"], $nMock->getResponseHeaders());

        $nMock->addResponseHeaders(["META_02" => "value_nha", "meta_03" => "value_03"]);
        $this->assertSame(["META_01" => "value_01", "meta_02" => "value_02", "meta_03" => "value_03"], $nMock->getResponseHeaders());

        $nMock->setResponseHeaders(["meta_03" => "value_03"]);
        $this->assertSame(["meta_03" => "value_03"], $nMock->getResponseHeaders());
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


    public function test_method_getset_responseisprettyprint()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame(false, $nMock->getResponseIsPrettyPrint());

        $nMock->setResponseIsPrettyPrint(true);
        $this->assertSame(true, $nMock->getResponseIsPrettyPrint());
    }



    public function test_method_getset_responseisdownload()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame(false, $nMock->getResponseIsDownload());

        $nMock->setResponseIsDownload(true);
        $this->assertSame(true, $nMock->getResponseIsDownload());

        $nMock->setResponseIsDownload(false);
        $this->assertSame(false, $nMock->getResponseIsDownload());
    }


    public function test_method_getset_responsedownloadfilename()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame("", $nMock->getResponseDownloadFileName());

        $nMock->setResponseDownloadFileName("explicit-filename");
        $this->assertSame("explicit-filename", $nMock->getResponseDownloadFileName());

        $nMock->setResponseDownloadFileName("");
        $this->assertSame("", $nMock->getResponseDownloadFileName());
    }


    public function test_method_getset_masterpage()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $nMock->setMasterPage("/route/to/masterpage.phtml");
        $this->assertSame("/route/to/masterpage.phtml", $nMock->getMasterPage());

        $nMock->setMasterPage("");
        $this->assertSame("", $nMock->getMasterPage());
    }


    public function test_method_getset_view()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $nMock->setView("/route/to/view.phtml");
        $this->assertSame("/route/to/view.phtml", $nMock->getView());

        $nMock->setView("");
        $this->assertSame("", $nMock->getView());
    }


    public function test_method_getset_form()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $nMock->setForm("/route/to/form.php");
        $this->assertSame("/route/to/form.php", $nMock->getForm());

        $nMock->setForm("");
        $this->assertSame("", $nMock->getForm());
    }


    public function test_method_all_stylesheets()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame([], $nMock->getStyleSheets());

        $nMock->setStyleSheets(["style_01", "style_02"]);
        $this->assertSame(["style_01", "style_02"], $nMock->getStyleSheets());

        $nMock->addStyleSheets(["style_03"]);
        $this->assertSame(["style_01", "style_02", "style_03"], $nMock->getStyleSheets());

        $nMock->setStyleSheets(["style_03"]);
        $this->assertSame(["style_03"], $nMock->getStyleSheets());
    }


    public function test_method_all_javascripts()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame([], $nMock->getJavaScripts());

        $nMock->setJavaScripts(["script_01", "script_02"]);
        $this->assertSame(["script_01", "script_02"], $nMock->getJavaScripts());

        $nMock->addJavaScripts(["script_03"]);
        $this->assertSame(["script_01", "script_02", "script_03"], $nMock->getJavaScripts());

        $nMock->setJavaScripts(["script_03"]);
        $this->assertSame(["script_03"], $nMock->getJavaScripts());
    }


    public function test_method_getset_locale_dictionary()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $nMock->setLocaleDictionary("/route/to/pt-br.php");
        $this->assertSame("/route/to/pt-br.php", $nMock->getLocaleDictionary());

        $nMock->setLocaleDictionary("");
        $this->assertSame("", $nMock->getLocaleDictionary());
    }


    public function test_method_all_metadata()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame([], $nMock->getMetaData());

        $nMock->setMetaData(["META_01" => "value_01", "meta_02" => "value_02", "meta_01" => "value_nha"]);
        $this->assertSame(["META_01" => "value_01", "meta_02" => "value_02"], $nMock->getMetaData());

        $nMock->addMetaData(["META_02" => "value_nha", "meta_03" => "value_03"]);
        $this->assertSame(["META_01" => "value_01", "meta_02" => "value_02", "meta_03" => "value_03"], $nMock->getMetaData());

        $nMock->setMetaData(["meta_03" => "value_03"]);
        $this->assertSame(["meta_03" => "value_03"], $nMock->getMetaData());
    }


    public function test_method_getset_runmethodname()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $this->assertSame("run", $nMock->getRunMethodName());

        $nMock->setRunMethodName("anotherName");
        $this->assertSame("anotherName", $nMock->getRunMethodName());
    }



    public function test_method_getset_custom_properties()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $cprop = ["prop1" => "val1", "prop2" => "val2"];

        $nMock->setCustomProperties($cprop);
        $this->assertSame($cprop, $nMock->getCustomProperties());

        $nMock->setCustomProperties([]);
        $this->assertSame([], $nMock->getCustomProperties());
    }


    public function test_method_set_values_with_string_fail_01()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setValues(null);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid configuration value. Expected a not empty string or array.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_values_with_string_fail_02()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setValues("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid configuration value. Expected a not empty string or array.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_values_with_string_fail_03()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setValues("/only/route/error");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Route configuration fail. Check documentation [ \"/only/route/error\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_values_with_string_fail_04()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();

        $fail = false;
        try {
            $nMock->setValues("GET /router/cache/error actionName freeRoute cache-err");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Route configuration fail. Expected integer cache timeout. Check documentation.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_values_with_array_fail_01()
    {
        $fail = false;
        try {
            $set = [
                "invalidName" => "Application"
            ];
            $nMock = prov_instanceOf_EnGarde_Config_Route();
            $nMock->setValues($set);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid propertie. [ \"invalidName\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");

    }


    public function test_method_set_values_with_string()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setValues("/router/cache/another actionAnother");

        $this->assertSame("GET", $nMock->getMethod());
        $this->assertSame(["/router/cache/another"], $nMock->getRoutes());
        $this->assertSame("actionAnother", $nMock->getAction());



        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setValues("GET /router/cache/sucess actionName");

        $this->assertSame("GET", $nMock->getMethod());
        $this->assertSame(["/router/cache/sucess"], $nMock->getRoutes());
        $this->assertSame("actionName", $nMock->getAction());
        $this->assertSame(false, $nMock->getIsSecure());
        $this->assertSame(false, $nMock->getIsUseCache());
        $this->assertSame(0, $nMock->getCacheTimeout());



        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setValues("GET /router/cache/sucess actionName publicRoute");

        $this->assertSame("GET", $nMock->getMethod());
        $this->assertSame(["/router/cache/sucess"], $nMock->getRoutes());
        $this->assertSame("actionName", $nMock->getAction());
        $this->assertSame(false, $nMock->getIsSecure());
        $this->assertSame(false, $nMock->getIsUseCache());
        $this->assertSame(0, $nMock->getCacheTimeout());



        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setValues("GET /router/cache/sucess actionName privateRoute");

        $this->assertSame("GET", $nMock->getMethod());
        $this->assertSame(["/router/cache/sucess"], $nMock->getRoutes());
        $this->assertSame("actionName", $nMock->getAction());
        $this->assertSame(true, $nMock->getIsSecure());
        $this->assertSame(false, $nMock->getIsUseCache());
        $this->assertSame(0, $nMock->getCacheTimeout());



        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setValues("GET /router/cache/sucess actionName privateRoute no-cache");

        $this->assertSame("GET", $nMock->getMethod());
        $this->assertSame(["/router/cache/sucess"], $nMock->getRoutes());
        $this->assertSame("actionName", $nMock->getAction());
        $this->assertSame(true, $nMock->getIsSecure());
        $this->assertSame(false, $nMock->getIsUseCache());
        $this->assertSame(0, $nMock->getCacheTimeout());



        $nMock = prov_instanceOf_EnGarde_Config_Route();
        $nMock->setValues("GET /router/cache/sucess actionName privateRoute cache-2000");

        $this->assertSame("GET", $nMock->getMethod());
        $this->assertSame(["/router/cache/sucess"], $nMock->getRoutes());
        $this->assertSame("actionName", $nMock->getAction());
        $this->assertSame(true, $nMock->getIsSecure());
        $this->assertSame(false, $nMock->getIsUseCache());
        $this->assertSame(2000, $nMock->getCacheTimeout());
    }


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
            [ "mime" => "*/*",      "mimetype" => "*/*" ]
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
            [ "mime" => "*/*",      "mimetype" => "*/*" ]
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
            [ "mime" => "*/*",      "mimetype" => "*/*" ]
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
            [ "mime" => "*/*",      "mimetype" => "*/*" ]
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
            [ "mime" => "*/*",      "mimetype" => "*/*" ]
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



    public function test_method_to_array()
    {
        $ds = DIRECTORY_SEPARATOR;
        $pathToFile = dirname(dirname(__FILE__)) . $ds . "apps" . $ds . "site" . $ds . "Form.php";

        $set = [
            "application" => "Application",
            "namespace" => "Use\\Namespace",
            "controller" => "ControllerName",
            "action" => "ActionName",
            "method" => "get",

            "allowedMethods" => ["get"],
            "routes" => ["/", "/another/route"],
            "acceptMimes" => ["txt", "html", "xhtml"],
            "isUseXHTML" => true,
            "middlewares" => ["MiddlewareName_One", "MiddlewareName_Two", "MiddlewareName_Tree"],

            "relationedRoutes" => ["/services/routes"],
            "description" => "Text about this route.",
            "devDescription" => "Text to developers about this route.",
            "isSecure" => false,
            "isUseCache" => true,

            "cacheTimeout" => 0,
            "responseHeaders" => [],
            "responseMime" => "html",
            "responseMimeType" => "text/html",
            "responseLocale" => "pt-br",

            "responseIsPrettyPrint" => false,
            "responseIsDownload" => false,
            "responseDownloadFileName" => "autocreateDownloadFileName",
            "masterPage" => "masterPage.phtml",
            "view" => "view.phtml",

            "form" => "form.php",
            "styleSheets" => ["style_01", "style_02"],
            "javaScripts" => ["script_01", "script_02"],
            "localeDictionary" => "path/to/pt-br.php",
            "metaData" => ["author" => "Aeon Digital"],

            "runMethodName" => "anotherRunMethod",
            "customProperties" => ["prop1" => "val1", "prop2" => "val2"]
        ];


        $nMock = prov_instanceOf_EnGarde_Config_Route($set);


        $set["method"] = "GET";
        $set["allowedMethods"] = ["GET"];
        $set["acceptMimes"] = [
            "txt" => "text/plain",
            "html" => "text/html",
            "xhtml" => "application/xhtml+xml"
        ];
        $set["isUseCache"] = false;

        $this->assertEquals($set, $nMock->toArray());
    }


    public function test_method_get_response_action_attributes()
    {
        $ds = DIRECTORY_SEPARATOR;
        $pathToFile = dirname(dirname(__FILE__)) . $ds . "apps" . $ds . "site" . $ds . "Form.php";

        $set = [
            "application" => "Application",
            "namespace" => "Use\\Namespace",
            "controller" => "ControllerName",
            "action" => "ActionName",
            "method" => "get",

            "allowedMethods" => ["get"],
            "routes" => ["/", "/another/route"],
            "acceptMimes" => ["txt", "html", "xhtml"],
            "isUseXHTML" => true,
            "middlewares" => ["MiddlewareName_One", "MiddlewareName_Two", "MiddlewareName_Tree"],

            "relationedRoutes" => ["/services/routes"],
            "description" => "Text about this route.",
            "devDescription" => "Text to developers about this route.",
            "isSecure" => false,
            "isUseCache" => true,

            "cacheTimeout" => 0,
            "responseHeaders" => [],
            "responseMime" => "html",
            "responseMimeType" => "text/html",
            "responseLocale" => "pt-br",

            "responseIsPrettyPrint" => false,
            "responseIsDownload" => false,
            "responseDownloadFileName" => "autocreateDownloadFileName",
            "masterPage" => "masterPage.phtml",
            "view" => "view.phtml",

            "form" => "form.php",
            "styleSheets" => ["style_01", "style_02"],
            "javaScripts" => ["script_01", "script_02"],
            "localeDictionary" => "path/to/pt-br.php",
            "metaData" => ["author" => "Aeon Digital"],

            "runMethodName" => "anotherRunMethod",
            "customProperties" => ["prop1" => "val1", "prop2" => "val2"]
        ];


        $nMock = prov_instanceOf_EnGarde_Config_Route($set);


        $expected = [
            "responseHeaders"           => ["header01" => "v1", "header02" => "v2"],
            "responseMime"              => "html",
            "responseMimeType"          => "text/html",
            "responseLocale"            => "pt-br",
            "responseIsPrettyPrint"     => false,
            "responseIsDownload"        => false,
            "responseDownloadFileName"  => "filename.php",
            "masterPage"                => "master.phtml",
            "view"                      => "view.phtml",
            "styleSheets"               => ["ss01.css", "ss02.css", "ss03.css"],
            "javaScripts"               => ["js01.css", "js02.css", "js03.css"],
            "localeDictionary"          => "/locale/pt-br.php",
            "metaData"                  => ["md01" => "v1", "md02" => "v2"]
        ];

        $nMock->setResponseHeaders($expected["responseHeaders"]);
        $nMock->setResponseMime($expected["responseMime"]);
        $nMock->setResponseMimeType($expected["responseMimeType"]);
        $nMock->setResponseLocale($expected["responseLocale"]);
        $nMock->setResponseIsPrettyPrint($expected["responseIsPrettyPrint"]);
        $nMock->setResponseIsDownload($expected["responseIsDownload"]);
        $nMock->setResponseDownloadFileName($expected["responseDownloadFileName"]);
        $nMock->setMasterPage($expected["masterPage"]);
        $nMock->setView($expected["view"]);
        $nMock->setStyleSheets($expected["styleSheets"]);
        $nMock->setJavaScripts($expected["javaScripts"]);
        $nMock->setLocaleDictionary($expected["localeDictionary"]);
        $nMock->setMetaData($expected["metaData"]);


        $this->assertEquals($expected, $nMock->getActionAttributes());
    }




    public function test_method_lock_properties()
    {
        $ds = DIRECTORY_SEPARATOR;
        $pathToFile = dirname(dirname(__FILE__)) . $ds . "apps" . $ds . "site" . $ds . "Form.php";

        $set = [
            "application" => "Application",
            "namespace" => "Use\\Namespace",
            "controller" => "ControllerName",
            "action" => "ActionName",
            "method" => "get",

            "allowedMethods" => ["get"],
            "routes" => ["/", "/another/route"],
            "acceptMimes" => ["txt", "html", "xhtml"],
            "isUseXHTML" => true,
            "middlewares" => ["MiddlewareName_One", "MiddlewareName_Two", "MiddlewareName_Tree"],

            "relationedRoutes" => ["/services/routes"],
            "description" => "Text about this route.",
            "devDescription" => "Text to developers about this route.",
            "isSecure" => false,
            "isUseCache" => true,

            "cacheTimeout" => 0,
            "responseMime" => "html",
            "responseMimeType" => "text/html",
            "responseLocale" => "pt-br",
            "responseIsPrettyPrint" => false,

            "responseIsDownload" => false,
            "responseDownloadFileName" => "autocreateDownloadFileName",
            "masterPage" => "masterPage.phtml",
            "view" => "view.phtml",
            "form" => "form.php",

            "styleSheets" => ["style_01", "style_02"],
            "javaScripts" => ["script_01", "script_02"],
            "localeDictionary" => "path/to/pt-br.php",
            "metaData" => ["author" => "Aeon Digital"],
            "responseHeaders" => [],

            "runMethodName" => "anotherRunMethod",
            "customProperties" => ["prop1" => "val1", "prop2" => "val2"]
        ];


        $nMock = prov_instanceOf_EnGarde_Config_Route($set);


        $set["method"] = "GET";
        $set["allowedMethods"] = ["GET"];
        $set["acceptMimes"] = [
            "txt" => "text/plain",
            "html" => "text/html",
            "xhtml" => "application/xhtml+xml"
        ];
        $set["isUseCache"] = false;

        $this->assertEquals($set, $nMock->toArray());

        $nMock->lockProperties();
        $nMock->setForm("anotherForm.php");
        $this->assertSame("form.php", $nMock->getForm());
    }
}
