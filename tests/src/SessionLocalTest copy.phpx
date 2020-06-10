<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\SessionControl\Local as Local;

require_once __DIR__ . "/../phpunit.php";







class SessionLocalTest extends TestCase
{



    protected function provideSessionObject()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $pathToLocalData = to_system_path($defaultApplication["appRootPath"] . $defaultApplication["pathToLocalData"]);
        $securityCookie = new \AeonDigital\Http\Data\Cookie(
            $defaultSecurity["securityCookieName"],
            "ProfileInUse=SUPERADMIN",
            null,
            $defaultServerVariables["HTTP_HOST"],
            "/",
            $defaultEngineVariables["forceHTTPS"],
            true
        );

        $obj = new Local();
        $obj->setUASecurityData([
            "IP"                    => "192.168.1.17",
            "SecurityCookie"        => $securityCookie,
            "PathToLocalData"       => $pathToLocalData,
            "Now"                   => new DateTime(),
            "Environment"           => "UTEST",
            "ApplicationName"       => "site",
            "UserAgent"             => "UA",
            "SessionRenew"          => true,
            "SessionTimeout"        => 40,
            "AllowedFaultByIP"      => 5,
            "IPBlockTimeout"        => 50,
            "AllowedFaultByLogin"   => 3,
            "LoginBlockTimeout"     => 20,
        ]);

