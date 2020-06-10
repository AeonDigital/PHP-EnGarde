<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\SessionControl\NativeLocal as NativeLocal;

require_once __DIR__ . "/../phpunit.php";







class SessionNativeTest extends TestCase
{

    protected string $pathToLocalData                   = "";
    protected string $pathToLocalData_Log               = "";
    protected string $pathToLocalData_Users             = "";
    protected string $pathToLocalData_Sessions          = "";
    protected string $pathToLocalData_LogSuspect        = "";
    protected string $pathToLocalData_LogFile_SuspectIP = "";



    protected function provideObject()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $securityConfig = prov_instanceOf_EnGarde_Config_Security($defaultSecurity);
        $securityCookie = new \AeonDigital\Http\Data\Cookie(
            $defaultSecurity["securityCookieName"], "", null,
            $defaultServerVariables["HTTP_HOST"], "/",
            $defaultEngineVariables["forceHTTPS"], true
        );
        $pathToLocalData = to_system_path(
            $defaultApplication["appRootPath"] . $defaultApplication["pathToLocalData"]
        );
        $this->pathToLocalData          = $pathToLocalData;
        $this->pathToLocalData_Log      = $this->pathToLocalData . DS . "log";
        $this->pathToLocalData_Users    = $this->pathToLocalData . DS . "users";
        $this->pathToLocalData_Sessions = $this->pathToLocalData . DS . "sessions";

        $fileSuspectIP = \str_replace([".", ":"], "_", $defaultServerVariables["REMOTE_ADDR"]) . ".json";
        $this->pathToLocalData_LogSuspect = $this->pathToLocalData_Log . DS . "suspect";
        $this->pathToLocalData_LogFile_SuspectIP = $this->pathToLocalData_LogSuspect . DS . $fileSuspectIP;


