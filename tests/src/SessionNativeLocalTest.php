<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\SessionControl\NativeLocal as NativeLocal;

require_once __DIR__ . "/../phpunit.php";







class SessionNativeTest extends TestCase
{

    protected string $pathToLocalData                       = "";
    protected string $pathToLocalData_Log                   = "";
    protected string $pathToLocalData_Users                 = "";
    protected string $pathToLocalData_Sessions              = "";
    protected string $pathToLocalData_LogSuspect            = "";
    protected string $pathToLocalData_LogFile_Session       = "";
    protected string $pathToLocalData_LogFile_SuspectIP     = "";
    protected string $pathToLocalData_LogFile_SuspectLogin  = "";


    protected function provideObject($withSession = false)
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $sessionHash = "bb2ea0c1cac4da36fbe4ffb38598335d7a33cf71";

        $securityConfig = prov_instanceOf_EnGarde_Config_Security($defaultSecurity);
        $securityCookie = new \AeonDigital\Http\Data\Cookie(
            $defaultSecurity["securityCookieName"],
            (($withSession === true) ? $sessionHash : ""), null,
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

        $this->pathToLocalData_LogFile_Session = $this->pathToLocalData_Sessions . DS . $sessionHash . ".json";

        $fileSuspectIP = \str_replace([".", ":"], "_", $defaultServerVariables["REMOTE_ADDR"]) . ".json";
        $this->pathToLocalData_LogSuspect = $this->pathToLocalData_Log . DS . "suspect";
        $this->pathToLocalData_LogFile_SuspectIP = $this->pathToLocalData_LogSuspect . DS . $fileSuspectIP;

        $fileUserLogin = \mb_str_to_valid_filename(\strtolower("rianna.aeon")) . ".json";
        $this->pathToLocalData_LogFile_SuspectLogin = $this->pathToLocalData_LogSuspect . DS . $fileUserLogin;


        return new NativeLocal(
            new \DateTime("2020-06-08 01:00:00"),
            $defaultEngineVariables["environmentType"],
            $defaultApplication["appName"],
            $defaultServerVariables["HTTP_USER_AGENT"],
            $defaultServerVariables["REMOTE_ADDR"],
            $securityConfig,
            $securityCookie,
            $pathToLocalData,
            []
        );
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
            $pathToLocalData,
            []
        );
        $this->assertTrue(is_a($obj, NativeLocal::class));
        $this->assertEquals($securityCookie, $obj->retrieveSecurityCookie());
        $this->assertEquals($pathToLocalData, $obj->retrievePathToLocalData());
        $this->assertNull($obj->retrieveSession());
        $this->assertNull($obj->retrieveUser());
        $this->assertNull($obj->retrieveUserProfile());
        $this->assertNull($obj->retrieveUserProfiles());
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
    }




    public function test_method_executeLogin_executeLogout()
    {
        $obj = $this->provideObject();
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        if (file_exists($this->pathToLocalData_LogFile_SuspectIP) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectIP);
        }
        if (file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectLogin);
        }



        $r = $obj->executeLogin("rianna.aeon", sha1("senhateste"));

        $authenticatedSession = \AeonDigital\Tools\JSON::retrieve(
            $this->pathToLocalData_LogFile_Session
        );
        $authenticatedUser = \AeonDigital\Tools\JSON::retrieve(
            $this->pathToLocalData_Users . DS . $authenticatedSession["DomainUser"] . ".json"
        );

        $this->assertEquals($authenticatedSession, $obj->retrieveSession());
        $this->assertEquals($authenticatedUser, $obj->retrieveUser());
        $this->assertEquals("Administrador", $obj->retrieveUserProfile());
        $this->assertTrue(is_array($obj->retrieveUserProfiles()));
        $this->assertEquals("UserSessionAuthenticated", $obj->retrieveSecurityStatus());
        $this->assertTrue($r);


        $this->assertTrue(file_exists($this->pathToLocalData_LogFile_Session));
        $r = $obj->executeLogout();
        $this->assertFalse(file_exists($this->pathToLocalData_LogFile_Session));
        $this->assertNull($obj->retrieveSession());
        $this->assertNull($obj->retrieveUser());
        $this->assertNull($obj->retrieveUserProfile());
        $this->assertNull($obj->retrieveUserProfiles());
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        $this->assertTrue($r);
    }


    public function test_method_executeLogin_UserAccountUnexpectedPassword()
    {
        $obj = $this->provideObject();
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        if (file_exists($this->pathToLocalData_LogFile_SuspectIP) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectIP);
        }
        if (file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectLogin);
        }



        $r = $obj->executeLogin("rianna.aeon", sha1("senhaerrada"));

        $this->assertNull($obj->retrieveSession());
        $this->assertNull($obj->retrieveUser());
        $this->assertNull($obj->retrieveUserProfile());
        $this->assertNull($obj->retrieveUserProfiles());
        $this->assertEquals("UserAccountUnexpectedPassword", $obj->retrieveSecurityStatus());
        $this->assertFalse($r);
    }


    public function test_method_executeLogin_UserAccountHasBeenBlocked()
    {
        $obj = $this->provideObject();
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        if (file_exists($this->pathToLocalData_LogFile_SuspectIP) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectIP);
        }
        if (file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectLogin);
        }



        for ($i=0; $i<4; $i++) {
            $this->assertFalse($obj->executeLogin("rianna.aeon", sha1("senhaerrada")));
            $this->assertEquals("UserAccountUnexpectedPassword", $obj->retrieveSecurityStatus());
        }
        $this->assertFalse($obj->executeLogin("rianna.aeon", sha1("senhaerrada")));
        $this->assertEquals("UserAccountHasBeenBlocked", $obj->retrieveSecurityStatus());

        $this->assertFalse($obj->executeLogin("rianna.aeon", sha1("senhaerrada")));
        $this->assertEquals("UserAccountIsBlocked", $obj->retrieveSecurityStatus());
    }


    public function test_method_executeLogin_UserAccountDoesNotExist()
    {
        $obj = $this->provideObject();
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        if (file_exists($this->pathToLocalData_LogFile_SuspectIP) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectIP);
        }
        if (file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectLogin);
        }



        $suspect = $this->provideSuspectActivityObject();
        $suspect["Counter"] = 50;
        $suspect["Blocked"] = true;
        $suspect["UnblockDate"] = "2020-06-08 01:00:01";

        \AeonDigital\Tools\JSON::save(
            $this->pathToLocalData_LogFile_SuspectIP,
            $suspect
        );
        $this->assertFalse($obj->executeLogin("inexistente", "senhaerrada"));
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

        $this->assertFalse($obj->executeLogin("inexistente", "senhaerrada"));
        $suspect = \AeonDigital\Tools\JSON::retrieve($this->pathToLocalData_LogFile_SuspectIP);
        $this->assertEquals(1, $suspect["Counter"]);
        $this->assertEquals(false, $suspect["Blocked"]);
        $this->assertEquals("UserAccountDoesNotExist", $obj->retrieveSecurityStatus());
    }





    public function test_method_checkUserAgentSession()
    {
        $obj = $this->provideObject();
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        if (file_exists($this->pathToLocalData_LogFile_SuspectIP) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectIP);
        }
        if (file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectLogin);
        }



        $this->assertTrue($obj->executeLogin("rianna.aeon", sha1("senhateste")));



        $obj = $this->provideObject(true);
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        $r = $obj->checkUserAgentSession();
        $this->assertEquals("UserSessionAuthenticated", $obj->retrieveSecurityStatus());

        $authenticatedSession = \AeonDigital\Tools\JSON::retrieve(
            $this->pathToLocalData_LogFile_Session
        );
        $authenticatedUser = \AeonDigital\Tools\JSON::retrieve(
            $this->pathToLocalData_Users . DS . $authenticatedSession["DomainUser"] . ".json"
        );

        $this->assertEquals($authenticatedSession, $obj->retrieveSession());
        $this->assertEquals($authenticatedUser, $obj->retrieveUser());
        $this->assertEquals("Administrador", $obj->retrieveUserProfile());
        $this->assertTrue(is_array($obj->retrieveUserProfiles()));
        $this->assertEquals("UserSessionAuthenticated", $obj->retrieveSecurityStatus());
        $this->assertTrue($r);
    }





    public function test_method_grantPermission()
    {
        $obj = $this->provideObject();
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        if (file_exists($this->pathToLocalData_LogFile_SuspectIP) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectIP);
        }
        if (file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectLogin);
        }



        $this->assertTrue($obj->executeLogin("rianna.aeon", sha1("senhateste")));
        $authenticatedSession = \AeonDigital\Tools\JSON::retrieve(
            $this->pathToLocalData_LogFile_Session
        );
        $this->assertNotNull($authenticatedSession);
        $this->assertNull($authenticatedSession["GrantPermission"]);


        $obj = $this->provideObject();
        $this->assertTrue(
            $obj->executeLogin(
                "rianna.aeon",
                sha1("senhateste"),
                "specialPermission",
                "bb2ea0c1cac4da36fbe4ffb38598335d7a33cf71"
            )
        );

        $authenticatedSession = \AeonDigital\Tools\JSON::retrieve(
            $this->pathToLocalData_LogFile_Session
        );
        $this->assertNotNull($authenticatedSession);
        $this->assertEquals("specialPermission", $authenticatedSession["GrantPermission"]);
    }





    public function test_method_changeUserProfile()
    {
        $obj = $this->provideObject();
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        if (file_exists($this->pathToLocalData_LogFile_SuspectIP) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectIP);
        }
        if (file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectLogin);
        }



        $this->assertTrue($obj->executeLogin("rianna.aeon", sha1("senhateste")));



        $this->assertEquals("Administrador", $obj->retrieveUserProfile());
        $this->assertTrue($obj->changeUserProfile("Desenvolvedor"));
        $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfile());
        $this->assertTrue($obj->changeUserProfile("Administrador"));
        $this->assertEquals("Administrador", $obj->retrieveUserProfile());
    }





    public function test_method_registerLogActivity()
    {
        $obj = $this->provideObject();
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        if (file_exists($this->pathToLocalData_LogFile_SuspectIP) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectIP);
        }
        if (file_exists($this->pathToLocalData_LogFile_SuspectLogin) === true) {
            unlink($this->pathToLocalData_LogFile_SuspectLogin);
        }



        $r = $obj->registerLogActivity(
            "POST",
            "http://aeondigital.com.br/test",
            ["p1" => "v1", "p2" => "v2"],
            "testController",
            "testAction",
            "actTest",
            "note"
        );
        $this->assertTrue($r);
    }
}
