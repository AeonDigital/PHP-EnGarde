<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Http\Router as Router;

require_once __DIR__ . "/../../phpunit.php";







class RouterTest extends TestCase
{





    public function test_constructor_ok()
    {
        $applicationConfig = prov_instanceOf_EnGarde_Config_Application();

        $nMock = new Router(
            $applicationConfig->getName(),
            $applicationConfig->getPathToAppRoutes(),
            $applicationConfig->getPathToControllers(),
            $applicationConfig->getControllersNamespace(),
            $applicationConfig->getDefaultRouteConfig()
        );

        $this->assertTrue(is_a($nMock, Router::class));
    }


    public function test_method_set_default_route_config()
    {
        $nMock = prov_instanceOf_EnGarde_Http_Router();
        $nMock->setDefaultRouteConfig(["property" => "value"]);
        $this->assertTrue(is_a($nMock, Router::class));
    }


    public function test_method_set_is_update_routes()
    {
        $nMock = prov_instanceOf_EnGarde_Http_Router();
        $nMock->setIsUpdateRoutes(true);
        $this->assertTrue(is_a($nMock, Router::class));
    }


    public function test_method_force_update_routes()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $nMock = prov_instanceOf_EnGarde_Http_Router();

        $baseAppDirectory = $dirResources . $ds . "apps" . $ds . "site" . $ds;
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
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $baseAppDirectory = $dirResources . $ds . "apps" . $ds . "site" . $ds;
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



        $nMock = prov_instanceOf_EnGarde_Http_Router();
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
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $baseAppDirectory = $dirResources . $ds . "apps" . $ds . "site" . $ds;
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
        $nMock = prov_instanceOf_EnGarde_Http_Router();
        $nMock->updateApplicationRoutes();
        $this->assertTrue(file_exists($appRoutes));
    }


    public function test_method_select_target_raw_route()
    {
        global $dirResources;
        $ds = DIRECTORY_SEPARATOR;

        $baseAppDirectory = $dirResources . $ds . "apps" . $ds . "site" . $ds;
        $appRoutes = $baseAppDirectory . "AppRoutes.php";
        $ctrlHome = $baseAppDirectory . "controllers" . $ds . "Home.php";

        if (file_exists($appRoutes)) {
            unlink($appRoutes);
        }


        require_once($ctrlHome);
        $nMock = prov_instanceOf_EnGarde_Http_Router();
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
