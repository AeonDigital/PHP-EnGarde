<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Security as Security;

require_once __DIR__ . "/../../phpunit.php";







class SecurityTest extends TestCase
{


    public function test_constructor_fail_datacookiename()
    {
        $fail = false;
        try {
            $obj = new Security(true, "", "", "", "", "");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"dataCookieName\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_securitycookiename()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "", "", "", "");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"securityCookieName\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_routetologin()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "", "", "");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"routeToLogin\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_routetostart()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "", "");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"routeToStart\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_routetoresetpassword()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "start", "");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("An active secure session must have a \"routeToResetPassword\" defined.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_anonymousid()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "start", "reset", 0);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("\"anonymousId\" must be a integer granther than zero.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_invalid_sessiontype()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "start", "reset", 1, "invalid");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Session type must be \"local\" or \"database\".", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_sessiontimeout()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "start", "reset",
                                1, "local", true, -1);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("\"sessionTimeout\" must be a integer equal or granther than zero.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_allowedfaultbyip()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "start", "reset",
                                1, "local", true, 10, -1);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("\"allowedFaultByIP\" must be a integer equal or granther than zero.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_ipblocktimeout()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "start", "reset",
                                1, "local", true, 10, 10, -1);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("\"ipBlockTimeout\" must be a integer equal or granther than zero.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_allowedfaultbylogin()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "start", "reset",
                                1, "local", true, 10, 10, 10, -1);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("\"allowedFaultByLogin\" must be a integer equal or granther than zero.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
    public function test_constructor_fail_loginblocktimeout()
    {
        $fail = false;
        try {
            $obj = new Security(true, "cname", "sname", "login", "start", "reset",
                                1, "local", true, 10, 10, 10, 10, -1);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("\"loginBlockTimeout\" must be a integer equal or granther than zero.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }



    public function test_constructor_ok()
    {
        $obj = new Security(true, "cname", "sname", "login", "start", "reset",
                            1, "local", true, 11, 12, 13, 14, 15);
        $this->assertTrue(is_a($obj, Security::class));

        $this->assertSame(true, $obj->isActive());
        $this->assertSame("cname", $obj->getDataCookieName());
        $this->assertSame("sname", $obj->getSecurityCookieName());
        $this->assertSame("login", $obj->getRouteToLogin());
        $this->assertSame("start", $obj->getRouteToStart());
        $this->assertSame("reset", $obj->getRouteToResetPassword());
        $this->assertSame(1, $obj->getAnonymousId());
        $this->assertSame("local", $obj->getSessionType());
        $this->assertSame(true, $obj->isSessionRenew());
        $this->assertSame(11, $obj->getSessionTimeout());
        $this->assertSame(12, $obj->getAllowedFaultByIP());
        $this->assertSame(13, $obj->getIPBlockTimeout());
        $this->assertSame(14, $obj->getAllowedFaultByLogin());
        $this->assertSame(15, $obj->getLoginBlockTimeout());
    }



    public function test_constructor_from_array()
    {
        $obj = Security::fromArray([
            "active"                => true,
            "dataCookieName"        => "cname",
            "securityCookieName"    => "sname",
            "routeToLogin"          => "login",
            "routeToStart"          => "start",
            "routeToResetPassword"  => "reset",
            "anonymousId"           => 1,
            "sessionType"           => "local",
            "sessionRenew"          => true,
            "sessionTimeout"        => 11,
            "allowedFaultByIP"      => 12,
            "ipBlockTimeout"        => 13,
            "allowedFaultByLogin"   => 14,
            "loginBlockTimeout"     => 15
        ]);
        $this->assertTrue(is_a($obj, Security::class));

        $this->assertSame(true, $obj->isActive());
        $this->assertSame("cname", $obj->getDataCookieName());
        $this->assertSame("sname", $obj->getSecurityCookieName());
        $this->assertSame("login", $obj->getRouteToLogin());
        $this->assertSame("start", $obj->getRouteToStart());
        $this->assertSame("reset", $obj->getRouteToResetPassword());
        $this->assertSame(1, $obj->getAnonymousId());
        $this->assertSame("local", $obj->getSessionType());
        $this->assertSame(true, $obj->isSessionRenew());
        $this->assertSame(11, $obj->getSessionTimeout());
        $this->assertSame(12, $obj->getAllowedFaultByIP());
        $this->assertSame(13, $obj->getIPBlockTimeout());
        $this->assertSame(14, $obj->getAllowedFaultByLogin());
        $this->assertSame(15, $obj->getLoginBlockTimeout());
    }
}
