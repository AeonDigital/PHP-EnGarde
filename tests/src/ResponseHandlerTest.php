<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\ResponseHandler as ResponseHandler;

require_once __DIR__ . "/../phpunit.php";







class ResponseHandlerTest extends TestCase
{


    public function test_constructor_ok()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET"
        );
        $this->assertTrue(is_a($obj, ResponseHandler::class));
    }


    public function test_check_response_to_OPTIONS()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "OPTIONS"
        );
        $rResponse = $obj->prepareResponse();


        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseOPTIONSHeaders.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        


        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseOPTIONSBody.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode((string)$rResponse->getBody());

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($objExpected, $objOutput);
    }


    public function test_check_response_to_TRACE()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "TRACE"
        );
        $rResponse = $obj->prepareResponse();


        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseTRACEHeaders.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        


        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseTRACEBody.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode((string)$rResponse->getBody());

        $objExpected->requestDate   = $objOutput->requestDate;
        $objExpected->responseDate  = $objOutput->responseDate;

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($objExpected, $objOutput);
    }


    public function test_check_response_to_GET_html()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=html&_pretty_print=true"
        );
        $rResponse = $obj->prepareResponse();



        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETHeaders_html.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        

        
        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody_html.html";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($expected, (string)$rResponse->getBody());
    }


    public function test_check_response_to_GET_xhtml()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=xhtml"
        );
        $rResponse = $obj->prepareResponse();



        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETHeaders_xhtml.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        

        
        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody_xhtml.html";
        $expected           = file_get_contents($tgtPathToExpected);

        // Ver por que ao testar em lote este teste falha!!!
        //$tgtPathToExpected1  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody_xhtml1.html";
        //$tgtPathToExpected2  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody_xhtml2.html";
        //file_put_contents($tgtPathToExpected1, $expected);
        //file_put_contents($tgtPathToExpected2, (string)$rResponse->getBody());

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($expected, (string)$rResponse->getBody());
    }
}
