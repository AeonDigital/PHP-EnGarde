<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Tests\Concrete\AppController as AppController;
use AeonDigital\Http\Message\Response as Response;
use AeonDigital\Http\Data\HeaderCollection as HeaderCollection;
use AeonDigital\Stream\Stream as Stream;

require_once __DIR__ . "/../phpunit.php";




class DomainControllerTest extends TestCase
{



    private function retrieveServerConfig()
    {
        $serverConfig = new \AeonDigital\Http\Tools\ServerConfig($_SERVER);
        $serverConfig->setHttpTools(new \AeonDigital\Http\Tools\Tools());
        return $serverConfig;
    }

    private function retrieveServerRequest()
    {
        $serverConfig = new \AeonDigital\Http\Tools\ServerConfig(null, true);
        $serverConfig->setHttpTools(new \AeonDigital\Http\Tools\Tools());

        return $serverConfig->getHttpTools()->createServerRequest(
            $serverConfig->getRequestMethod(),
            $serverConfig->getCurrentURI(),
            $serverConfig->getRequestHTTPVersion(),
            $serverConfig->getHttpTools()->createHeaderCollection($serverConfig->getRequestHeaders()),
            $serverConfig->getHttpTools()->createStreamFromBodyRequest(),
            $serverConfig->getHttpTools()->createCookieCollection($serverConfig->getRequestCookies()),
            $serverConfig->getHttpTools()->createQueryStringCollection($serverConfig->getRequestQueryStrings()),
            $serverConfig->getHttpTools()->createFileCollection($serverConfig->getRequestFiles()),
            $serverConfig->getServerVariables(),
            $serverConfig->getHttpTools()->createCollection(),
            $serverConfig->getHttpTools()->createCollection()
        );
    }

    private function retrieveDomainConfig()
    {
        $domainConfig = new \AeonDigital\EnGarde\Config\DomainConfig();
        $ds = DIRECTORY_SEPARATOR;
        $rootPath = dirname(__FILE__) . $ds . "apps";
        
        // Configura o domínio
        // com seus valores iniciais.
        $domainConfig->setVersion("0.9.0 [alpha]");

        $domainConfig->setEnvironmentType("test");
        $domainConfig->setIsDebugMode(true);
        $domainConfig->setIsUpdateRoutes(true);
        $domainConfig->setRootPath($rootPath);
        $domainConfig->setHostedApps(["site", "blog"]);
        $domainConfig->setDefaultApp("site");
        $domainConfig->setDateTimeLocal("America/Sao_Paulo");
        $domainConfig->setTimeOut(1200);
        $domainConfig->setMaxFileSize(100);
        $domainConfig->setMaxPostSize(100);
        $domainConfig->setApplicationClassName("AppStart");


        $domainConfig->setPHPDomainConfiguration();

        // Identifica qual aplicação deve ser iniciada.
        $domainConfig->defineTargetApplication("http://aeondigital.com.br");


        return $domainConfig;
    }

    private function retrieveApplicationConfig($appName, $rootPath)
    {
        return new \AeonDigital\EnGarde\Config\ApplicationConfig($appName, $rootPath);
    }

    private function retrieveRouteConfig()
    {
        return new \AeonDigital\EnGarde\Config\RouteConfig();
    }





    public function test_constructor_ok()
    {
        $nMock = new AppController();
        $this->assertTrue(is_a($nMock, AppController::class));
    }

    
    public function test_method_set_commom_properties()
    {
        $nMock = new AppController();
        
        $domainConfig = $this->retrieveDomainConfig();
        $nMock->setDomainConfig($domainConfig);

        $serverConfig = $this->retrieveServerConfig();
        $nMock->setServerConfig($serverConfig);

        $serverRequest = $this->retrieveServerRequest();
        $nMock->setServerRequest($serverRequest);

        $applicationConfig  = $this->retrieveApplicationConfig(
                                $domainConfig->getApplicationName(),
                                $domainConfig->getRootPath());
        $nMock->setApplicationConfig($applicationConfig);


        $routeConfig = $this->retrieveRouteConfig();
        $nMock->setRouteConfig($routeConfig);


        $val = ["prop1" => "val1", "prop2" => "val2"];
        $nMock->setRawRouteConfig($val);

        $this->assertTrue(true);
    }


