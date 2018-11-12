<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\DomainConfig as DomainConfig;

require_once __DIR__ . "/../phpunit.php";







class DomainConfigTest extends TestCase
{





    /**
     * Retorna um objeto "Config" para os testes
     *
     * @return DomainConfig
     */
    protected function setDomainConfigToTest(
        bool $autoSet = false,
        string $version = "0.9.0 [alpha]",
        string $environmentType = "test",
        bool $isDebugMode = false,
        bool $isUpdateRoutes = false,
        string $rootPath = "",
        array $hostedApps = ["site", "blog"],
        string $defaultApp = "site",
        string $dateTimeLocal = "America/Sao_Paulo",
        int $timeOut = 1200,
        int $maxFileSize = 100,
        int $maxPostSize = 100,
        string $applicationClassName = "AppStart"
    ) {
        $ds = DIRECTORY_SEPARATOR;
        $rootPath = (($rootPath === "") ? (dirname(__FILE__) . $ds . "apps") : $rootPath);
        $dc = new DomainConfig();

        if ($autoSet === true) {
            $dc->setVersion($version);
            $dc->setEnvironmentType($environmentType);
            $dc->setIsDebugMode($isDebugMode);
            $dc->setIsUpdateRoutes($isUpdateRoutes);
            $dc->setRootPath($rootPath);
            $dc->setHostedApps($hostedApps);
            $dc->setDefaultApp($defaultApp);
            $dc->setDateTimeLocal($dateTimeLocal);
            $dc->setTimeOut($timeOut);
            $dc->setMaxFileSize($maxFileSize);
            $dc->setMaxPostSize($maxPostSize);
            $dc->setApplicationClassName($applicationClassName);
        }

        return $dc;
    }










    public function test_constructor_ok()
    {
        $nMock = new DomainConfig();
        $this->assertTrue(is_a($nMock, DomainConfig::class));
    }


    
    public function test_method_get_now()
    {
        $nMock = new DomainConfig();
        $now = new \DateTime();

        $this->assertSame($now->format("Y-m-d H:i"), $nMock->getNow()->format("Y-m-d H:i"));
    }



    public function test_methods_getset_version()
    {
        $nMock = new DomainConfig();
        $nMock->setVersion("1.1");
        $this->assertSame("1.1", $nMock->getVersion());
    }



    public function test_methods_getset_environment_type()
    {
        $nMock = new DomainConfig();
        $now = new \DateTime();
        $expected = "production";

        $nMock->setEnvironmentType($expected);
        $this->assertSame($expected, $nMock->getEnvironmentType());

        $nMock->setEnvironmentType("development");
        $this->assertSame($expected, $nMock->getEnvironmentType());
    }



    public function test_methods_getset_debug_mode()
    {
        $nMock = new DomainConfig();
        $now = new \DateTime();
        $expected = true;

        $nMock->setIsDebugMode($expected);
        $this->assertSame($expected, $nMock->getIsDebugMode());

        $nMock->setIsDebugMode(false);
        $this->assertSame($expected, $nMock->getIsDebugMode());
    }



    public function test_methods_getset_update_routes()
    {
        $nMock = new DomainConfig();
        $now = new \DateTime();
        $expected = true;

        $nMock->setIsUpdateRoutes($expected);
        $this->assertSame($expected, $nMock->getIsUpdateRoutes());

        $nMock->setIsUpdateRoutes(false);
        $this->assertSame($expected, $nMock->getIsUpdateRoutes());
    }



    public function test_methods_set_root_path_empty_fails()
    {
        $nMock = new DomainConfig();

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
        $nMock = new DomainConfig();
        $ds = DIRECTORY_SEPARATOR;
        $rootPath = dirname(dirname(__FILE__)) . $ds . "app";

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
        $nMock = new DomainConfig();
        $ds = DIRECTORY_SEPARATOR;
        $expected = dirname(__FILE__) . $ds . "apps" . $ds;


        $nMock->setRootPath($expected);
        $this->assertSame($expected, $nMock->getRootPath());

        $nMock->setRootPath("another/path");
        $this->assertSame($expected, $nMock->getRootPath());
    }



    public function test_methods_getset_hosted_apps_empty_fails()
    {
        $nMock = new DomainConfig();

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
        $nMock = new DomainConfig();

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
        $nMock = new DomainConfig();

        $ds = DIRECTORY_SEPARATOR;
        $rootPath = dirname(__FILE__) . $ds . "apps";
        $expected = ["site", "blog"];

        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($expected);
        $this->assertSame($expected, $nMock->getHostedApps());

        $nMock->setHostedApps(["app"]);
        $this->assertSame($expected, $nMock->getHostedApps());
    }



