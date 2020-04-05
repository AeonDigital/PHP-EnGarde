<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\ApplicationRouter as ApplicationRouter;
use AeonDigital\EnGarde\Config\ApplicationConfig as ApplicationConfig;

require_once __DIR__ . "/../phpunit.php";






class ApplicationRouterTest extends TestCase
{





    public function test_constructor_ok()
    {
        $applicationConfig = provider_PHPEnGardeConfig_InstanceOf_ApplicationConfig();

        $nMock = new ApplicationRouter(
            $applicationConfig->getName(),
            $applicationConfig->getPathToAppRoutes(),
            $applicationConfig->getPathToControllers(),
            $applicationConfig->getControllersNamespace(),
            $applicationConfig->getDefaultRouteConfig()
        );

        $this->assertTrue(is_a($nMock, ApplicationRouter::class));
    }


    public function test_method_set_default_route_config()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ApplicationRouter();
        $nMock->setDefaultRouteConfig(["property" => "value"]);
        $this->assertTrue(is_a($nMock, ApplicationRouter::class));
    }


    public function test_method_set_is_update_routes()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ApplicationRouter();
        $nMock->setIsUpdateRoutes(true);
        $this->assertTrue(is_a($nMock, ApplicationRouter::class));
    }


    public function test_method_force_update_routes()
    {
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ApplicationRouter();

        $ds = DIRECTORY_SEPARATOR;
        $baseAppDirectory = dirname(__FILE__) . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        file_put_contents($appRoutes, "cfg-");

        $this->assertTrue(file_exists($appRoutes));
        $nMock->forceUpdateRoutes();
        $this->assertFalse(file_exists($appRoutes));


        file_put_contents($appRoutes, "cfg-");
        $this->assertTrue(file_exists($appRoutes));
    }


    public function test_method_check_for_update_application_routes()
    {
        $ds = DIRECTORY_SEPARATOR;
        $baseAppDirectory = dirname(__FILE__) . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        $ctrlTest1 = $baseAppDirectory . "controllers" . $ds . "Test1.php";
        $ctrlTest2 = $baseAppDirectory . "controllers" . $ds . "Test2.php";

        if (file_exists($appRoutes)) {
            unlink($appRoutes);
        }
        if (file_exists($ctrlTest1)) {
            unlink($ctrlTest1);
        }
        if (file_exists($ctrlTest2)) {
            unlink($ctrlTest2);
        }

        file_put_contents($ctrlTest1, "test1-");
        file_put_contents($ctrlTest2, "test2-");



        $nMock = provider_PHPEnGardeConfig_InstanceOf_ApplicationRouter();
        $nMock->setIsUpdateRoutes(true);
        $this->assertTrue($nMock->checkForUpdateApplicationRoutes());


        sleep(1);
        // Readiciona o arquivo de configuração 2 segundos após o
        // início do teste, fazendo com que ele seja mais recente que
        // os arquivos dos controllers.
        file_put_contents($appRoutes, "cfg-");
        $this->assertFalse($nMock->checkForUpdateApplicationRoutes());


        sleep(1);
        // Altera um dos controllers 2 segundos após o arquivo de configuração
        // ser alterado, para que assim, a atualização das rotas seja requerida.
        file_put_contents($ctrlTest1, "test1-", FILE_APPEND);
        $this->assertTrue($nMock->checkForUpdateApplicationRoutes(true));
    }


    public function test_method_update_application_routes()
    {
        $ds = DIRECTORY_SEPARATOR;
        $baseAppDirectory = dirname(__FILE__) . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        $ctrlTest1 = $baseAppDirectory . "controllers" . $ds . "Test1.php";
        $ctrlTest2 = $baseAppDirectory . "controllers" . $ds . "Test2.php";
        $ctrlHome = $baseAppDirectory . "controllers" . $ds . "Home.php";

        if (file_exists($appRoutes)) {
            unlink($appRoutes);
        }
        if (file_exists($ctrlTest1)) {
            unlink($ctrlTest1);
        }
        if (file_exists($ctrlTest2)) {
            unlink($ctrlTest2);
        }



        require_once($ctrlHome);
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ApplicationRouter();
        $nMock->updateApplicationRoutes();
        $this->assertTrue(file_exists($appRoutes));
    }


    public function test_method_select_target_raw_route()
    {
        $ds = DIRECTORY_SEPARATOR;
        $baseAppDirectory = dirname(__FILE__) . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        $ctrlHome = $baseAppDirectory . "controllers" . $ds . "Home.php";

        if (file_exists($appRoutes)) {
            unlink($appRoutes);
        }


        require_once($ctrlHome);
        $nMock = provider_PHPEnGardeConfig_InstanceOf_ApplicationRouter();
        $nMock->updateApplicationRoutes();
        $this->assertTrue(file_exists($appRoutes));


        $r = $nMock->selectTargetRawRoute("/site");
        $this->assertNotNull($r);
        $this->assertTrue(is_array($r));


        $r = $nMock->selectTargetRawRoute("/site/list/nameasc/10");
        $this->assertNotNull($r);
        $this->assertTrue(is_array($r));


        $r = $nMock->selectTargetRawRoute("/site/configurando-uma-rota/propriedades/responseMime");
        $this->assertNotNull($r);
        $this->assertTrue(is_array($r));

        $expected = ["propertie" => "responseMime"];
        $this->assertSame($expected, $nMock->getSelectedRouteParans());
    }
}
