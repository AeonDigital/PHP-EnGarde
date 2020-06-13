<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\SessionControl\NativeDataBase as NativeDataBase;

require_once __DIR__ . "/../phpunit.php";







class SessionNativeDataBaseTest extends TestCase
{




    protected function provideObject($sessionHash = "")
    {
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;


        $securityConfig = prov_instanceOf_EnGarde_Config_Security($defaultSecurity);
        $securityCookie = new \AeonDigital\Http\Data\Cookie(
            $defaultSecurity["securityCookieName"],
            $sessionHash, null,
            $defaultServerVariables["HTTP_HOST"], "/",
            $defaultEngineVariables["forceHTTPS"], true
        );


        return new NativeDataBase(
            new \DateTime(),
            $defaultEngineVariables["environmentType"],
            $defaultApplication["appName"],
            $defaultServerVariables["HTTP_USER_AGENT"],
            $defaultServerVariables["REMOTE_ADDR"],
            $securityConfig,
            $securityCookie,
            "",
            provider_connection_credentials()
        );
    }


    protected function providerSessionObject()
    {
        return [
            "Id"                => 6,
            "RegisterDate"      => "2020-06-11 15:04:54",
            "SessionHash"       => "a11785ddced1883e285aa70b84c81cce033aa449",
            "SessionTimeOut"    => "2020-06-11 15:44:54",
            "UserAgent"         => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0",
            "UserAgentIP"       => "200.200.100.50",
            "GrantPermission"   => null,
            "DomainUser_Id"     => "5",
            "DomainUser"        => "rianna@dna.com.br"
        ];
    }


    protected function providerUserObject()
    {
        return [
            "Id"            => 5,
            "Active"        => true,
            "RegisterDate"  => "2020-06-11 15:02:52",
            "Name"          => "Rianna Cantarelli",
            "Gender"        => "Feminino",
            "Login"         => "rianna@dna.com.br",
            "ShortLogin"    => "rianna",
            "Password"      => "31f88741c850331188d23e6e0067730e13c92809",
            "Profiles"      => [
                [
                    "Id"                => 1,
                    "Active"            => true,
                    "ApplicationName"   => "site",
                    "Name"              => "Desenvolvedor",
                    "Description"       => "Usuários desenvolvedores do sistema.",
                    "AllowAll"          => true,
                    "Default"           => true,
                    "Selected"          => true
                ],
                [
                    "Id"                => 2,
                    "Active"            => true,
                    "ApplicationName"   => "site",
                    "Name"              => "Administrador",
                    "Description"       => "Usuários administradores do sistema.",
                    "AllowAll"          => false,
                    "Default"           => false,
                    "Selected"          => false
                ],
                [
                    "Id"                => 3,
                    "Active"            => true,
                    "ApplicationName"   => "site",
                    "Name"              => "Publicador",
                    "Description"       => "Usuários publicadores de conteúdo.",
                    "AllowAll"          => false,
                    "Default"           => false,
                    "Selected"          => false
                ]
            ]
        ];
    }


    protected function cleanLogDataTables()
    {
        $DAL = providerNDB_DAL();
        $strSQL = "DELETE FROM DomainUserBlockedAccess;";
        $DAL->executeInstruction($strSQL);

        $strSQL = "DELETE FROM DomainUserRequestLog;";
        $DAL->executeInstruction($strSQL);

        $strSQL = "DELETE FROM DomainUserSession;";
        $DAL->executeInstruction($strSQL);
    }







    public function test_constructor_ok()
    {
        //providerNDB_executeCreateSchema();
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


        $obj = new NativeDataBase(
            new \DateTime(),
            $defaultEngineVariables["environmentType"],
            $defaultApplication["appName"],
            $defaultServerVariables["HTTP_USER_AGENT"],
            $defaultServerVariables["REMOTE_ADDR"],
            $securityConfig,
            $securityCookie,
            "",
            provider_connection_credentials()
        );
        $this->assertTrue(is_a($obj, NativeDataBase::class));
        $this->assertEquals($securityCookie, $obj->retrieveSecurityCookie());
        $this->assertTrue(is_a($obj->getDAL(), "AeonDigital\\DAL\\DAL"));
        $this->assertNull($obj->retrieveSession());
        $this->assertNull($obj->retrieveUser());
        $this->assertNull($obj->retrieveUserProfile());
        $this->assertNull($obj->retrieveUserProfiles());
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
    }




