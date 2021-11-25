<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Application as Application;

require_once __DIR__ . "/../../phpunit.php";







class ConfigApplicationTest extends TestCase
{





    public function test_constructor_ok()
    {
        global $defaultApplication;
        $nMock = new Application(
            $defaultApplication["appName"],
            $defaultApplication["appRootPath"],
            $defaultApplication["pathToAppRoutes"],
            $defaultApplication["pathToControllers"],
            $defaultApplication["pathToViews"],
            $defaultApplication["pathToViewsResources"],
            $defaultApplication["pathToLocales"],
            $defaultApplication["pathToCacheFiles"],
            $defaultApplication["pathToLocalData"],
            $defaultApplication["startRoute"],
            $defaultApplication["controllersNamespace"],
            $defaultApplication["locales"],
            $defaultApplication["defaultLocale"],
            $defaultApplication["isUseLabels"],
            $defaultApplication["defaultRouteConfig"],
            $defaultApplication["checkRouteOrder"],
            $defaultApplication["pathToErrorView"],
            $defaultApplication["pathToHttpMessageView"],
            $defaultApplication["httpSubSystemNamespaces"]
        );
        $this->assertTrue(is_a($nMock, Application::class));
    }


    public function test_method_getset_name_fails()
    {
        global $defaultApplication;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["appName"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"appName\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_name()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame("site", $nMock->getAppName());
    }


    public function test_method_getset_app_root_path_fails()
    {
        global $defaultApplication;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["appRootPath"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"appRootPath\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testApplication["appRootPath"] = "/nonexist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"appRootPath\". Directory does not exists. Given: [ /nonexist ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_app_root_path()
    {
        global $defaultApplication;
        global $dirResources;
        $path = $dirResources . DS . "apps" . DS . "site";
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame($path, $nMock->getAppRootPath());
    }





    public function test_method_getset_app_path_to_app_routes_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToAppRoutes"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"pathToAppRoutes\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testApplication["pathToAppRoutes"] = DS . "dir" . DS . "nonexist.php";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "dir";
            $this->assertSame(
                "Invalid value defined for \"pathToAppRoutes\". Directory does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_app_path_to_app_routes()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "AppRoutes.php", $nMock->getPathToAppRoutes());
    }


    public function test_method_getset_path_to_controllers_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToControllers"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"pathToControllers\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testApplication["pathToControllers"] = DS . "nonexist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "nonexist";
            $this->assertSame(
                "Invalid value defined for \"pathToControllers\". Directory does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_controllers()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "controllers", $nMock->getPathToControllers());
    }


    public function test_method_getset_path_to_views_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToViews"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"pathToViews\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testApplication["pathToViews"] = DS . "nonexist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "nonexist";
            $this->assertSame(
                "Invalid value defined for \"pathToViews\". Directory does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_views()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "views", $nMock->getPathToViews());
    }


    public function test_method_getset_path_to_views_resources_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToViewsResources"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"pathToViewsResources\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testApplication["pathToViewsResources"] = DS . "nonexist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "nonexist";
            $this->assertSame(
                "Invalid value defined for \"pathToViewsResources\". Directory does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_views_resources()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "resources", $nMock->getPathToViewsResources());
    }


    public function test_method_getset_path_to_locales_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToLocales"] = DS . "nonexist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "nonexist";
            $this->assertSame(
                "Invalid value defined for \"pathToLocales\". Directory does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_locales()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "locales", $nMock->getPathToLocales());


        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToLocales"] = "";
        $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        $this->assertSame("", $nMock->getPathToLocales());
    }


    public function test_method_getset_path_to_cache_files_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToCacheFiles"] = DS . "nonexist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "nonexist";
            $this->assertSame(
                "Invalid value defined for \"pathToCacheFiles\". Directory does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_cache_files()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "cache", $nMock->getPathToCacheFiles());


        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToCacheFiles"] = "";
        $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        $this->assertSame("", $nMock->getPathToCacheFiles());
    }


    public function test_method_getset_path_to_local_data_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToLocalData"] = DS . "nonexist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "nonexist";
            $this->assertSame(
                "Invalid value defined for \"pathToLocalData\". Directory does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_local_data()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "localData", $nMock->getPathToLocalData());


        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToLocalData"] = "";
        $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        $this->assertSame("", $nMock->getPathToLocalData());
    }


    public function test_method_getset_start_route()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame("/home", $nMock->getStartRoute());
    }


    public function test_method_getset_controller_namespace()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame("\\site\\controllers", $nMock->getControllersNamespace());
    }


    public function test_method_getset_locales_fails()
    {
        global $defaultApplication;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["locales"] = [];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"locales\". Expected a non-empty array.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testApplication["locales"] = [""];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"locales['0']\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testApplication["locales"] = ["ptBr"];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"locales['0']\". Given: [ ptBr ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_locales()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(["pt-br", "en-us"], $nMock->getLocales());
    }


    public function test_method_getset_default_locale_fails()
    {
        global $defaultApplication;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["defaultLocale"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"locale\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        $testApplication["defaultLocale"] = "pt-PT";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"locale\". Expected [ pt-br, en-us ]. Given: [ pt-PT ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_default_locale()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame("pt-br", $nMock->getDefaultLocale());
    }


    public function test_method_getset_is_use_labels()
    {
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(true, $nMock->getIsUseLabels());
    }


    public function test_method_getset_default_route_config()
    {
        global $defaultApplication;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["defaultRouteConfig"] = [];


        $expected = array_merge(
            [
                "application"       => "site",
                "namespace"         => "\\site\\controllers",
                "controller"        => "",
                "action"            => "",
                "allowedMethods"    => [],
                "allowedMimeTypes"  => [],
                "method"            => "",
                "isUseXHTML"        => false,
                "routes"            => [],
                "runMethodName"     => "",
                "customProperties"  => [],
                "isAutoLog"         => false,
                "description"       => "",
                "devDescription"    => "",
                "relationedRoutes"  => [],
                "middlewares"       => [],
                "isSecure"          => false,
                "isUseCache"        => false,
                "cacheTimeout"      => 0,
                "responseHeaders"   => [],
                "masterPage"        => "",
                "view"              => "",
                "styleSheets"       => [],
                "javaScripts"       => [],
                "metaData"          => [],
                "localeDirectory"   => ""
            ],
            $testApplication["defaultRouteConfig"]
        );


        $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        $this->assertSame($expected, $nMock->getDefaultRouteConfig());


        $testApplication["defaultRouteConfig"] = [
            "allowedMimeTypes"  => ["html", "xhtml", "txt"],
            "isUseXHTML"        => true,
            "middlewares"       => ["Mid_01", "Mid_02"],
            "description"       => "Default Route Description",
            "isSecure"          => true,
            "isUseCache"        => true,
            "cacheTimeout"      => 100,
            "masterPage"        => "null",
            "styleSheets"       => [],
            "javaScripts"       => [],
            "metaData"          => []
        ];

        $expected = array_merge(
        [
            "application"       => "site",
            "namespace"         => "\\site\\controllers",
            "controller"        => "",
            "action"            => "",
            "allowedMethods"    => [],
            "allowedMimeTypes"  => [],
            "method"            => "",
            "isUseXHTML"        => false,
            "routes"            => [],
            "runMethodName"     => "",
            "customProperties"  => [],
            "isAutoLog"         => false,
            "description"       => "",
            "devDescription"    => "",
            "relationedRoutes"  => [],
            "middlewares"       => [],
            "isSecure"          => false,
            "isUseCache"        => false,
            "cacheTimeout"      => 0,
            "responseHeaders"   => [],
            "masterPage"        => "",
            "view"              => "",
            "styleSheets"       => [],
            "javaScripts"       => [],
            "metaData"          => [],
            "localeDirectory"   => ""
        ],
        $testApplication["defaultRouteConfig"]);

        $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        $this->assertSame($expected, $nMock->getDefaultRouteConfig());
    }


    public function test_method_getset_check_route_order()
    {
        global $defaultApplication;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["checkRouteOrder"] = [];
        $expected = [];


        $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        $this->assertSame($expected, $nMock->getCheckRouteOrder());


        $testApplication["checkRouteOrder"] = ["native", "catch-all"];
        $expected = ["native", "catch-all"];

        $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        $this->assertSame($expected, $nMock->getCheckRouteOrder());
    }


    public function test_method_getset_path_to_error_view_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToErrorView"] = DS . "nonexist.php";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "nonexist.php";
            $this->assertSame(
                "Invalid value defined for \"pathToErrorView\". File does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_error_view()
    {
        global $dirResources;
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "errorView.phtml", $nMock->getPathToErrorView());

        $path = $dirResources . DS . "apps" . DS . "site" . DS . "errorView.phtml";
        $this->assertSame($path, $nMock->getPathToErrorView(true));
    }


    public function test_method_getset_path_to_http_message_view_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["pathToHttpMessageView"] = DS . "nonexist.php";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $path = $dirResources . DS . "apps" . DS . "site" . DS . "nonexist.php";
            $this->assertSame(
                "Invalid value defined for \"pathToHttpMessageView\". File does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_http_message_view()
    {
        global $dirResources;
        global $defaultApplication;
        $nMock = prov_instanceOf_EnGarde_Config_Application($defaultApplication);
        $this->assertSame(DS . "httpMessage.phtml", $nMock->getPathToHttpMessageView());

        $path = $dirResources . DS . "apps" . DS . "site" . DS . "httpMessage.phtml";
        $this->assertSame($path, $nMock->getPathToHttpMessageView(true));
    }





    public function test_method_getset_http_subsystem_namespaces_fails()
    {
        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["httpSubSystemNamespaces"] = [
            "invalid" => ""
        ];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid key defined for \"httpSubSystemNamespaces\". Expected keys [ HEAD, OPTIONS, TRACE, DEV, CONNECT ]. Given: [ invalid ].",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");



        global $defaultApplication;
        global $dirResources;
        $testApplication = array_merge([], $defaultApplication);
        $testApplication["httpSubSystemNamespaces"] = [
            "HEAD" => "\\namespace\\to\\class",
            "DEV" => ""
        ];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Application($testApplication);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"httpSubSystemNamespaces['DEV']\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }
}
