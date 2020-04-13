<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Application as Application;

require_once __DIR__ . "/../../phpunit.php";







class ConfigApplicationTest extends TestCase
{





    public function test_constructor_ok()
    {
        $nMock = new Application();
        $this->assertTrue(is_a($nMock, Application::class));
    }


    public function test_method_getset_name()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet("ApplicationName");
        $this->assertSame("ApplicationName", $nMock->getName());
    }


    public function test_method_set_app_root_path_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $fail = false;
        try {
            $nMock->setAppRootPath("unexist");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to the root directory of the application does not exist [ \"unexist\\\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_app_root_path_empty_path_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $fail = false;
        try {
            $nMock->setAppRootPath("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to the root directory is invalid. Empty string received.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_app_root_path()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $appRootPath = $dirResources . $ds . "apps";
        $appRootSite = $appRootPath . $ds . "site" . $ds;
        $appRootBlog = $appRootPath . $ds . "blog" . $ds;


        $nMock->setAppRootPath($appRootSite);
        $this->assertSame($appRootSite, $nMock->getAppRootPath());


        $nMock->setAppRootPath($appRootBlog);
        $this->assertSame($appRootSite, $nMock->getAppRootPath());
    }


    public function test_method_set_path_to_app_routes_fails()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $targetPath = $dirResources. $ds ."apps" . $ds . "sites" . $ds . "AppRoutes.php";
        $dir = dirname($targetPath);

        $fail = false;
        try {
            $nMock->setPathToAppRoutes($targetPath);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to AppRoutes file does not exist [ \"" . $dir . "\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_app_routes()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $targetPath_one = $dirResources . $ds . "apps" . $ds . "site" . $ds . "AppRoutes.php";
        $targetPath_two = $dirResources . $ds . "apps" . $ds . "blog" . $ds . "AppRoutes.php";

        $nMock->setPathToAppRoutes($targetPath_one);
        $this->assertSame($targetPath_one, $nMock->getPathToAppRoutes());

        $nMock->setPathToAppRoutes($targetPath_two);
        $this->assertSame($targetPath_one, $nMock->getPathToAppRoutes());
    }


    public function test_method_set_path_to_controllers_fails()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath = $dirResources . $ds . "apps" . $ds . "sites" . $ds . "NonExist" . $ds;

        $fail = false;
        try {
            $nMock->setPathToControllers($targetPath);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to controllers does not exist [ \"" . $targetPath . "\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_controllers()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath_one = $dirResources . $ds . "apps" . $ds . "site" . $ds . "controllers" . $ds;
        $targetPath_two = $dirResources . $ds . "apps" . $ds . "site" . $ds . "AnotherControllers" . $ds;

        $nMock->setPathToControllers($targetPath_one);
        $this->assertSame($targetPath_one, $nMock->getPathToControllers());

        $nMock->setPathToControllers($targetPath_two);
        $this->assertSame($targetPath_one, $nMock->getPathToControllers());
    }


    public function test_method_set_path_to_views_fails()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath = $dirResources . $ds . "apps" . $ds . "sites" . $ds . "NonExist" . $ds;

        $fail = false;
        try {
            $nMock->setPathToViews($targetPath);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to views does not exist [ \"" . $targetPath . "\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_views()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath_one = $dirResources . $ds . "apps" . $ds . "site" . $ds . "views" . $ds;
        $targetPath_two = $dirResources . $ds . "apps" . $ds . "site" . $ds . "AnotherViews" . $ds;

        $nMock->setPathToViews($targetPath_one);
        $this->assertSame($targetPath_one, $nMock->getPathToViews());

        $nMock->setPathToViews($targetPath_two);
        $this->assertSame($targetPath_one, $nMock->getPathToViews());
    }


    public function test_method_set_path_to_views_resources_fails()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath = $dirResources . $ds . "apps" . $ds . "sites" . $ds . "NonExist" . $ds;

        $fail = false;
        try {
            $nMock->setPathToViewsResources($targetPath);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to views resources does not exist [ \"" . $targetPath . "\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_path_to_views_resources()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath_one = $dirResources . $ds . "apps" . $ds . "site" . $ds . "views" . $ds;
        $targetPath_two = $dirResources . $ds . "apps" . $ds . "site" . $ds . "AnotherViews" . $ds;

        $nMock->setPathToViewsResources($targetPath_one);
        $this->assertSame($targetPath_one, $nMock->getPathToViewsResources());

        $nMock->setPathToViewsResources($targetPath_two);
        $this->assertSame($targetPath_one, $nMock->getPathToViewsResources());
    }


    public function test_method_set_path_to_locales_fails()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath = $dirResources . $ds . "apps" . $ds . "sites" . $ds . "localess" . $ds;

        $fail = false;
        try {
            $nMock->setPathToLocales($targetPath);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to locales does not exist [ \"" . $targetPath . "\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_locales()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath_one = $dirResources . $ds . "apps" . $ds . "site" . $ds . "locales" . $ds;
        $targetPath_two = $dirResources . $ds . "apps" . $ds . "site" . $ds . "AnotherLocales" . $ds;

        $nMock->setPathToLocales($targetPath_one);
        $this->assertSame($targetPath_one, $nMock->getPathToLocales());

        $nMock->setPathToLocales($targetPath_two);
        $this->assertSame($targetPath_one, $nMock->getPathToLocales());
    }


    public function test_method_set_path_to_cache_files_fails()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath = $dirResources . $ds . "apps" . $ds . "sites" . $ds . "NonExist" . $ds;

        $fail = false;
        try {
            $nMock->setPathToCacheFiles($targetPath);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to cache files does not exist [ \"" . $targetPath . "\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_path_to_cache_files()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath_one = $dirResources . $ds . "apps" . $ds . "site" . $ds . "cache" . $ds;
        $targetPath_two = $dirResources . $ds . "apps" . $ds . "site" . $ds . "AnotherCaches" . $ds;

        $nMock->setPathToCacheFiles($targetPath_one);
        $this->assertSame($targetPath_one, $nMock->getPathToCacheFiles());

        $nMock->setPathToCacheFiles($targetPath_two);
        $this->assertSame($targetPath_one, $nMock->getPathToCacheFiles());
    }


    public function test_method_getset_start_route()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $nMock->setStartRoute("/home");
        $this->assertSame("/home", $nMock->getStartRoute());

        $nMock->setStartRoute("/homenew");
        $this->assertSame("/home", $nMock->getStartRoute());
    }


    public function test_method_getset_controller_namespace()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet("AppName");

        $nMock->setControllersNamespace("controllers");
        $this->assertSame("\\AppName\\controllers", $nMock->getControllersNamespace());
    }


    public function test_method_set_locales_empty_collection_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $fail = false;
        try {
            $nMock->setLocales([]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("It is not allowed to define an empty collection of locales.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_set_locales_invalid_locale_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $fail = false;
        try {
            $nMock->setLocales(["pt-br", "enus"]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The value \"enus\" is not a valid locale.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_locales()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $nMock->setLocales(["pt-br", "en-us"]);
        $this->assertSame(["pt-br", "en-us"], $nMock->getLocales());
    }


    public function test_method_set_default_locale_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();

        $fail = false;
        try {
            $nMock->setDefaultLocale("pt-pt");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The given locale is not defined in the application locale collection.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_default_locales()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $nMock->setLocales(["pt-br", "en-us"]);
        $nMock->setDefaultLocale("pt-br");
        $this->assertSame("pt-br", $nMock->getDefaultLocale());
    }


    public function test_method_getset_is_use_labels()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $this->assertSame(false, $nMock->getIsUseLabels());

        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $nMock->setIsUseLabels(true);
        $this->assertSame(true, $nMock->getIsUseLabels());
    }


    public function test_method_getset_default_route_config()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $this->assertSame([], $nMock->getDefaultRouteConfig());

        $startData = [
            "acceptMimes" => ["html", "xhtml", "txt"],
            "isUseXHTML" => true,
            "middlewares" => ["Mid_01", "Mid_02"],
            "description" => "Default Route Description",
            "isSecure" => true,
            "isUseCache" => true,
            "cacheTimeout" => 100,
            "masterPage" => "null",
            "styleSheets" => null,
            "javaScripts" => null,
            "metaData" => null
        ];

        $expected = [
            "acceptmimes" => ["html", "xhtml", "txt"],
            "isusexhtml" => true,
            "middlewares" => ["Mid_01", "Mid_02"],
            "description" => "Default Route Description",
            "issecure" => true,
            "isusecache" => true,
            "cachetimeout" => 100,
            "masterpage" => "null"
        ];

        $nMock->setDefaultRouteConfig($startData);
        $this->assertSame($expected, $nMock->getDefaultRouteConfig());
    }


    public function test_methods_getset_path_to_error_view()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $expected = "viewError.phtml";

        $nMock->setPathToErrorView($expected);
        $this->assertSame($expected, $nMock->getPathToErrorView());
        $this->assertSame($expected, $nMock->getFullPathToErrorView());

        $nMock->setPathToErrorView("anotherErrorView.phtml");
        $this->assertSame($expected, $nMock->getPathToErrorView());
    }







    public function test_method_auto_set_properties()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet();
        $targetPath = $dirResources . $ds . "apps";
        $nMock->autoSetProperties("site", $targetPath);

        $appRootPath = $targetPath . $ds . "site" . $ds;

        $this->assertSame("site", $nMock->getName());
        $this->assertSame("/", $nMock->getStartRoute());
        $this->assertSame($appRootPath, $nMock->getAppRootPath());
        $this->assertSame("\\site\\controllers", $nMock->getControllersNamespace());
        $this->assertSame($appRootPath . "AppRoutes.php", $nMock->getPathToAppRoutes());
        $this->assertSame($appRootPath . "controllers" . $ds, $nMock->getPathToControllers());
        $this->assertSame($appRootPath . "views" . $ds, $nMock->getPathToViews());
        $this->assertSame($appRootPath . "locales" . $ds, $nMock->getPathToLocales());
        $this->assertSame($appRootPath . "resources" . $ds, $nMock->getPathToViewsResources());
        $this->assertSame($appRootPath . "cache" . $ds, $nMock->getPathToCacheFiles());
    }


    public function test_method_auto_set_properties_on_constructor()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $targetPath = $dirResources . $ds . "apps";
        $nMock = prov_instanceOf_EnGarde_Config_Application_autoSet("site", $targetPath);

        $appRootPath = $targetPath . $ds . "site" . $ds;

        $this->assertSame("site", $nMock->getName());
        $this->assertSame("/", $nMock->getStartRoute());
        $this->assertSame($appRootPath, $nMock->getAppRootPath());
        $this->assertSame("\\site\\controllers", $nMock->getControllersNamespace());
        $this->assertSame($appRootPath . "AppRoutes.php", $nMock->getPathToAppRoutes());
        $this->assertSame($appRootPath . "controllers" . $ds, $nMock->getPathToControllers());
        $this->assertSame($appRootPath . "views" . $ds, $nMock->getPathToViews());
        $this->assertSame($appRootPath . "locales" . $ds, $nMock->getPathToLocales());
        $this->assertSame($appRootPath . "resources" . $ds, $nMock->getPathToViewsResources());
        $this->assertSame($appRootPath . "cache" . $ds, $nMock->getPathToCacheFiles());
    }
}