        return $obj;
    }





    public function test_constructor_ok()
    {
        $obj = new Local();
        $this->assertTrue(is_a($obj, Local::class));
    }


    public function test_method_setUASecurityData_fail()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $pathToLocalData = to_system_path($defaultApplication["appRootPath"] . $defaultApplication["pathToLocalData"]);
        $securityCookie = new \AeonDigital\Http\Data\Cookie(
            $defaultSecurity["securityCookieName"],
            "ProfileInUse=SUPERADMIN",
            null,
            $defaultServerVariables["HTTP_HOST"],
            "/",
            $defaultEngineVariables["forceHTTPS"],
            true
        );
        $Now = new DateTime();



        $fail = false;
        try {
            $obj = new Local();
            $obj->setUASecurityData([1]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"uaSecurityData\". Expected an assoc array with the keys \"IP, SecurityCookie, PathToLocalData, Now, Environment, ApplicationName, UserAgent, SessionRenew, SessionTimeout, AllowedFaultByIP, IPBlockTimeout, AllowedFaultByLogin, LoginBlockTimeout\".",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");


        $fail = false;
        try {
            $obj = new Local();
            $obj->setUASecurityData([
                "IP"                    => "",
                "SecurityCookie"        => $securityCookie,
                "PathToLocalData"       => $pathToLocalData,
                "Now"                   => $Now,
                "Environment"           => "UTEST",
                "ApplicationName"       => "site",
                "UserAgent"             => "UA",
                "SessionRenew"          => true,
                "SessionTimeout"        => 40,
                "AllowedFaultByIP"      => 50,
                "IPBlockTimeout"        => 50,
                "AllowedFaultByLogin"   => 5,
                "LoginBlockTimeout"     => 20,
            ]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"uaSecurityData['IP']\". Expected non empty string.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");


        $fail = false;
        try {
            $obj = new Local();
            $obj->setUASecurityData([
                "IP"                    => "192.168.1.17",
                "SecurityCookie"        => "",
                "PathToLocalData"       => $pathToLocalData,
                "Now"                   => $Now,
                "Environment"           => "UTEST",
                "ApplicationName"       => "site",
                "UserAgent"             => "UA",
                "SessionRenew"          => true,
                "SessionTimeout"        => 40,
                "AllowedFaultByIP"      => 50,
                "IPBlockTimeout"        => 50,
                "AllowedFaultByLogin"   => 5,
                "LoginBlockTimeout"     => 20,
            ]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"uaSecurityData['SecurityCookie']\". Expected Namespace of class thats implements the interface AeonDigital\Interfaces\Http\Data\iCookie.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");


        $fail = false;
        try {
            $obj = new Local();
            $obj->setUASecurityData([
                "IP"                    => "192.168.1.17",
                "SecurityCookie"        => $securityCookie,
                "PathToLocalData"       => $pathToLocalData . "invalid",
                "Now"                   => $Now,
                "Environment"           => "UTEST",
                "ApplicationName"       => "site",
                "UserAgent"             => "UA",
                "SessionRenew"          => true,
                "SessionTimeout"        => 40,
                "AllowedFaultByIP"      => 50,
                "IPBlockTimeout"        => 50,
                "AllowedFaultByLogin"   => 5,
                "LoginBlockTimeout"     => 20,
            ]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"uaSecurityData['PathToLocalData']\". Directory does not exists. Given: [ E:\\Projetos\\Open Source\\PHP-EnGarde\\tests\\resources\\apps\\site\\localDatainvalid ]",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");


        $fail = false;
        try {
            $obj = new Local();
            $obj->setUASecurityData([
                "IP"                    => "192.168.1.17",
                "SecurityCookie"        => $securityCookie,
                "PathToLocalData"       => $pathToLocalData,
                "Now"                   => "",
                "Environment"           => "UTEST",
                "ApplicationName"       => "site",
                "UserAgent"             => "UA",
                "SessionRenew"          => true,
                "SessionTimeout"        => 40,
                "AllowedFaultByIP"      => 50,
                "IPBlockTimeout"        => 50,
                "AllowedFaultByLogin"   => 5,
                "LoginBlockTimeout"     => 20,
            ]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame(
                "Invalid value defined for \"uaSecurityData['Now']\". Expected Namespace of class thats implements the interface DateTimeInterface.",
                $ex->getMessage()
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }



    public function test_method_setUASecurityData()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $pathToLocalData = to_system_path($defaultApplication["appRootPath"] . $defaultApplication["pathToLocalData"]);
        $securityCookie = new \AeonDigital\Http\Data\Cookie(
            $defaultSecurity["securityCookieName"],
            "ProfileInUse=SUPERADMIN",
            null,
            $defaultServerVariables["HTTP_HOST"],
            "/",
            $defaultEngineVariables["forceHTTPS"],
            true
        );
        $Now = new DateTime();


        $obj = new Local();
        $obj->setUASecurityData([
            "IP"                    => "192.168.1.17",
            "SecurityCookie"        => $securityCookie,
            "PathToLocalData"       => $pathToLocalData,
            "Now"                   => new DateTime(),
            "Environment"           => "UTEST",
            "ApplicationName"       => "site",
            "UserAgent"             => "UA",
            "SessionRenew"          => true,
            "SessionTimeout"        => 40,
            "AllowedFaultByIP"      => 50,
            "IPBlockTimeout"        => 50,
            "AllowedFaultByLogin"   => 5,
            "LoginBlockTimeout"     => 20,
        ]);

        $this->assertTrue(true);
    }


    public function test_method_loadUserData()
    {
        $obj = $this->provideSessionObject();

        $this->assertNull($obj->retrieveUserData());
        $this->assertFalse($obj->loadUserData("nonexists"));
        $this->assertNull($obj->retrieveUserData());

        $this->assertTrue($obj->loadUserData("rianna.aeon"));
        $this->assertNotNull($obj->retrieveUserData());
    }


    public function test_method_checkUserName()
    {
        global $defaultApplication;
        $pathToLocalData_Log = to_system_path(
            $defaultApplication["appRootPath"] .
            $defaultApplication["pathToLocalData"] .
            "\\log\\suspect");

        $fileIP = \str_replace([".", ":"], "_", "192.168.1.17") . ".json";
        $pathToLocalData_LogFile_IP = $pathToLocalData_Log . DS . $fileIP;

        if (file_exists($pathToLocalData_LogFile_IP) === true) {
            unlink($pathToLocalData_LogFile_IP);
        }


        $fileUserName = \mb_str_to_valid_filename(\strtolower("rianna.aeon")) . ".json";
        $pathToLocalData_LogFile_UserName = $pathToLocalData_Log . DS . $fileUserName;

        if (file_exists($pathToLocalData_LogFile_UserName) === true) {
            unlink($pathToLocalData_LogFile_UserName);
        }




        $obj = $this->provideSessionObject();
        $this->assertFalse(file_exists($pathToLocalData_LogFile_IP));
        $this->assertEquals("Anonimous", $obj->retrieveLoginStatus());
        $this->assertFalse($obj->checkUserName("invalidlogin"));
        $this->assertTrue(file_exists($pathToLocalData_LogFile_IP));

        $ipSuspectData = \AeonDigital\Tools\JSON::retrieve($pathToLocalData_LogFile_IP);
        $this->assertNotNull($ipSuspectData);
        $this->assertEquals(1, $ipSuspectData["Counter"]);


        for ($i = 2; $i < 5; $i++) {
            $this->assertFalse($obj->checkUserName("invalidlogin"));
            $ipSuspectData = \AeonDigital\Tools\JSON::retrieve($pathToLocalData_LogFile_IP);
            $this->assertEquals($i, $ipSuspectData["Counter"]);
        }

        // Estraga o json
        file_put_contents($pathToLocalData_LogFile_IP, "...");
        $ipSuspectData = \AeonDigital\Tools\JSON::retrieve($pathToLocalData_LogFile_IP);
        $this->assertNull($ipSuspectData);

        for ($i = 1; $i < 5; $i++) {
            $this->assertFalse($obj->checkUserName("invalidlogin"));
            $ipSuspectData = \AeonDigital\Tools\JSON::retrieve($pathToLocalData_LogFile_IP);
            $this->assertEquals($i, $ipSuspectData["Counter"]);
            $this->assertFalse($ipSuspectData["Blocked"]);
        }

        $this->assertFalse($obj->checkUserName("invalidlogin"));
        $this->assertEquals("YourIPIsBlocked", $obj->retrieveLoginStatus());

        $this->assertFalse($obj->checkUserName("user_disabled_in_domain"));
        $this->assertEquals("AccountDisabledForDomain", $obj->retrieveLoginStatus());

        $this->assertFalse($obj->checkUserName("user_noeexist_in_application"));
        $this->assertEquals("AccountDoesNotExistInApplication", $obj->retrieveLoginStatus());

        $this->assertFalse($obj->checkUserName("user_disabled_in_application"));
        $this->assertEquals("AccountDisabledForApplication", $obj->retrieveLoginStatus());

        $this->assertTrue($obj->checkUserName("rianna.aeon"));
        $this->assertEquals("AccountRecognizedAndActive", $obj->retrieveLoginStatus());
    }


    public function test_method_checkValidIP()
    {
        global $defaultApplication;
        $pathToLocalData_Log = to_system_path(
            $defaultApplication["appRootPath"] .
            $defaultApplication["pathToLocalData"] .
            "\\log\\suspect");

        $fileIP = \str_replace([".", ":"], "_", "192.168.1.17") . ".json";
        $pathToLocalData_LogFile_IP = $pathToLocalData_Log . DS . $fileIP;

        if (file_exists($pathToLocalData_LogFile_IP) === true) {
            unlink($pathToLocalData_LogFile_IP);
        }

        $obj = $this->provideSessionObject();
        $this->assertFalse(file_exists($pathToLocalData_LogFile_IP));
        $this->assertEquals("Anonimous", $obj->retrieveLoginStatus());
        $this->assertEquals("Unchecked", $obj->retrieveBrowseStatus());
        $this->assertTrue($obj->checkValidIP());


        for ($i = 1; $i < 5; $i++) {
            $this->assertFalse($obj->checkUserName("invalidlogin"));
            $this->assertTrue($obj->checkValidIP());
        }

        $this->assertFalse($obj->checkUserName("invalidlogin"));
        $this->assertFalse($obj->checkValidIP());
        $this->assertEquals("BlockedIP", $obj->retrieveLoginStatus());
        $this->assertEquals("BlockedIP", $obj->retrieveBrowseStatus());
    }


    public function test_method_checkUserPassword()
    {
        global $defaultApplication;
        $pathToLocalData_Log = to_system_path(
            $defaultApplication["appRootPath"] .
            $defaultApplication["pathToLocalData"] .
            "\\log\\suspect");

        $fileUserName = \mb_str_to_valid_filename(\strtolower("rianna.aeon")) . ".json";
        $pathToLocalData_LogFile_UserName = $pathToLocalData_Log . DS . $fileUserName;

        if (file_exists($pathToLocalData_LogFile_UserName) === true) {
            unlink($pathToLocalData_LogFile_UserName);
        }

        $obj = $this->provideSessionObject();
        $this->assertFalse(file_exists($pathToLocalData_LogFile_UserName));
        $this->assertEquals("Anonimous", $obj->retrieveLoginStatus());
        $this->assertEquals("Unchecked", $obj->retrieveBrowseStatus());
        $this->assertTrue($obj->checkUserName("rianna.aeon"));
        $this->assertEquals("AccountRecognizedAndActive", $obj->retrieveLoginStatus());
        $this->assertTrue($obj->checkUserPassword(sha1("senhateste")));


        for ($i = 1; $i < 5; $i++) {
            $this->assertFalse($obj->checkUserPassword("invalidpass"));
            $this->assertEquals("UnexpectedPassword", $obj->retrieveLoginStatus());
        }

        $this->assertFalse($obj->checkUserPassword("invalidpass"));
        $this->assertEquals("AccountIsBlocked", $obj->retrieveLoginStatus());
    }



    public function test_method_inityclose_AuthenticatedSession()
    {
        global $defaultApplication;
        $pathToLocalData_Log = to_system_path(
            $defaultApplication["appRootPath"] .
            $defaultApplication["pathToLocalData"] .
            "\\log\\suspect");

        $fileIP = \str_replace([".", ":"], "_", "192.168.1.17") . ".json";
        $pathToLocalData_LogFile_IP = $pathToLocalData_Log . DS . $fileIP;

        if (file_exists($pathToLocalData_LogFile_IP) === true) {
            unlink($pathToLocalData_LogFile_IP);
        }


        $fileUserName = \mb_str_to_valid_filename(\strtolower("rianna.aeon")) . ".json";
        $pathToLocalData_LogFile_UserName = $pathToLocalData_Log . DS . $fileUserName;

        if (file_exists($pathToLocalData_LogFile_UserName) === true) {
            unlink($pathToLocalData_LogFile_UserName);
        }


        $obj = $this->provideSessionObject();
        $this->assertEquals("Anonimous", $obj->retrieveLoginStatus());
        $this->assertEquals("Unchecked", $obj->retrieveBrowseStatus());
        $this->assertTrue($obj->checkUserName("rianna.aeon"));
        $this->assertEquals("AccountRecognizedAndActive", $obj->retrieveLoginStatus());
        $this->assertTrue($obj->checkUserPassword(sha1("senhateste")));
        $this->assertEquals("WaitingApplicationAuthenticate", $obj->retrieveLoginStatus());

        $this->assertTrue($obj->inityAuthenticatedSession());
    }

}
