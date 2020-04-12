<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Handler\ResponseHandler as ResponseHandler;

require_once __DIR__ . "/../../phpunit.php";







class ResponseHandlerTest extends TestCase
{





    // Provê uma instância da classe 'AeonDigital\EnGarde\Handler\ResponseHandler'
    function createInstance(
        $environmentType = "localtest",
        $requestMethod = "GET",
        $url = "http://aeondigital.com.br",
        $serverConfig = null,
        $domainConfig = null,
        $applicationConfig = null,
        $specialSet = "0.9.0 [alpha]",
        $debugMode = false
    ) {
        global $dirResources;

        $response       = null;
        $routeConfig    = null;
        $tempAppRoutes  = require($dirResources . "/concrete/AppRoutes.php");



        // Inicia uma instância 'AeonDigital\Http\Message\ServerRequest'
        $serverRequest = prov_instanceOf_Http_ServerRequest_02($requestMethod, $url);
        //$serverRequest = $serverRequest->withCookieParams([]);



        // Conforme o método HTTP sendo testado...
        if ($requestMethod === "OPTIONS" || $requestMethod === "TRACE") {
            $response = prov_instanceOf_Http_Response();
        }
        else {
            // Inicia e configura o objeto 'AeonDigital\EnGarde\Config\Route'
            $routeConfig = prov_instanceOf_EnGarde_Config_Route(
                $tempAppRoutes["simple"]["/^\\/site\\//"][$requestMethod]
            );



            $routeMime = $routeConfig->negotiateMimeType(
                $serverRequest->getResponseMimes(),
                $serverRequest->getParam("_mime")
            );
            $routeConfig->setResponseMime($routeMime["mime"]);
            $routeConfig->setResponseMimeType($routeMime["mimetype"]);



            // Configura teste para casos onde a requisição é de um download.
            $isDownload_route = $routeConfig->getResponseIsDownload();
            $isDownload_param = $serverRequest->getParam("_download");
            if ($isDownload_param !== null) {
                $isDownload_param = ($isDownload_param === "true" || $isDownload_param === "1");
            }
            $routeConfig->setResponseIsDownload(
                (
                    $isDownload_param === true ||
                    (
                        ($isDownload_param === null || $isDownload_param === true) &&
                        $isDownload_route === true
                    )
                )
            );



            // Configura teste para casos onde a requisição exige que o código seja
            // retornado de forma "pretty_print"
            $prettyPrint = $serverRequest->getParam("_pretty_print");
            $routeConfig->setResponseIsPrettyPrint(($prettyPrint === "true" || $prettyPrint === "1"));





            // Valores iniciais do viewData
            $viewData = (object)[
                "appTitle" => "Application Title",
                "viewTitle" => "View Title",
                "mimeContent" => null
            ];



            // Faz um ajuste particular conforme o mime a ser usado
            $mime = $routeConfig->getResponseMime();
            if ($mime === "html") {
                $viewData->mimeContent = "This is a HTML document.";
            }
            elseif ($mime === "xhtml") {
                $viewData->mimeContent = "This is a X/HTML document.";
            }
            elseif ($mime === "json") {
                $viewData->mimeContent = "This is a JSON document.";
            }
            elseif ($mime === "txt") {
                $routeConfig->setMasterPage(null);
                $routeConfig->setView(null);

                $viewData->subData = [
                    "attr1" => "val1",
                    "attr2" => "val2",
                    "attr3" => "val3",
                    "attr4" => 8383738,
                    "attr5" => new \DateTime("2000-01-01 00:00:00"),
                    "attr6" => $routeConfig
                ];
            }
            elseif ($mime === "xml") {
                $routeConfig->setMasterPage(null);
                $routeConfig->setView(null);
            }
            elseif ($mime === "csv" || $mime === "xls" || $mime === "xlsx") {
                $viewData->metaData = (object)[
                    "authorName" => "Rianna Cantarelli",
                    "companyName" => "Aeon Digital",
                    "createdDate" => new \DateTime("2019-02-10 10:10:10"),
                    "keywords" => "key1, key2, key3",
                    "description" => "Teste de criação de planilhas"
                ];
                $viewData->dataTable = [
                    ["nome", "email", "categoria", "cpf", "number", "data"],
                    ["n1\"com aspas e acentuação", "email@1", "cat1", "cpf1", 1, new \DateTime("2001-01-01 01:01:01")],
                    ["n2", "email@2", "cat2", "cpf2", 2, new \DateTime("2002-02-02 02:02:02")],
                    ["n3", "email@3", "cat3", "cpf3", 3, new \DateTime("2003-03-03 03:03:03")],
                    ["n4", "email@4", "cat4", "cpf4", 4, new \DateTime("2004-04-04 04:04:04")]
                ];
            }
            elseif ($mime === "pdf") {
                $routeConfig->setMasterPage("masterPagePDF.phtml");
                $routeConfig->setView("home/indexPDF.phtml");
                $viewData->mimeContent = "This is a PDF document.";
                $viewData->metaData = (object)[
                    "authorName" => "Rianna Cantarelli",
                    "companyName" => "Aeon Digital",
                    "createdDate" => new \DateTime("2019-02-10 10:10:10"),
                    "keywords" => "key1, key2, key3",
                    "description" => "Teste de criação de planilhas"
                ];
            }


            $response = prov_instanceOf_Http_Response_02(
                [],
                "",
                $viewData,
                null
            );
        }




        // Inicia e configura uma instância 'AeonDigital\EnGarde\Config\Server'
        if ($serverConfig === null) {
            $serverConfig = prov_instanceOf_EnGarde_Config_Server(
                true, null, null, null, null, $requestMethod, $serverRequest->getUri()->getRelativeUri()
            );

            $serverConfig->setHttpFactory(
                prov_instanceOf_Http_Factory()
            );
        }


        // Inicia e configura uma instância 'AeonDigital\EnGarde\Config\Domain'
        if ($domainConfig === null) {
            $domainConfig = prov_instanceOf_EnGarde_Config_Domain(
                true, $specialSet, $environmentType, $debugMode, false, to_system_path($dirResources . "/apps")
            );
            $domainConfig->setPathToErrorView("errorView.phtml");
        }


        // Inicia e configura uma instância 'AeonDigital\EnGarde\Config\Application'
        if ($applicationConfig === null) {
            $applicationConfig = prov_instanceOf_EnGarde_Config_Application(
                true,
                "site",
                to_system_path($dirResources . "/apps")
            );
            $applicationConfig->setLocales(["pt-BR", "en-US"]);
            $applicationConfig->setDefaultLocale("pt-BR");
        }





        // Se existir, configura a instância 'AeonDigital\EnGarde\Config\Route'
        if ($routeConfig !== null) {
            // Verifica qual locale deve ser usado para responder
            // esta requisição
            $useLocale = $routeConfig->negotiateLocale(
                $serverRequest->getResponseLocales(),
                $serverRequest->getResponseLanguages(),
                $applicationConfig->getLocales(),
                $applicationConfig->getDefaultLocale(),
                $serverRequest->getParam("_locale")
            );
            $routeConfig->setResponseLocale($useLocale);



            // Verifica qual mimetype deve ser usado para responder esta requisição
            $routeMime = $routeConfig->negotiateMimeType(
                $serverRequest->getResponseMimes(),
                $serverRequest->getParam("_mime")
            );
            $routeConfig->setResponseMime($routeMime["mime"]);
            $routeConfig->setResponseMimeType($routeMime["mimetype"]);


            // Identifica se é para usar "pretty print" no código fonte de retorno
            $prettyPrint = $serverRequest->getParam("_pretty_print");
            $routeConfig->setResponseIsPrettyPrint(($prettyPrint === "true" || $prettyPrint === "1"));
        }




        // Monta e retorna a instância
        return new ResponseHandler(
            $serverConfig,
            $domainConfig,
            $applicationConfig,
            $serverRequest,
            $tempAppRoutes["simple"]["/^\\/site\\//"],
            $routeConfig,
            $response
        );
    }