    public function test_method_setget_mime()
    {
        $nMock = new AppController();

        $val = "testMime";
        $nMock->setResponseMime($val);

        $this->assertSame($val, $nMock->getResponseMime());
    }


    public function test_method_setget_locale()
    {
        $nMock = new AppController();

        $val = "testLocale";
        $nMock->setResponseLocale($val);

        $this->assertSame($val, $nMock->getResponseLocale());
    }










    protected function retrieveStreamObjectToTest($body = "")
    {
        $simpleStream = fopen("data://text/plain;base64," . base64_encode($body), "r+");
        return new Stream($simpleStream);
    }

    protected function retrieveHeadersToTest()
    { 
        return new HeaderCollection([
            "CONTENT_TYPE" => "value1, value2",
            "teste" => "text/html, application/xhtml+xml, application/xml;q=0.9 , */*;q=0.8",
            "unique" => "value unique"
        ]);
    }

    protected function retrieveHeadersToTest02()
    {
        return new HeaderCollection([
            "CONTENT_TYPE" => "ctype",
            "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "accept-language" => "pt-BR, pt;q=0.8, en-US;q=0.5, en;q=0.3",
            "teste" => "text/html, application/xhtml+xml, application/xml;q=0.9 , */*;q=0.8",
        ]);
    }

    protected function provider_response()
    {
        $oHeaders = $this->retrieveHeadersToTest();
        $oBody = $this->retrieveStreamObjectToTest("Test stream object");

        $res = new Response(200, "", "1.0", $oHeaders, $oBody);
        $this->assertTrue(is_a($res, Response::class));

        return $res;
    }

    protected function provider_controller()
    {
        $nMock = new AppController();
        
        $domainConfig = $this->retrieveDomainConfig();
        $nMock->setDomainConfig($domainConfig);

        $serverConfig = $this->retrieveServerConfig();
        $nMock->setServerConfig($serverConfig);

        $serverRequest = $this->retrieveServerRequest();
        $nMock->setServerRequest($serverRequest);

        $applicationConfig  = $this->retrieveApplicationConfig(
                                $domainConfig->getApplicationName(),
                                $domainConfig->getRootPath());
        $nMock->setApplicationConfig($applicationConfig);


        $routeConfig = $this->retrieveRouteConfig();
        $nMock->setRouteConfig($routeConfig);


        $val = ["prop1" => "val1", "prop2" => "val2"];
        $nMock->setRawRouteConfig($val);

        return $nMock;
    }



    public function test_method_setget_response()
    {
        // Inicia um novo objeto Controller e um novo Response.
        $nMock = $this->provider_controller();
        $respo = $this->provider_response();

        $this->assertNull($respo->getMime());
        $this->assertNull($respo->getLocale());

        // Define no objeto response algumas informações específicas.
        $nMock->setResponseMime("text/html");
        $nMock->setResponseLocale("pt-BR");
        $nMock->setViewData((object)["prop1" => "val1"]);

        // Injeta o objeto response no controller.
        // Ele deverá herdar as informações do controller.
        $nMock->setResponse($respo);

        // Resgata o objeto response com as alterações definidas.
        $cResp = $nMock->getResponse();
        
        $this->assertNotSame($respo, $cResp);
        $this->assertSame("text/html", $cResp->getMime());
        $this->assertSame("pt-BR", $cResp->getLocale());
    }



    public function test_method_setget_response_02()
    {
        // Inicia um novo objeto Controller e um novo Response.
        $nMock = $this->provider_controller();

        // Define no objeto response algumas informações específicas.
        $nMock->setResponseMime("text/html");
        $nMock->setResponseLocale("pt-BR");

        // Resgata um novo response sem que outro tenha sido 
        // anteriormente definido
        $respo = $nMock->getResponse();
        $this->assertSame("text/html", $respo->getMime());
        $this->assertSame("pt-BR", $respo->getLocale());
    }
}
