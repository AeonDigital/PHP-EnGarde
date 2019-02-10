<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\DomainManager as DomainManager;

require_once __DIR__ . "/../phpunit.php";







class DomainApplicationTest extends TestCase
{





    public function test_check_response_to_error_404()
    {
        $domainManager = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet("localtest", "GET", "/non-exist-route/for/this");
        $domainManager->run();
        $output = $domainManager->getTestViewDebug();

        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/error404.html";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, $output);
        $this->assertSame($expected, $output);
    }



    public function test_check_response_to_error_501()
    {
        $domainManager = provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet("testview", "PUT", "/");
        $domainManager->run();
        $output = $domainManager->getTestViewDebug();

        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "expectedresponses/error501.html";
        $expected           = file_get_contents($tgtPathToExpected);

        //file_put_contents($tgtPathToExpected, $output);
        $this->assertSame($expected, $output);
    }
}
