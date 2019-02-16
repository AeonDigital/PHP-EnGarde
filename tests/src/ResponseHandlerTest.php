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

        // Individualizar os testes para cada Mimetype de forma no __provider para que cada
        // um tenha algo substancialmente difernte permitindo o teste adequado.

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
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody.html";
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
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody.xhtml";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($expected, (string)$rResponse->getBody());
    }


    public function test_check_response_to_GET_json()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=json"
        );
        $rResponse = $obj->prepareResponse();



        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETHeaders_json.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        

        
        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody.json";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($expected, (string)$rResponse->getBody());
    }


    public function test_check_response_to_GET_txt()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=txt"
        );
        $rResponse = $obj->prepareResponse();



        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETHeaders_txt.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        

        
        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody.txt";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($expected, (string)$rResponse->getBody());
    }


    public function test_check_response_to_GET_xml()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=xml"
        );
        $rResponse = $obj->prepareResponse();



        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETHeaders_xml.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        

        
        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody.xml";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($expected, (string)$rResponse->getBody());
    }


    public function test_check_response_to_GET_csv()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=csv"
        );
        $rResponse = $obj->prepareResponse();



        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETHeaders_csv.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        

        
        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody.csv";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($expected, (string)$rResponse->getBody());
    }


    public function test_check_response_to_GET_xls()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=xls"
        );
        $rResponse = $obj->prepareResponse();



        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETHeaders_xls.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        

        
        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody.xls";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        $this->assertEquals($expected, (string)$rResponse->getBody());
    }


    public function test_check_response_to_GET_xlsx()
    {
        $obj = provider_PHPEnGarde_InstanceOf_ResponseHandler(
            "localtest",
            "GET",
            "http://aeondigital.com.br?_mime=xlsx"
        );
        $rResponse = $obj->prepareResponse();



        // Testa os headers
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETHeaders_xlsx.json";
        $expected           = file_get_contents($tgtPathToExpected);

        $objExpected    = json_decode($expected);
        $objOutput      = json_decode(json_encode($rResponse->getHeaders()));

        $objExpected->RequestDate   = $objOutput->RequestDate;
        $objExpected->ResponseDate  = $objOutput->ResponseDate;

        //file_put_contents($tgtPathToExpected, json_encode($rResponse->getHeaders()));
        $this->assertEquals($objExpected, $objOutput);
        

        
        // Testa o corpo criado
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/responseGETBody.xlsx";
        $expected           = file_get_contents($tgtPathToExpected);

        // O corpo deste tipo de arquivo não pode ser testado com uma simples comparação pois
        // por tornar-se um binário, há variações que aparentemente não são possíveis de serem controladas.
        
        //file_put_contents($tgtPathToExpected, (string)$rResponse->getBody());
        //$this->assertEquals($expected, (string)$rResponse->getBody());
    }

}
