<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Domain as Domain;

require_once __DIR__ . "/../../phpunit.php";







class DomainTest extends TestCase
{





    public function test_constructor_ok()
    {
        $nMock = new Domain();
        $this->assertTrue(is_a($nMock, Domain::class));
    }


    public function test_method_get_now()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);

        $now = new \DateTime();
        $this->assertSame($now->format("Y-m-d H:i"), $nMock->getNow()->format("Y-m-d H:i"));
    }


    public function test_methods_getset_version()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $nMock->setVersion("1.1");
        $this->assertSame("1.1", $nMock->getVersion());
    }


    public function test_methods_getset_environment_type()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = "production";

        $nMock->setEnvironmentType($expected);
        $this->assertSame($expected, $nMock->getEnvironmentType());

        $nMock->setEnvironmentType("development");
        $this->assertSame($expected, $nMock->getEnvironmentType());
    }


    public function test_methods_getset_debug_mode()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = true;

        $nMock->setIsDebugMode($expected);
        $this->assertSame($expected, $nMock->getIsDebugMode());

        $nMock->setIsDebugMode(false);
        $this->assertSame($expected, $nMock->getIsDebugMode());
    }


    public function test_methods_getset_update_routes()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = true;

        $nMock->setIsUpdateRoutes($expected);
        $this->assertSame($expected, $nMock->getIsUpdateRoutes());

        $nMock->setIsUpdateRoutes(false);
        $this->assertSame($expected, $nMock->getIsUpdateRoutes());
    }


    public function test_methods_set_root_path_empty_fails()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);

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
        global $resourcesDir;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $rootPath = $resourcesDir . $ds . "app";

        $fail = false;
        try {
            $nMock->setRootPath($rootPath);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The path to the root directory of the domain does not exist [ \"$rootPath\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_root_path()
    {
        global $resourcesDir;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = $resourcesDir . $ds . "apps" . $ds;

        $nMock->setRootPath($expected);
        $this->assertSame($expected, $nMock->getRootPath());

        $nMock->setRootPath("another/path");
        $this->assertSame($expected, $nMock->getRootPath());
    }


    public function test_methods_getset_hosted_apps_empty_fails()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);

        $fail = false;
        try {
            $nMock->setHostedApps([]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("No application was set for domain configuration.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_hosted_apps_non_exist_fails()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);

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
        global $resourcesDir;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $rootPath = $resourcesDir . $ds . "apps" . $ds;
        $expected = ["site", "blog"];

        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($expected);
        $this->assertSame($expected, $nMock->getHostedApps());

        $nMock->setHostedApps(["app"]);
        $this->assertSame($expected, $nMock->getHostedApps());
    }


    public function test_methods_getset_default_app_nonexist_fails()
    {
        global $resourcesDir;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $rootPath = $resourcesDir . $ds . "apps";
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
        global $resourcesDir;
        $ds = DIRECTORY_SEPARATOR;


        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $rootPath = $resourcesDir . $ds . "apps" . $ds;
        $applications = ["site", "blog"];
        $expected = "site";

        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($applications);
        $nMock->setDefaultApp($expected);
        $this->assertSame($expected, $nMock->getDefaultApp());

        $nMock->setDefaultApp("blog");
        $this->assertSame($expected, $nMock->getDefaultApp());


        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($applications);
        $nMock->setDefaultApp("");
        $this->assertSame($expected, $nMock->getDefaultApp());
    }


    public function test_methods_getset_datetime_local()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = "America/Sao_Paulo";

        $nMock->setDateTimeLocal($expected);
        $this->assertSame($expected, $nMock->getDateTimeLocal());

        $nMock->setDateTimeLocal("another");
        $this->assertSame($expected, $nMock->getDateTimeLocal());
    }


    public function test_methods_getset_timeout()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = 1200;

        $nMock->setTimeOut($expected);
        $this->assertSame($expected, $nMock->getTimeOut());

        $nMock->setTimeOut(1000);
        $this->assertSame($expected, $nMock->getTimeOut());
    }


    public function test_methods_getset_max_file_size()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = 100;

        $nMock->setMaxFileSize($expected);
        $this->assertSame($expected, $nMock->getMaxFileSize());

        $nMock->setMaxFileSize(50);
        $this->assertSame($expected, $nMock->getMaxFileSize());
    }


    public function test_methods_getset_max_post_size()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = 100;

        $nMock->setMaxPostSize($expected);
        $this->assertSame($expected, $nMock->getMaxPostSize());

        $nMock->setMaxPostSize(50);
        $this->assertSame($expected, $nMock->getMaxPostSize());
    }


    public function test_methods_getset_path_to_error_view()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = "viewError.phtml";

        $nMock->setPathToErrorView($expected);
        $this->assertSame($expected, $nMock->getPathToErrorView());
        $this->assertSame($expected, $nMock->getFullPathToErrorView());

        $nMock->setPathToErrorView("anotherErrorView.phtml");
        $this->assertSame($expected, $nMock->getPathToErrorView());
    }


    public function test_methods_getset_application_className()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(false);
        $expected = "AppStart";

        $nMock->setApplicationClassName($expected);
        $this->assertSame($expected, $nMock->getApplicationClassName());

        $nMock->setApplicationClassName("StartApp");
        $this->assertSame($expected, $nMock->getApplicationClassName());
    }


    public function test_method_define_target_application()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(true);
        $nMock->defineTargetApplication("/site/path/to/resource?qs1=v1");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(false, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(true);
        $nMock->defineTargetApplication("/path/to/resource?qs1=v1");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(true);
        $nMock->defineTargetApplication("blog/path");

        $this->assertSame("blog", $nMock->getApplicationName());
        $this->assertSame(false, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\blog\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(true);
        $nMock->defineTargetApplication("/");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());


        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(true);
        $nMock->defineTargetApplication("");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());
    }


    public function test_method_new_location_path()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(true);
        $nMock->defineTargetApplication("/site/path/to/resource?qs1=v1");

        $this->assertSame(null, $nMock->getNewLocationPath());



        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(true);
        $nMock->defineTargetApplication("SITE/path/to/resource?qs1=v1");

        $this->assertSame("/site/path/to/resource?qs1=v1", $nMock->getNewLocationPath());
    }


    public function test_method_set_php_domain_configuration()
    {
        $nMock = provider_PHPEnGarde_InstanceOf_ConfigDomain(true);
        $this->assertSame("1", ini_get("display_errors"));

        $nMock->setPHPDomainConfiguration();
        $this->assertSame("0", ini_get("display_errors"));
    }
}
