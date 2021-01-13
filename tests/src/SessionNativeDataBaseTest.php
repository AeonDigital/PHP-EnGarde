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
            $defaultEngineVariables["forceHttps"], true
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


    protected function providerRestartDataBase()
    {
        providerNDB_executeCreateSchema();
        $DAL = providerNDB_DAL();

        $sql = [
            'INSERT INTO DomainApplication (Active, CommercialName, ApplicationName, Description) VALUES (1, "Site", "site", "Website");',

            'INSERT INTO DomainUser (Active, Name, Gender, Login, ShortLogin, Password) VALUES (0, "Anonimo", "-", "anonimo@anonimo", "anonimo", "anonimo");',
            'INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Adriano Santos", "Masculino", "adriano@dna.com.br", "adriano", SHA1("senhateste"));',
            'INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Eliane Somavilla", "Feminino", "eliane@dna.com.br", "eliane", SHA1("senhateste"));',
            'INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Geraldo Bilefete", "Masculino", "geraldo@dna.com.br", "geraldo", SHA1("senhateste"));',
            'INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Rianna Cantarelli", "Feminino", "rianna@dna.com.br", "rianna", SHA1("senhateste"));',


            'INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Desenvolvedor", "Usuários desenvolvedores do sistema.", 1, "/site", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));',
            'INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Administrador", "Usuários administradores do sistema.", 0, "/site", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));',
            'INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Publicador", "Usuários publicadores de conteúdo.", 0, "/site", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));',


            'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Desenvolvedor") FROM DomainUser;',
            'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Administrador") FROM DomainUser;',
            'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Publicador") FROM DomainUser;',

            'UPDATE secdup_to_secdu SET ProfileDefault=1 WHERE DomainUserProfile_Id=1;',
            'UPDATE secdup_to_secdu SET ProfileSelected=1 WHERE DomainUserProfile_Id=1 AND DomainUser_Id=5;',


            'INSERT INTO DomainRoute (ControllerName, ResourceId, ActionName, MethodHttp, RawRoute) VALUES ("home", "GET leveltree", "index", "GET", "/site/levelthree");',
            'INSERT INTO DomainRoute (ControllerName, ResourceId, ActionName, MethodHttp, RawRoute) VALUES ("home", "GET dashboard", "dashboard", "GET", "/site/dashboard");',
            'INSERT INTO DomainRoute (ControllerName, ResourceId, ActionName, MethodHttp, RawRoute) VALUES ("home", "GET levelone", "levelone", "GET", "/site/levelone");',

            'INSERT INTO secdup_to_secdr (DomainRoute_Id, DomainUserProfile_Id, Allow) VALUES ((SELECT Id FROM DomainRoute WHERE RawRoute="/site/levelthree"), (SELECT Id FROM DomainUserProfile WHERE Name="Desenvolvedor"), 0);',
            'INSERT INTO secdup_to_secdr (DomainRoute_Id, DomainUserProfile_Id, Allow) VALUES ((SELECT Id FROM DomainRoute WHERE RawRoute="/site/dashboard"), (SELECT Id FROM DomainUserProfile WHERE Name="Administrador"), 1);',
            'INSERT INTO secdup_to_secdr (DomainRoute_Id, DomainUserProfile_Id, Allow) VALUES ((SELECT Id FROM DomainRoute WHERE RawRoute="/site/levelone"), (SELECT Id FROM DomainUserProfile WHERE Name="Administrador"), 1);',
        ];

        foreach ($sql as $strSQL) {
            $DAL->executeInstruction($strSQL);
        }
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
            "Photo"         => null,
            "Profiles"      => [
                [
                    "Id"                => 1,
                    "Active"            => true,
                    "ApplicationId"     => 1,
                    "ApplicationName"   => "site",
                    "Name"              => "Desenvolvedor",
                    "Description"       => "Usuários desenvolvedores do sistema.",
                    "AllowAll"          => true,
                    "HomeURL"           => "/site",
                    "Default"           => true,
                    "Selected"          => true
                ],
                [
                    "Id"                => 2,
                    "Active"            => true,
                    "ApplicationId"     => 1,
                    "ApplicationName"   => "site",
                    "Name"              => "Administrador",
                    "Description"       => "Usuários administradores do sistema.",
                    "AllowAll"          => false,
                    "HomeURL"           => "/site",
                    "Default"           => false,
                    "Selected"          => false
                ],
                [
                    "Id"                => 3,
                    "Active"            => true,
                    "ApplicationId"     => 1,
                    "ApplicationName"   => "site",
                    "Name"              => "Publicador",
                    "Description"       => "Usuários publicadores de conteúdo.",
                    "AllowAll"          => false,
                    "HomeURL"           => "/site",
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
        $this->providerRestartDataBase();
        global $defaultServerVariables;
        global $defaultEngineVariables;
        global $defaultApplication;
        global $defaultSecurity;

        $securityConfig = prov_instanceOf_EnGarde_Config_Security($defaultSecurity);
        $securityCookie = new \AeonDigital\Http\Data\Cookie(
            $defaultSecurity["securityCookieName"], "", null,
            $defaultServerVariables["HTTP_HOST"], "/",
            $defaultEngineVariables["forceHttps"], true
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

        $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfileName());
        $this->assertEquals($authenticatedUser["Profiles"], $obj->retrieveUserProfiles());



        $r = $obj->executeLogout();
        $this->assertNull($obj->retrieveSession());
        $this->assertNull($obj->retrieveUser());
        $this->assertNull($obj->retrieveUserProfileName());
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
        $this->assertNull($obj->retrieveUserProfileName());
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

        $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfileName());
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
        if ($obj->retrieveUserProfileName() === "Desenvolvedor") {
            $this->assertTrue($obj->changeUserProfile("Administrador"));
            $this->assertEquals("Administrador", $obj->retrieveUserProfileName());
        }
        elseif ($obj->retrieveUserProfileName() === "Administrador") {
            $this->assertTrue($obj->changeUserProfile("Desenvolvedor"));
            $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfileName());
        }


        $this->assertTrue($obj->changeUserProfile("Desenvolvedor"));
        $this->assertEquals("Desenvolvedor", $obj->retrieveUserProfileName());
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





    public function test_method_processRoutesPermissions()
    {
        global $dirResources;
        $pathToAppRoutes = $dirResources . DS . "apps" . DS . "site" . DS . "AppRoutes.php";


        // Prepara o ambiente para estes testes
        $DAL = providerNDB_DAL();
        $strSQL = "DELETE FROM DomainRoute;";
        $DAL->executeInstruction($strSQL);
        $this->assertEquals(0, $DAL->countRowsFrom("DomainRoute", "Id"));


        // Executa a varredura e registro de rotas da aplicação.
        $obj = $this->provideObject();
        $obj->processRoutesPermissions($pathToAppRoutes);

        $countRoutes = $DAL->countRowsFrom("DomainRoute", "Id");
        $this->assertTrue(($countRoutes > 0));


        // Exclui uma coleção arbitrária de rotas para verificar se as mesmas
        // serão realocadas ao rodar novamente o mesmo método
        $strSQL = "DELETE FROM DomainRoute WHERE Description='Página home da aplicação';";
        $DAL->executeInstruction($strSQL);
        $remainingRoutes = $DAL->countRowsFrom("DomainRoute", "Id");
        $this->assertTrue(($remainingRoutes < $countRoutes));


        // Executa novamente a varredura das rotas.
        // As que foram excluídas devem ser readicionadas.
        $obj->processRoutesPermissions($pathToAppRoutes);
        $newCountRoutes = $DAL->countRowsFrom("DomainRoute", "Id");
        $this->assertEquals($countRoutes, $newCountRoutes);



        // Conta quantas rotas são permitidas para o perfil de usuário de Id 2;
        $strSQLCountAllowed = " SELECT
                        COUNT(DomainRoute_Id) as count
                    FROM
                        secdup_to_secdr
                    WHERE
                        DomainUserProfile_Id=2 AND Allow=1;";
        $initialAllowed = $DAL->getCountOf($strSQLCountAllowed);

        // Converte todas as relações entre o perfil de Id 2 e suas respectivas
        // rotas para dar permissão a todos.
        $strSQL = "UPDATE secdup_to_secdr SET Allow=1 WHERE DomainUserProfile_Id=2;";
        $DAL->executeInstruction($strSQL);

        // Verifica se o número de rotas atualmente permitidas é maior que o inicial
        $currentAllowed = $DAL->getCountOf($strSQLCountAllowed);
        $this->assertTrue(($currentAllowed > $initialAllowed));

        // Roda o processamento das rotas e verifica que nenhuma definição previamente
        // realizada sofreu qualquer alteração.
        $obj->processRoutesPermissions($pathToAppRoutes);
        $finalAllowed = $DAL->getCountOf($strSQLCountAllowed);
        $this->assertTrue(($currentAllowed === $finalAllowed));





        // Redefine dados que permitem que os testes acima funcionem adequadamente.
        $sql = [
            'INSERT INTO DomainRoute (ControllerName, ResourceId, ActionName, MethodHttp, RawRoute) VALUES ("home", "GET leveltree", "index", "GET", "/site/levelthree");',
            'INSERT INTO DomainRoute (ControllerName, ResourceId, ActionName, MethodHttp, RawRoute) VALUES ("home", "GET dashboard", "dashboard", "GET", "/site/dashboard");',
            'INSERT INTO DomainRoute (ControllerName, ResourceId, ActionName, MethodHttp, RawRoute) VALUES ("home", "GET levelone", "levelone", "GET", "/site/levelone");',

            'INSERT INTO secdup_to_secdr (DomainRoute_Id, DomainUserProfile_Id, Allow) VALUES ((SELECT Id FROM DomainRoute WHERE RawRoute="/site/levelthree"), (SELECT Id FROM DomainUserProfile WHERE Name="Desenvolvedor"), 0);',
            'INSERT INTO secdup_to_secdr (DomainRoute_Id, DomainUserProfile_Id, Allow) VALUES ((SELECT Id FROM DomainRoute WHERE RawRoute="/site/dashboard"), (SELECT Id FROM DomainUserProfile WHERE Name="Administrador"), 1);',
            'INSERT INTO secdup_to_secdr (DomainRoute_Id, DomainUserProfile_Id, Allow) VALUES ((SELECT Id FROM DomainRoute WHERE RawRoute="/site/levelone"), (SELECT Id FROM DomainUserProfile WHERE Name="Administrador"), 1);'
        ];

        foreach ($sql as $strSQL) {
            $DAL->executeInstruction($strSQL);
        }
    }
}