    public function test_method_executeLogin_executeLogout()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



        $r = $obj->executeLogin("rianna", sha1("senhateste"));
        $this->assertEquals("UserSessionAuthenticated", $obj->retrieveSecurityStatus());
        $this->assertTrue($r);



        $sessionModel = $this->providerSessionObject();
        unset($sessionModel["Id"]);
        unset($sessionModel["SessionHash"]);
        unset($sessionModel["RegisterDate"]);
        unset($sessionModel["SessionTimeOut"]);

        $authenticatedSession = $obj->retrieveSession();
        unset($authenticatedSession["Id"]);
        unset($authenticatedSession["SessionHash"]);
        unset($authenticatedSession["RegisterDate"]);
        unset($authenticatedSession["SessionTimeOut"]);
        $this->assertEquals($sessionModel, $authenticatedSession);



        $userModel = $this->providerUserObject();
        unset($userModel["RegisterDate"]);

        $authenticatedUser = $obj->retrieveUser();
        unset($authenticatedUser["RegisterDate"]);
        $this->assertEquals($userModel, $authenticatedUser);

        $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfile());
        $this->assertEquals($authenticatedUser["Profiles"], $obj->retrieveUserProfiles());



        $r = $obj->executeLogout();
        $this->assertNull($obj->retrieveSession());
        $this->assertNull($obj->retrieveUser());
        $this->assertNull($obj->retrieveUserProfile());
        $this->assertNull($obj->retrieveUserProfiles());
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
    }


    public function test_method_executeLogin_UserAccountUnexpectedPassword()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



        $r = $obj->executeLogin("rianna", sha1("senhaerrada"));

        $this->assertNull($obj->retrieveSession());
        $this->assertNull($obj->retrieveUser());
        $this->assertNull($obj->retrieveUserProfile());
        $this->assertNull($obj->retrieveUserProfiles());
        $this->assertEquals("UserAccountUnexpectedPassword", $obj->retrieveSecurityStatus());
        $this->assertFalse($r);
    }


    public function test_method_executeLogin_UserAccountHasBeenBlocked()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



        for ($i=0; $i<4; $i++) {
            $this->assertFalse($obj->executeLogin("rianna", sha1("senhaerrada")));
            $this->assertEquals("UserAccountUnexpectedPassword", $obj->retrieveSecurityStatus());
        }
        $this->assertFalse($obj->executeLogin("rianna", sha1("senhaerrada")));
        $this->assertEquals("UserAccountHasBeenBlocked", $obj->retrieveSecurityStatus());

        $this->assertFalse($obj->executeLogin("rianna", sha1("senhaerrada")));
        $this->assertEquals("UserAccountIsBlocked", $obj->retrieveSecurityStatus());
    }


    public function test_method_executeLogin_UserAccountDoesNotExist()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



        for ($i=0; $i<49; $i++) {
            $this->assertFalse($obj->executeLogin("inexistente", sha1("senhaerrada")));
            $this->assertEquals("UserAccountDoesNotExist", $obj->retrieveSecurityStatus());
        }
        $this->assertFalse($obj->executeLogin("inexistente", sha1("senhaerrada")));
        $this->assertEquals("UserAgentIPHasBeenBlocked", $obj->retrieveSecurityStatus());

        $this->assertFalse($obj->executeLogin("inexistente", sha1("senhaerrada")));
        $this->assertEquals("UserAgentIPBlocked", $obj->retrieveSecurityStatus());




        $DAL = providerNDB_DAL();
        $blockExpired = new \DateTime();
        $blockExpired->sub(new \DateInterval("PT1M"));

        $strSQL = "UPDATE DomainUserBlockedAccess SET BlockTimeOut=:BlockTimeOut;";
        $DAL->executeInstruction($strSQL, ["BlockTimeOut" => $blockExpired]);

        $registerDate = new \DateTime();
        $registerDate->sub(new \DateInterval("PT51M"));
        $strSQL = "UPDATE DomainUserRequestLog SET RegisterDate=:RegisterDate;";
        $DAL->executeInstruction($strSQL, ["RegisterDate" => $registerDate]);

        $this->assertFalse($obj->executeLogin("inexistente", "senhaerrada"));
        $this->assertEquals("UserAccountDoesNotExist", $obj->retrieveSecurityStatus());
    }





    public function test_method_checkUserAgentSession()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



        $this->assertTrue($obj->executeLogin("rianna", sha1("senhateste")));
        $authenticatedSession = $obj->retrieveSession();


        $obj = $this->provideObject($authenticatedSession["SessionHash"]);
        $this->assertEquals("UserAgentUndefined", $obj->retrieveSecurityStatus());
        $r = $obj->checkUserAgentSession();
        $this->assertEquals("UserSessionAuthenticated", $obj->retrieveSecurityStatus());


        $sessionModel = $this->providerSessionObject();
        unset($sessionModel["Id"]);
        unset($sessionModel["SessionHash"]);
        unset($sessionModel["RegisterDate"]);
        unset($sessionModel["SessionTimeOut"]);

        $authenticatedSession = $obj->retrieveSession();
        unset($authenticatedSession["Id"]);
        unset($authenticatedSession["SessionHash"]);
        unset($authenticatedSession["RegisterDate"]);
        unset($authenticatedSession["SessionTimeOut"]);
        $this->assertEquals($sessionModel, $authenticatedSession);



        $userModel = $this->providerUserObject();
        unset($userModel["RegisterDate"]);

        $authenticatedUser = $obj->retrieveUser();
        unset($authenticatedUser["RegisterDate"]);
        $this->assertEquals($userModel, $authenticatedUser);

        $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfile());
        $this->assertEquals($authenticatedUser["Profiles"], $obj->retrieveUserProfiles());
        $this->assertTrue($r);
    }





    public function test_method_grantPermission()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



        $this->assertTrue($obj->executeLogin("rianna", sha1("senhateste")));
        $authenticatedSession = $obj->retrieveSession();
        $this->assertNull($authenticatedSession["GrantPermission"]);


        $obj = $this->provideObject();
        $this->assertTrue(
            $obj->executeLogin(
                "rianna",
                sha1("senhateste"),
                "specialPermission",
                $authenticatedSession["SessionHash"]
            )
        );

        $obj = $this->provideObject($authenticatedSession["SessionHash"]);
        $this->assertTrue($obj->checkUserAgentSession());
        $authenticatedSession = $obj->retrieveSession();
        $this->assertNotNull($authenticatedSession);
        $this->assertEquals("specialPermission", $authenticatedSession["GrantPermission"]);
    }





    public function test_method_changeUserProfile()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



        $this->assertTrue($obj->executeLogin("rianna", sha1("senhateste")));
        if ($obj->retrieveUserProfile() === "Desenvolvedor") {
            $this->assertTrue($obj->changeUserProfile("Administrador"));
            $this->assertEquals("Administrador", $obj->retrieveUserProfile());
        }
        elseif ($obj->retrieveUserProfile() === "Administrador") {
            $this->assertTrue($obj->changeUserProfile("Desenvolvedor"));
            $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfile());
        }


        $this->assertTrue($obj->changeUserProfile("Desenvolvedor"));
        $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfile());
    }





    public function test_method_registerLogActivity()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



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





    public function test_method_checkRoutePermission()
    {
        $this->cleanLogDataTables();
        $obj = $this->provideObject();



        $this->assertTrue($obj->executeLogin("rianna", sha1("senhateste")));
        // Usuário com regra permissiva... acessa tudo que não é explicitamente proibido
        $this->assertTrue($obj->changeUserProfile("Desenvolvedor"));
        $this->assertTrue($obj->checkRoutePermission("GET", "/site/dashboard"));
        $this->assertTrue($obj->checkRoutePermission("GET", "/site/levelone"));
        $this->assertTrue($obj->checkRoutePermission("GET", "/site/leveltwo"));
        $this->assertTrue($obj->checkRoutePermission("GET", "/site/nonexists"));
        $this->assertFalse($obj->checkRoutePermission("GET", "/site/levelthree"));

        // Usuário com regra restritiva... apenas acessa aquilo que é explicitamente permitido.
        $this->assertTrue($obj->changeUserProfile("Administrador"));
        $this->assertTrue($obj->checkRoutePermission("GET", "/site/dashboard"));
        $this->assertTrue($obj->checkRoutePermission("GET", "/site/levelone"));
        $this->assertFalse($obj->checkRoutePermission("GET", "/site/leveltwo"));
        $this->assertFalse($obj->checkRoutePermission("GET", "/site/levelthree"));


        $this->assertTrue($obj->changeUserProfile("Desenvolvedor"));
    }
}
