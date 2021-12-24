<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Security as Security;

require_once __DIR__ . "/../../phpunit.php";







class ConfigSecurityTest extends TestCase
{


    public function test_constructor_ok()
    {
        global $defaultSecurity;
        $obj = new Security(
            $defaultSecurity["isActive"],
            $defaultSecurity["dataCookieName"],
            $defaultSecurity["securityCookieName"],
            $defaultSecurity["routeToLogin"],
            $defaultSecurity["routeToStart"],
            $defaultSecurity["routeToResetPassword"],
            $defaultSecurity["loginKeyNames"],
            $defaultSecurity["anonymousId"],
            $defaultSecurity["sessionNamespace"],
            $defaultSecurity["isSessionRenew"],
            $defaultSecurity["sessionTimeout"],
            $defaultSecurity["allowedFaultByIP"],
            $defaultSecurity["ipBlockTimeout"],
            $defaultSecurity["allowedFaultByLogin"],
            $defaultSecurity["loginBlockTimeout"],
            $defaultSecurity["allowedIPRanges"],
            $defaultSecurity["deniedIPRanges"]
        );
        $this->assertTrue(is_a($obj, Security::class));

        $this->assertSame(true, $obj->getIsActive());
        $this->assertSame("cname", $obj->getDataCookieName());
        $this->assertSame("sname", $obj->getSecurityCookieName());
        $this->assertSame("login", $obj->getRouteToLogin());
        $this->assertSame("start", $obj->getRouteToStart());
        $this->assertSame("reset", $obj->getRouteToResetPassword());
        $this->assertSame(["Login", "ShortLogin"], $obj->getLoginKeyNames());
        $this->assertSame(1, $obj->getAnonymousId());
        $this->assertSame("AeonDigital\\EnGarde\\SessionControl\\NativeLocal", $obj->getSessionNamespace());
        $this->assertSame(true, $obj->getIsSessionRenew());
        $this->assertSame(40, $obj->getSessionTimeout());
        $this->assertSame(50, $obj->getAllowedFaultByIP());
        $this->assertSame(50, $obj->getIPBlockTimeout());
        $this->assertSame(5, $obj->getAllowedFaultByLogin());
        $this->assertSame(20, $obj->getLoginBlockTimeout());
        $this->assertSame([], $obj->getAllowedIPRanges());
        $this->assertSame([], $obj->getDeniedIPRanges());
    }



    public function test_constructor_fail_datacookiename()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["dataCookieName"] = "";

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"dataCookieName\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_securitycookiename()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["securityCookieName"] = "";

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"securityCookieName\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_routetologin()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["routeToLogin"] = "";

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"routeToLogin\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_routetostart()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["routeToStart"] = "";

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"routeToStart\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_routetoresetpassword()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["routeToResetPassword"] = "";

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"routeToResetPassword\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_anonymousid()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["anonymousId"] = -1;

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"anonymousId\". Expected integer greather than zero. Given: [ -1 ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_invalid_sessionNamespace()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["sessionNamespace"] = "invalid";

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"sessionNamespace\". Expected Namespace of class thats implements the interface AeonDigital\EnGarde\Interfaces\Engine\iSession. Given: [ invalid ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_sessiontimeout()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["sessionTimeout"] = -1;

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"sessionTimeout\". Expected integer greather than zero. Given: [ -1 ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_allowedfaultbyip()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["allowedFaultByIP"] = -1;

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"allowedFaultByIP\". Expected integer greather than zero. Given: [ -1 ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_ipblocktimeout()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["ipBlockTimeout"] = -1;

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"ipBlockTimeout\". Expected integer greather than zero. Given: [ -1 ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_allowedfaultbylogin()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["allowedFaultByLogin"] = -1;

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"allowedFaultByLogin\". Expected integer greather than zero. Given: [ -1 ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_fail_loginblocktimeout()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["loginBlockTimeout"] = -1;

        $fail = false;
        try {
            $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"loginBlockTimeout\". Expected integer greather than zero. Given: [ -1 ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }





    public function test_isallowedip()
    {
        global $defaultSecurity;
        $testSecurity = array_merge([], $defaultSecurity);
        $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);

        $this->assertTrue($obj->isAllowedIP("10.0.0.0"));
        $this->assertTrue($obj->isAllowedIP("10.0.0.1"));
        $this->assertTrue($obj->isAllowedIP("10.0.5.128"));
        $this->assertTrue($obj->isAllowedIP("10.0.10.0"));
        $this->assertTrue($obj->isAllowedIP("10.0.10.1"));


        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:000E:FFFF"));
        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:000F:0000"));
        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:0ABC:6666"));
        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:F000:0000"));
        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:F000:0001"));





        // -----
        $testSecurity["allowedIPRanges"] = [
            ["10.0.0.1", "10.0.10.0"],
            ["0000:0000:0000:0000:0000:0000:000F:0000", "0000:0000:0000:0000:0000:0000:F000:0000"]
        ];


        $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        $this->assertEquals(
            [
                ["10.0.0.1", "10.0.10.0"],
                ["0000:0000:0000:0000:0000:0000:000F:0000", "0000:0000:0000:0000:0000:0000:F000:0000"]
            ],
            $obj->getAllowedIPRanges()
        );

        $this->assertFalse($obj->isAllowedIP("10.0.0.0"));
        $this->assertTrue($obj->isAllowedIP("10.0.0.1"));
        $this->assertTrue($obj->isAllowedIP("10.0.5.128"));
        $this->assertTrue($obj->isAllowedIP("10.0.10.0"));
        $this->assertFalse($obj->isAllowedIP("10.0.10.1"));


        $this->assertFalse($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:000E:FFFF"));
        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:000F:0000"));
        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:0ABC:6666"));
        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:F000:0000"));
        $this->assertFalse($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:F000:0001"));





        // -----
        $testSecurity = array_merge([], $defaultSecurity);
        $testSecurity["deniedIPRanges"] = [
            ["10.0.0.1", "10.0.10.0"],
            ["0000:0000:0000:0000:0000:0000:000F:0000", "0000:0000:0000:0000:0000:0000:F000:0000"]
        ];


        $obj = prov_instanceOf_EnGarde_Config_Security($testSecurity);
        $this->assertEquals(
            [
                ["10.0.0.1", "10.0.10.0"],
                ["0000:0000:0000:0000:0000:0000:000F:0000", "0000:0000:0000:0000:0000:0000:F000:0000"]
            ],
            $obj->getDeniedIPRanges()
        );

        $this->assertTrue($obj->isAllowedIP("10.0.0.0"));
        $this->assertFalse($obj->isAllowedIP("10.0.0.1"));
        $this->assertFalse($obj->isAllowedIP("10.0.5.128"));
        $this->assertFalse($obj->isAllowedIP("10.0.10.0"));
        $this->assertTrue($obj->isAllowedIP("10.0.10.1"));


        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:000E:FFFF"));
        $this->assertFalse($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:000F:0000"));
        $this->assertFalse($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:0ABC:6666"));
        $this->assertFalse($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:F000:0000"));
        $this->assertTrue($obj->isAllowedIP("0000:0000:0000:0000:0000:0000:F000:0001"));
    }
}
