<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\RequestHandler as RequestHandler;

require_once __DIR__ . "/../../phpunit.php";







class RequestHandlerTest extends TestCase
{


    private $defaultURLToTest01 = "http://aeondigital.com.br/path/to/resource?param1=value1&param2=acentuação";





    public function test_constructor_ok()
    {
        $reqHand = prov_instanceOf_EnGarde_HttpRequestHandler();
        $obj = new RequestHandler($reqHand);
        $this->assertTrue(is_a($obj, RequestHandler::class));
    }

    /*
    public function test_method_add_method_handle()
    {
        $obj = provider_PHPEnGarde_InstanceOf_RequestHandler();
        $obj->add(provider_PHPEnGarde_InstanceOf_Middleware("1"));
        $obj->add(provider_PHPEnGarde_InstanceOf_Middleware("2"));
        $obj->add(provider_PHPEnGarde_InstanceOf_Middleware("3"));

        $serverRequest = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURLToTest01);
        $finalResponse = $obj->handle($serverRequest);

        $expectedViewData = [
            "Mid_Before_1"  => "1",
            "Mid_Before_2"  => "2",
            "Mid_Before_3"  => "3",
            "Mid_After_3"   => "3",
            "Mid_After_2"   => "2",
            "Mid_After_1"   => "1",
        ];

        $this->assertSame($expectedViewData, (array)$finalResponse->getViewData());
    }
    */

}