        return new NativeLocal(
            new \DateTime("2020-06-08 01:00:00"),
            $defaultEngineVariables["environmentType"],
            $defaultApplication["appName"],
            $defaultServerVariables["HTTP_USER_AGENT"],
            $defaultServerVariables["REMOTE_ADDR"],
            $securityConfig,
            $securityCookie,
            $pathToLocalData
        );
    }


    protected function provideUserObject()
    {
        return [
            "Active"        => true,
            "RegisterDate"  => "2020-06-03 22:00:00",
            "Name"          => "Rianna Cantarelli",
            "Gender"        => "Transgender",
            "Login"         => "rianna.aeon",
            "ShortLogin"    => "rianna.aeon",
            "Password"      => "31f88741c850331188d23e6e0067730e13c92809",
            "ContactEmail"  => "rianna.aeon@gmail.com",
            "SessionHash"   => "aa0c3200c73a09b3f17baf8f3f81ed7a7dde967a",
            "Profiles" => [
                [
                    "Active"        => true,
                    "Profile"       => "PROFILE01",
                    "Application"   => "site",
                    "UseConnection" =>  null,
                    "Political"     => "B",
                    "Default"       => false
                ],
                [
                    "Active"        => true,
                    "Profile"       => "PROFILE02",
                    "Application"   => "site",
                    "UseConnection" => null,
                    "Political"     => "F",
                    "Default"       => true
                ]
            ]
        ];
    }


    protected function provideSessionObject()
    {
        return [
	        "SessionHash" => "aa0c3200c73a09b3f17baf8f3f81ed7a7dde967a",
	        "ApplicationName" => "site",
	        "LoginDate" => "2020-06-08 16:49:20",
	        "SessionTimeOut" => "2020-06-08 17:29:20",
	        "SessionRenew" => true,
	        "Login" => "rianna.aeon",
	        "ProfileInUse" => "SUPERADMIN",
	        "UserAgent" => "UA",
	        "UserAgentIP" => "192.168.1.17"
        ];
    }


    protected function provideSuspectActivityObject()
    {
        return [
            "Activity"          => "MakeLogin",
            "IP"                => "192.168.1.17",
            "Login"             => "rianna.aeon",
            "Counter"           => 1,
            "LastEventDateTime" => "2020-06-08 01:00:00",
            "Blocked"           => false,
            "UnblockDate"       => null
        ];
    }






    public function test_constructor_ok()
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $securityConfig = prov_instanceOf_EnGarde_Config_Security($defaultSecurity);
        $securityCookie = new \AeonDigital\Http\Data\Cookie(
            $defaultSecurity["securityCookieName"], "", null,
            $defaultServerVariables["HTTP_HOST"], "/",
            $defaultEngineVariables["forceHTTPS"], true
        );
        $pathToLocalData = to_system_path(
            $defaultApplication["appRootPath"] . $defaultApplication["pathToLocalData"]
        );


        $obj = new NativeLocal(
            new \DateTime("2020-06-08 01:00:00"),
            $defaultEngineVariables["environmentType"],
            $defaultApplication["appName"],
            $defaultServerVariables["HTTP_USER_AGENT"],
            $defaultServerVariables["REMOTE_ADDR"],
            $securityConfig,
            $securityCookie,
            $pathToLocalData
        );
        $this->assertTrue(is_a($obj, NativeLocal::class));
        $this->assertEquals("NativeLocal", $obj->retrieveSessionType());
        $this->assertEquals($securityCookie, $obj->retrieveSecurityCookie());
        $this->assertEquals($pathToLocalData, $obj->retrievePathToLocalData());
        $this->assertNull($obj->retrieveAuthenticatedSession());
        $this->assertNull($obj->retrieveAuthenticatedUser());
        $this->assertNull($obj->retrieveAuthenticatedUserProfile());
        $this->assertNull($obj->retrieveAuthenticatedUserProfiles());
        $this->assertEquals("Unchecked", $obj->retrieveBrowseStatus());
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
    }




    public function test_method_executeLogin()
    {
        $obj = $this->provideObject();
        $this->assertEquals("Unchecked", $obj->retrieveBrowseStatus());
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());

        $this->assertTrue($obj->executeLogin("rianna.aeon", "senhateste"));
    }




    /*
    public function test_method_executeLogin_checkUserAgentIP()
    {
        $obj = $this->provideObject();

        // Verifica um ip de user agent bloqueado
        $suspect = $this->provideSuspectActivityObject();
        $suspect["Counter"] = 50;
        $suspect["Blocked"] = true;
        $suspect["UnblockDate"] = "2020-06-08 01:00:01";

        \AeonDigital\Tools\JSON::save(
            $this->pathToLocalData_LogFile_SuspectIP,
            $suspect
        );

        $this->assertFalse($obj->executeLogin("nonexist", "wrong"));
        $this->assertEquals("UserAgentIPBlocked", $obj->retrieveSecurityStatus());



        // Verifica se ignora um bloqueio já finalizado e então elimina o registro...
        // um novo será criado devido a falha de login, mas o contador iniciará do 1
        $suspect["Counter"] = 50;
        $suspect["Blocked"] = true;
        $suspect["UnblockDate"] = "2020-06-08 00:59:59";

        \AeonDigital\Tools\JSON::save(
            $this->pathToLocalData_LogFile_SuspectIP,
            $suspect
        );

        $this->assertFalse($obj->executeLogin("nonexist", "wrong"));
        $suspect = \AeonDigital\Tools\JSON::retrieve($this->pathToLocalData_LogFile_SuspectIP);
        $this->assertEquals(1, $suspect["Counter"]);
        $this->assertEquals(false, $suspect["Blocked"]);
        $this->assertEquals("UserAccountDoesNotExist", $obj->retrieveSecurityStatus());
    }


    public function test_method_executeLogin_loadAuthenticatedUser()
    {
        $obj = $this->provideObject();


        file_put_contents(
            $this->pathToLocalData_Users . DS . "unchecked.json", "..."
        );
        unlink($this->pathToLocalData_LogFile_SuspectIP);
        $this->assertFalse($obj->executeLogin("nonexist", "wrong"));
        $this->assertEquals("UserAccountDoesNotExist", $obj->retrieveSecurityStatus());

        $user["Login"] = "unchecked";
    }


    /*
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
    */

}
