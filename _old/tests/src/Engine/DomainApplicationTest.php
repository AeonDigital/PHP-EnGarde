<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Domain\Engine as Engine;

require_once __DIR__ . "/../phpunit.php";







class DomainApplicationTest extends TestCase
{





    public function test_check_response_to_error_404()
    {
        $domainEngine = prov_instanceOf_EnGarde_Domain_Engine("localtest", "GET", "/non-exist-route/for/this");
        $domainEngine->run();
        $output = $domainEngine->getTestViewDebug();

        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/error404.html";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, $output);
        $this->assertSame($expected, $output);
    }



    public function test_check_response_to_error_501()
    {
        $domainEngine = prov_instanceOf_EnGarde_Domain_Engine("testview", "PUT", "/");
        $domainEngine->run();
        $output = $domainEngine->getTestViewDebug();

        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/error501.html";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, $output);
        $this->assertSame($expected, $output);
    }
}
