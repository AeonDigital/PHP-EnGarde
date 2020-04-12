<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Engine as Engine;

require_once __DIR__ . "/../../phpunit.php";







class ConfigEngineTest extends TestCase
{





    public function test_constructor_ok()
    {
        $nMock = new Engine();
        $this->assertTrue(is_a($nMock, Engine::class));
    }


    public function test_methods_getset_version()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $this->assertSame("v0.5.0-beta", $nMock->getVersion());
    }


    public function test_methods_getset_environment_type()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = "production";

        $nMock->setEnvironmentType($expected);
        $this->assertSame($expected, $nMock->getEnvironmentType());

        $nMock->setEnvironmentType("development");
        $this->assertSame($expected, $nMock->getEnvironmentType());
    }


    public function test_methods_getset_debug_mode()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = true;

        $nMock->setIsDebugMode($expected);
        $this->assertSame($expected, $nMock->getIsDebugMode());

        $nMock->setIsDebugMode(false);
        $this->assertSame($expected, $nMock->getIsDebugMode());
    }


    public function test_methods_getset_update_routes()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = true;

        $nMock->setIsUpdateRoutes($expected);
        $this->assertSame($expected, $nMock->getIsUpdateRoutes());

        $nMock->setIsUpdateRoutes(false);
        $this->assertSame($expected, $nMock->getIsUpdateRoutes());
    }


    public function test_methods_set_root_path_empty_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);

        $fail = false;
        try {
            $nMock->setRootPath("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to the root directory is invalid. Empty string received.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_set_root_path_wrong_fails()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $rootPath = $dirResources . $ds . "app";

        $fail = false;
        try {
            $nMock->setRootPath($rootPath);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to the root directory does not exist [ \"$rootPath\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_root_path()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = $dirResources . $ds . "apps" . $ds;

        $nMock->setRootPath($expected);
        $this->assertSame($expected, $nMock->getRootPath());

        $nMock->setRootPath("another/path");
        $this->assertSame($expected, $nMock->getRootPath());
    }


    public function test_methods_getset_hosted_apps_empty_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);

        $fail = false;
        try {
            $nMock->setHostedApps([]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("No application was set for engine configuration.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_hosted_apps_non_exist_fails()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);

        $fail = false;
        try {
            $nMock->setHostedApps(["nonexist"]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The main directory of the application \"nonexist\" does not exist.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_hosted_apps()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $rootPath = $dirResources . $ds . "apps" . $ds;
        $expected = ["site", "blog"];

        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($expected);
        $this->assertSame($expected, $nMock->getHostedApps());

        $nMock->setHostedApps(["app"]);
        $this->assertSame($expected, $nMock->getHostedApps());
    }


    public function test_methods_getset_default_app_nonexist_fails()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $rootPath = $dirResources . $ds . "apps";
        $applications = ["site", "blog"];

        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($applications);


        $fail = false;
        try {
            $nMock->setDefaultApp("nonexist");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The application \"nonexist\" does not exist between hosted applications.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_default_app()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $rootPath = $dirResources . $ds . "apps" . $ds;
        $applications = ["site", "blog"];
        $expected = "site";

        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($applications);
        $nMock->setDefaultApp($expected);
        $this->assertSame($expected, $nMock->getDefaultApp());

        $nMock->setDefaultApp("blog");
        $this->assertSame($expected, $nMock->getDefaultApp());


        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($applications);
        $nMock->setDefaultApp("");
        $this->assertSame($expected, $nMock->getDefaultApp());
    }


    public function test_methods_getset_datetime_local()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = "America/Sao_Paulo";

        $nMock->setDateTimeLocal($expected);
        $this->assertSame($expected, $nMock->getDateTimeLocal());

        $nMock->setDateTimeLocal("another");
        $this->assertSame($expected, $nMock->getDateTimeLocal());
    }


    public function test_methods_getset_timeout()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = 1200;

        $nMock->setTimeOut($expected);
        $this->assertSame($expected, $nMock->getTimeOut());

        $nMock->setTimeOut(1000);
        $this->assertSame($expected, $nMock->getTimeOut());
    }


    public function test_methods_getset_max_file_size()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = 100;

        $nMock->setMaxFileSize($expected);
        $this->assertSame($expected, $nMock->getMaxFileSize());

        $nMock->setMaxFileSize(50);
        $this->assertSame($expected, $nMock->getMaxFileSize());
    }


    public function test_methods_getset_max_post_size()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = 100;

        $nMock->setMaxPostSize($expected);
        $this->assertSame($expected, $nMock->getMaxPostSize());

        $nMock->setMaxPostSize(50);
        $this->assertSame($expected, $nMock->getMaxPostSize());
    }


    public function test_methods_getset_path_to_error_view()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = "viewError.phtml";

        $nMock->setPathToErrorView($expected);
        $this->assertSame($expected, $nMock->getPathToErrorView());
        $this->assertSame($expected, $nMock->getFullPathToErrorView());

        $nMock->setPathToErrorView("anotherErrorView.phtml");
        $this->assertSame($expected, $nMock->getPathToErrorView());
    }


    public function test_methods_getset_application_className()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(false);
        $expected = "AppStart";

        $nMock->setApplicationClassName($expected);
        $this->assertSame($expected, $nMock->getApplicationClassName());

        $nMock->setApplicationClassName("StartApp");
        $this->assertSame($expected, $nMock->getApplicationClassName());
    }


    public function test_method_define_target_application()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(true);
        $nMock->defineTargetApplicationName("/site/path/to/resource?qs1=v1");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(false, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = prov_instanceOf_EnGarde_Config_Engine(true);
        $nMock->defineTargetApplicationName("/path/to/resource?qs1=v1");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = prov_instanceOf_EnGarde_Config_Engine(true);
        $nMock->defineTargetApplicationName("blog/path");

        $this->assertSame("blog", $nMock->getApplicationName());
        $this->assertSame(false, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\blog\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = prov_instanceOf_EnGarde_Config_Engine(true);
        $nMock->defineTargetApplicationName("/");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());


        $nMock = prov_instanceOf_EnGarde_Config_Engine(true);
        $nMock->defineTargetApplicationName("");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());
    }


    public function test_method_new_location_path()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(true);
        $nMock->defineTargetApplicationName("/site/path/to/resource?qs1=v1");

        $this->assertSame("", $nMock->getNewLocationPath());



        $nMock = prov_instanceOf_EnGarde_Config_Engine(true);
        $nMock->defineTargetApplicationName("SITE/path/to/resource?qs1=v1");

        $this->assertSame("/site/path/to/resource?qs1=v1", $nMock->getNewLocationPath());
    }


    public function test_method_set_php_configuration()
    {
        $nMock = prov_instanceOf_EnGarde_Config_Engine(true);
        $this->assertSame("1", ini_get("display_errors"));

        $nMock->setPHPConfiguration();
        $this->assertSame("0", ini_get("display_errors"));
    }
}
