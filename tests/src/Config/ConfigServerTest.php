<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Server as Server;

require_once __DIR__ . "/../../phpunit.php";







class ConfigServerTest extends TestCase
{





    public function test_constructor_ok()
    {
        $nMock = new Server();
        $this->assertTrue(is_a($nMock, Server::class));
    }

    /*  Prosseguir daqui! - Resolver estas questões dos "providers"
        gerar um padrão para todos os projetos, começando pelo PHP-HTTP
    public function test_method_get_server_variables()
    {
        global $defaultServerConfig;
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(false);
        $this->assertNull($nMock->getServerVariables());

        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig();
        $this->assertSame($defaultServerConfig, $nMock->getServerVariables());
    }


    public function test_method_getset_httptools()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $nHttpFactory = provider_PHPEnGardeConfig_InstanceOf_HttpFactory();

        $nMock->setHttpFactory($nHttpFactory);
        $this->assertSame($nHttpFactory, $nMock->getHttpFactory());
    }


    public function test_method_set_rootpath_fail()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        try {
            $nMock->setRootPath("non/existent/directory");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The given directory does not exist.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_getset_rootpath()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $targetDir = __DIR__;

        $nMock->setRootPath($targetDir);
        $this->assertSame($targetDir, $nMock->getRootPath());


        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $this->assertSame("/var/www/html", $nMock->getRootPath());
    }


    public function test_method_get_client_ip()
    {
        $strTest = [
            "REMOTE_ADDR" => "192.168.0.6",
            "HTTP_FORWARDED" => "192.168.0.5",
            "HTTP_FORWARDED_FOR" => "192.168.0.4",
            "HTTP_X_FORWARDED" => "192.168.0.3",
            "HTTP_X_FORWARDED_FOR" => "192.168.0.2",
            "HTTP_CLIENT_IP" => "192.168.0.1"
        ];

        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(false);
        foreach ($strTest as $k => $v) {
            putenv($k . "=" . $v);
            $result = $nMock->getClientIP();
            $this->assertEquals($v, $result);
        }
    }


    public function test_method_get_request_headers()
    {
        global $defaultServerConfig;
        $nMock      = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(false);
        $headers    = $nMock->getRequestHeaders();
        $this->assertNull($headers);

        $nMock      = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $headers    = $nMock->getRequestHeaders();
        $this->assertNotNull($headers);

        foreach ($headers as $key => $value) {

            $kname = null;
            if (key_exists($key, $defaultServerConfig) === true) {
                $kname = $key;
            } else {
                if (key_exists("HTTP_" . $key, $defaultServerConfig) === true) {
                    $kname = "HTTP_" . $key;
                }
            }

            $this->assertNotNull($kname);
            $this->assertSame($defaultServerConfig[$kname], $value);
        }
    }


    public function test_method_get_request_http_version()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $this->assertSame("1.1", $nMock->getRequestHTTPVersion());
    }


    public function test_method_get_request_is_use_https()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(false);
        $nMock->setServerVariables(["SERVER_PORT" => "443"]);
        $this->assertTrue($nMock->getRequestIsUseHTTPS());


        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(false);
        $nMock->setServerVariables(["SERVER_PORT" => "80"]);
        $this->assertFalse($nMock->getRequestIsUseHTTPS());
    }


    public function test_method_get_request_method()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $nMock->setServerVariables(["REQUEST_METHOD" => "POST"]);
        $this->assertSame("POST", $nMock->getRequestMethod());


        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $nMock->setServerVariables(["REQUEST_METHOD" => "PUT"]);
        $this->assertSame("PUT", $nMock->getRequestMethod());
    }


    public function test_method_get_request_protocol()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $nMock->setServerVariables(["SERVER_PORT" => "443"]);
        $this->assertSame("https", $nMock->getRequestProtocol());


        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $nMock->setServerVariables(["SERVER_PORT" => "80"]);
        $this->assertSame("http", $nMock->getRequestProtocol());
    }


    public function test_method_get_request_domain_name()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $this->assertSame("test.server.com.br", $nMock->getRequestDomainName());
    }


    public function test_method_get_request_path()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $this->assertSame("/", $nMock->getRequestPath());
    }


    public function test_method_get_request_port()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $this->assertSame(80, $nMock->getRequestPort());
    }


    public function test_method_get_request_cookies()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $this->assertSame(
            "first=primeiro+valor%3A+rianna%40gmail.com; second=segundo+valor%3A+http%3A%2F%2Faeondigital.com.br",
            $nMock->getRequestCookies()
        );
    }


    public function test_method_get_request_querystrings()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $this->assertSame(
            "qskey1=valor 1&qskey2=valor 2",
            $nMock->getRequestQueryStrings()
        );
    }


    public function test_method_get_request_files()
    {
        provider_PHPEnGardeConfig_DefineServerFiles();

        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(false);
        $newObj = $nMock->getRequestFiles();

        $this->assertSame(2, count($newObj));
    }


    public function test_method_get_current_uri()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(false);
        $this->assertSame(null, $nMock->getServerVariables());

        $result = $nMock->getCurrentURI();
        $this->assertSame("", $result);



        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
        $result = $nMock->getCurrentURI();
        $this->assertSame("http://test.server.com.br", $result);


        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true, "200.200.100.50", 443, "test.server.com.br");
        $result = $nMock->getCurrentURI();
        $this->assertSame("https://test.server.com.br", $result);


        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true, "200.200.100.50", 8080, "test.server.com.br");
        $result = $nMock->getCurrentURI();
        $this->assertSame("http://test.server.com.br:8080", $result);
    }


    public function test_method_get_posted_data()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(
            true,
            "200.200.100.50",
            80,
            "test.server.com.br",
            "GET",
            "/",
            "/?param1=value1&param2=value2"
        );

        $expected = [
            "param1" => "value1",
            "param2" => "value2"
        ];

        $result = $nMock->getPostedData();
        $this->assertSame($expected, $result);
    }
    */
}