    public function test_methods_getset_default_app_nonexist_fails()
    {
        $nMock = new DomainConfig();

        $ds = DIRECTORY_SEPARATOR;
        $rootPath = dirname(__FILE__) . $ds . "apps";
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
        $nMock = new DomainConfig();

        $ds = DIRECTORY_SEPARATOR;
        $rootPath = dirname(__FILE__) . $ds . "apps";
        $applications = ["site", "blog"];
        $expected = "site";

        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($applications);
        $nMock->setDefaultApp($expected);
        $this->assertSame($expected, $nMock->getDefaultApp());

        $nMock->setDefaultApp("blog");
        $this->assertSame($expected, $nMock->getDefaultApp());


        $nMock = new DomainConfig();
        $nMock->setRootPath($rootPath);
        $nMock->setHostedApps($applications);
        $nMock->setDefaultApp("");
        $this->assertSame($expected, $nMock->getDefaultApp());
    }



    public function test_methods_getset_datetime_local()
    {
        $nMock = new DomainConfig();
        $expected = "America/Sao_Paulo";

        $nMock->setDateTimeLocal($expected);
        $this->assertSame($expected, $nMock->getDateTimeLocal());

        $nMock->setDateTimeLocal("another");
        $this->assertSame($expected, $nMock->getDateTimeLocal());
    }



    public function test_methods_getset_timeout()
    {
        $nMock = new DomainConfig();
        $expected = 1200;

        $nMock->setTimeOut($expected);
        $this->assertSame($expected, $nMock->getTimeOut());

        $nMock->setTimeOut(1000);
        $this->assertSame($expected, $nMock->getTimeOut());
    }



    public function test_methods_getset_max_file_size()
    {
        $nMock = new DomainConfig();
        $expected = 100;

        $nMock->setMaxFileSize($expected);
        $this->assertSame($expected, $nMock->getMaxFileSize());

        $nMock->setMaxFileSize(50);
        $this->assertSame($expected, $nMock->getMaxFileSize());
    }



    public function test_methods_getset_max_post_size()
    {
        $nMock = new DomainConfig();
        $expected = 100;

        $nMock->setMaxPostSize($expected);
        $this->assertSame($expected, $nMock->getMaxPostSize());

        $nMock->setMaxPostSize(50);
        $this->assertSame($expected, $nMock->getMaxPostSize());
    }



    public function test_methods_getset_path_to_error_view()
    {
        $nMock = new DomainConfig();
        $expected = "viewError.phtml";

        $nMock->setPathToErrorView($expected);
        $this->assertSame($expected, $nMock->getPathToErrorView());
        $this->assertSame($expected, $nMock->getFullPathToErrorView());

        $nMock->setPathToErrorView("anotherErrorView.phtml");
        $this->assertSame($expected, $nMock->getPathToErrorView());
    }



    public function test_methods_getset_application_className()
    {
        $nMock = new DomainConfig();
        $expected = "AppStart";

        $nMock->setApplicationClassName($expected);
        $this->assertSame($expected, $nMock->getApplicationClassName());

        $nMock->setApplicationClassName("StartApp");
        $this->assertSame($expected, $nMock->getApplicationClassName());
    }



    public function test_method_define_target_application()
    {
        $nMock = $this->setDomainConfigToTest(true);
        $nMock->defineTargetApplication("/site/path/to/resource?qs1=v1");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(false, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = $this->setDomainConfigToTest(true);
        $nMock->defineTargetApplication("/path/to/resource?qs1=v1");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = $this->setDomainConfigToTest(true);
        $nMock->defineTargetApplication("blog/path");

        $this->assertSame("blog", $nMock->getApplicationName());
        $this->assertSame(false, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\blog\\AppStart", $nMock->retrieveApplicationNS());



        $nMock = $this->setDomainConfigToTest(true);
        $nMock->defineTargetApplication("/");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());


        $nMock = $this->setDomainConfigToTest(true);
        $nMock->defineTargetApplication("");

        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->isApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->retrieveApplicationNS());
    }


    public function test_method_new_location_path()
    {
        $nMock = $this->setDomainConfigToTest(true);
        $nMock->defineTargetApplication("/site/path/to/resource?qs1=v1");

        $this->assertSame(null, $nMock->getNewLocationPath());



        $nMock = $this->setDomainConfigToTest(true);
        $nMock->defineTargetApplication("SITE/path/to/resource?qs1=v1");

        $this->assertSame("/site/path/to/resource?qs1=v1", $nMock->getNewLocationPath());
    }



    public function test_method_set_php_domain_configuration()
    {
        $nMock = $this->setDomainConfigToTest(true);
        $this->assertSame("", ini_get("display_errors"));

        $nMock->setPHPDomainConfiguration();
        $this->assertSame("0", ini_get("display_errors"));
    }
}