    public function test_constructor_ok()
    {
        $obj = $this->createInstance();
        $this->assertTrue(is_a($obj, ResponseHandler::class));
    }



    public function test_check_response_to_OPTIONS()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $obj = $this->createInstance(
            "localtest",
            "OPTIONS"
        );
        $rResponse = $obj->prepareResponse();


        // Testa os headers
        $tgtPathToExpected  = $dirResources . "/responses/responseOPTIONSHeaders.json";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }
        else {
            file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
            $expected = json_encode($rResponse->getHeaders());
        }

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        $this->assertEquals($objExpected, $objOutput);





        // Testa o corpo criado
        $tgtPathToExpected  = $dirResources . "/responses/responseOPTIONSBody.json";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }
        else {
            file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
            $expected = (string)$rResponse->getBody();
        }

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode((string)$rResponse->getBody());

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        $this->assertEquals($objExpected, $objOutput);
    }



    public function test_check_response_to_TRACE()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $obj = $this->createInstance(
            "localtest",
            "TRACE"
        );
        $rResponse = $obj->prepareResponse();


        // Testa os headers
        $tgtPathToExpected  = $dirResources . "/responses/responseTRACEHeaders.json";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }
        else {
            file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
            $expected = json_encode($rResponse->getHeaders());
        }

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        $this->assertEquals($objExpected, $objOutput);





        // Testa o corpo criado
        $tgtPathToExpected  = $dirResources . "/responses/responseTRACEBody.json";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }
        else {
            file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
            $expected = (string)$rResponse->getBody();
        }

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode((string)$rResponse->getBody());

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        $this->assertEquals($objExpected, $objOutput);
    }



    public function test_check_response_to_GET_html()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;


        $obj = $this->createInstance(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=html&_pretty_print=true"
        );
        $rResponse = $obj->prepareResponse();


        // Testa os headers
        $tgtPathToExpected  = $dirResources . "/responses/responseGETHeaders_html.json";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }
        else {
            file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
            $expected = json_encode($rResponse->getHeaders());
        }

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        $this->assertEquals($objExpected, $objOutput);





        // Testa o corpo criado
        $tgtPathToExpected  = $dirResources . "/responses/responseGETBody.html";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }
        else {
            file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
            $expected = (string)$rResponse->getBody();
        }

        $this->assertEquals($objExpected, $objOutput);
    }
}
