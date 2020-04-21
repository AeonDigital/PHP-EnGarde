<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Server as Server;

require_once __DIR__ . "/../../phpunit.php";







class ConfigServerTest extends TestCase
{





    public function test_constructor_ok()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;

        $nMock = new Server($defaultServerVariables, [], $defaultEngineVariables);
        $this->assertTrue(is_a($nMock, Server::class));
    }


    public function test_method_get_server_variables()
    {
        global $defaultServerVariables;
        $defaultServerVariables["TEST"] = "TEST";
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertEquals("TEST", $nMock->getServerVariables()["TEST"]);
    }


    public function test_method_get_request_headers()
    {
        global $dirResources;
        global $defaultServerVariables;
        $nMock      = prov_instanceOf_EnGarde_Config_Server(
            ["DOCUMENT_ROOT" => $dirResources . DS . "apps"]
        );
        $headers    = $nMock->getRequestHeaders();
        $this->assertEquals([], $headers);


        $nMock      = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $headers    = $nMock->getRequestHeaders();
        $this->assertNotNull($headers);


        foreach ($headers as $key => $value) {

            $kname = null;
            if (key_exists($key, $defaultServerVariables) === true) {
                $kname = $key;
            } else {
                if (key_exists("HTTP_" . $key, $defaultServerVariables) === true) {
                    $kname = "HTTP_" . $key;
                }
            }

            $this->assertNotNull($kname);
            $this->assertSame($defaultServerVariables[$kname], $value);
        }
    }


    public function test_method_get_request_http_version()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame("1.1", $nMock->getRequestHTTPVersion());
    }


    public function test_method_get_request_is_use_https()
    {
        global $dirResources;
        $nMock = prov_instanceOf_EnGarde_Config_Server(
            [
                "DOCUMENT_ROOT" => $dirResources . DS . "apps",
                "SERVER_PORT" => "443"
            ]
        );
        $this->assertTrue($nMock->getRequestIsUseHTTPS());


        $nMock = prov_instanceOf_EnGarde_Config_Server(
            [
                "DOCUMENT_ROOT" => $dirResources . DS . "apps",
                "SERVER_PORT" => "80"
            ]
        );
        $this->assertFalse($nMock->getRequestIsUseHTTPS());
    }


    public function test_method_get_request_method()
    {
        global $dirResources;
        $nMock = prov_instanceOf_EnGarde_Config_Server(
            [
                "DOCUMENT_ROOT" => $dirResources . DS . "apps",
                "REQUEST_METHOD" => "POST"
            ]
        );
        $this->assertSame("POST", $nMock->getRequestMethod());


        $nMock = prov_instanceOf_EnGarde_Config_Server(
            [
                "DOCUMENT_ROOT" => $dirResources . DS . "apps",
                "REQUEST_METHOD" => "PUT"
            ]
        );
        $this->assertSame("PUT", $nMock->getRequestMethod());
    }


    public function test_method_get_request_protocol()
    {
        global $dirResources;
        $nMock = prov_instanceOf_EnGarde_Config_Server(
            [
                "DOCUMENT_ROOT" => $dirResources . DS . "apps",
                "SERVER_PORT" => "443"
            ]
        );
        $this->assertSame("https", $nMock->getRequestProtocol());


        $nMock = prov_instanceOf_EnGarde_Config_Server(
            [
                "DOCUMENT_ROOT" => $dirResources . DS . "apps",
                "SERVER_PORT" => "80"
            ]
        );
        $this->assertSame("http", $nMock->getRequestProtocol());
    }


    public function test_method_get_request_domain_name()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame("test.server.com.br", $nMock->getRequestDomainName());
    }


    public function test_method_get_request_path()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame("/", $nMock->getRequestPath());
    }


    public function test_method_get_request_port()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(80, $nMock->getRequestPort());
    }


    public function test_method_get_request_cookies()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(
            "first=primeiro+valor%3A+rianna%40gmail.com; second=segundo+valor%3A+http%3A%2F%2Faeondigital.com.br",
            $nMock->getRequestCookies()
        );
    }


    public function test_method_get_request_querystrings()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(
            "qskey1=valor 1&qskey2=valor 2",
            $nMock->getRequestQueryStrings()
        );
    }


    public function test_method_get_request_files()
    {
        prov_defineGlobal_FILES();
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables, $_FILES);

        $newObj = $nMock->getRequestFiles();
        $this->assertSame(2, count($newObj));
    }





    public function test_method_get_current_uri()
    {
        global $dirResources;
        global $defaultServerVariables;
        $nMock      = prov_instanceOf_EnGarde_Config_Server(
            ["DOCUMENT_ROOT" => $dirResources . DS . "apps"]
        );

        $result = $nMock->getCurrentURI();
        $this->assertSame("", $result);



        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $result = $nMock->getCurrentURI();
        $this->assertSame("http://test.server.com.br", $result);


        $nMock = prov_instanceOf_EnGarde_Config_Server([
            "DOCUMENT_ROOT" => $dirResources . DS . "apps",
            "SERVER_NAME" => "test.server.com.br",
            "SERVER_PORT" => "443"
        ]);
        $result = $nMock->getCurrentURI();
        $this->assertSame("https://test.server.com.br", $result);


        $nMock = prov_instanceOf_EnGarde_Config_Server([
            "DOCUMENT_ROOT" => $dirResources . DS . "apps",
            "SERVER_NAME" => "test.server.com.br",
            "SERVER_PORT" => "8080"
        ]);
        $result = $nMock->getCurrentURI();
        $this->assertSame("http://test.server.com.br:8080", $result);
    }


    public function test_method_get_client_ip()
    {
        $strTest = [
            "REMOTE_ADDR"           => "192.168.0.6",
            "HTTP_FORWARDED"        => "192.168.0.5",
            "HTTP_FORWARDED_FOR"    => "192.168.0.4",
            "HTTP_X_FORWARDED"      => "192.168.0.3",
            "HTTP_X_FORWARDED_FOR"  => "192.168.0.2",
            "HTTP_CLIENT_IP"        => "192.168.0.1"
        ];

        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);

        foreach ($strTest as $k => $v) {
            putenv($k . "=" . $v);
            $result = $nMock->getClientIP();
            $this->assertEquals($v, $result);
        }
    }


    public function test_method_get_posted_data()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);


        $this->assertSame("qskey1=valor 1&qskey2=valor 2", $nMock->getRequestQueryStrings());
        \parse_str($nMock->getRequestQueryStrings(), $_GET);


        $result = $nMock->getPostedData();
        $this->assertSame(["qskey1" => "valor 1", "qskey2" => "valor 2"], $result);
    }





    public function test_method_getset_rootpath()
    {
        global $dirResources;
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame($dirResources . DS . "apps", $nMock->getRootPath());
    }


    public function test_methods_getset_environment_type_fails()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        $testEngineVariables = array_merge([], $defaultEngineVariables);
        $testEngineVariables["environmentType"] = "NonExist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"environmentType\". Expected [ PRD, HML, QA, DEV, LCL, UTEST ]. Given: [ NonExist ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_environment_type()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame("UTEST", $nMock->getEnvironmentType());
    }


    public function test_methods_getset_debug_mode()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(true, $nMock->getIsDebugMode());
    }


    public function test_methods_getset_update_routes()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(true, $nMock->getIsUpdateRoutes());
    }


    public function test_methods_getset_hosted_apps_fails()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        $testEngineVariables = array_merge([], $defaultEngineVariables);
        $testEngineVariables["hostedApps"] = [];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"hostedApps\". Expected a non-empty array.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");




        $testEngineVariables["hostedApps"] = ["nonexists"];

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "The main directory of the application \"nonexists\" does not exist.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_hosted_apps()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(["site", "blog"], $nMock->getHostedApps());
    }


    public function test_methods_getset_default_app_fails()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        $testEngineVariables = array_merge([], $defaultEngineVariables);
        $testEngineVariables["defaultApp"] = "nonexist";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"defaultApp\". Expected [ site, blog ]. Given: [ nonexist ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_default_app()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame("site", $nMock->getDefaultApp());
    }


    public function test_methods_getset_datetime_local()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame("America/Sao_Paulo", $nMock->getDateTimeLocal());
    }


    public function test_methods_getset_timeout_fails()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        $testEngineVariables = array_merge([], $defaultEngineVariables);
        $testEngineVariables["timeout"] = -1;

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"timeout\". Expected integer greather than zero. Given: [ -1 ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_timeout()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(1200, $nMock->getTimeout());
    }


    public function test_methods_getset_max_file_size_fails()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        $testEngineVariables = array_merge([], $defaultEngineVariables);
        $testEngineVariables["maxFileSize"] = -1;

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"maxFileSize\". Expected integer greather than zero. Given: [ -1 ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_max_file_size()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(100, $nMock->getMaxFileSize());
    }


    public function test_methods_getset_max_post_size_fails()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        $testEngineVariables = array_merge([], $defaultEngineVariables);
        $testEngineVariables["maxPostSize"] = -1;

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"maxPostSize\". Expected integer greather than zero. Given: [ -1 ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_max_post_size()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(100, $nMock->getMaxPostSize());
    }


    public function test_methods_getset_path_to_error_view_fails()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        $testEngineVariables = array_merge([], $defaultEngineVariables);
        $testEngineVariables["pathToErrorView"] = DS . "nonexists.php";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $path = $defaultServerVariables["DOCUMENT_ROOT"] . DS . "nonexists.php";
            $this->assertSame(
                "Invalid value defined for \"pathToErrorView\". File does not exists. Given: [ $path ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_path_to_error_view()
    {
        global $dirResources;
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame(DS . "errorView.phtml", $nMock->getPathToErrorView());
        $this->assertSame(
            $dirResources . DS . "apps" . DS . "errorView.phtml",
            $nMock->getPathToErrorView(true)
        );
    }


    public function test_methods_getset_application_className_fails()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        $testEngineVariables = array_merge([], $defaultEngineVariables);
        $testEngineVariables["applicationClassName"] = "";

        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_Config_Server(
                $defaultServerVariables, [], $testEngineVariables
            );
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"applicationClassName\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_methods_getset_application_className()
    {
        global $defaultServerVariables;
        $nMock = prov_instanceOf_EnGarde_Config_Server($defaultServerVariables);
        $this->assertSame("AppStart", $nMock->getApplicationClassName());
    }





    public function test_method_application_info()
    {
        global $defaultServerVariables;
        $testServerVariables = array_merge([], $defaultServerVariables);



        $testServerVariables["REQUEST_URI"] = "/site/path/to/resource?qs1=v1";
        $nMock = prov_instanceOf_EnGarde_Config_Server($testServerVariables);
        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(false, $nMock->getIsApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->getApplicationNamespace());



        $testServerVariables["REQUEST_URI"] = "/path/to/resource?qs1=v1";
        $nMock = prov_instanceOf_EnGarde_Config_Server($testServerVariables);
        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->getIsApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->getApplicationNamespace());



        $testServerVariables["REQUEST_URI"] = "blog/path";
        $nMock = prov_instanceOf_EnGarde_Config_Server($testServerVariables);
        $this->assertSame("blog", $nMock->getApplicationName());
        $this->assertSame(false, $nMock->getIsApplicationNameOmitted());
        $this->assertSame("\\blog\\AppStart", $nMock->getApplicationNamespace());



        $testServerVariables["REQUEST_URI"] = "/";
        $nMock = prov_instanceOf_EnGarde_Config_Server($testServerVariables);
        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->getIsApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->getApplicationNamespace());


        $testServerVariables["REQUEST_URI"] = "";
        $nMock = prov_instanceOf_EnGarde_Config_Server($testServerVariables);
        $this->assertSame("site", $nMock->getApplicationName());
        $this->assertSame(true, $nMock->getIsApplicationNameOmitted());
        $this->assertSame("\\site\\AppStart", $nMock->getApplicationNamespace());
    }

}
