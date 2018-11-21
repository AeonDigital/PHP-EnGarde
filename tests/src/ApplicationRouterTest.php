<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\ApplicationRouter as ApplicationRouter;
use AeonDigital\EnGarde\Config\ApplicationConfig as ApplicationConfig;

require_once __DIR__ . "/../phpunit.php";






class ApplicationRouterTest extends TestCase
{


    /**
     * Retorna um objeto "Config" para os testes
     *
     * @return ApplicationConfig
     */
    protected function setApplicationConfigToTest(
        bool $autoSet = false,
        string $name = "site",
        string $controllersNamespace = "site\\controllers",
        string $startRoute = "/",
        string $appRoot = null,
        string $pathToControllers = "/controllers",
        string $pathToLocales = null,
        string $pathToCacheFiles = null,
        string $pathToViews = null,
        string $pathToAppRoutes = null,
        string $pathToTargetLocale = null,
        string $pathToMasterPage = null
    ) : ApplicationConfig {
        $ds = DIRECTORY_SEPARATOR;
        $domainRoot = dirname(__FILE__) . $ds . "apps" . $ds;
        $appRoot = (($appRoot === "") ? ($domainRoot . $name) : $appRoot);
        $ac = new ApplicationConfig();

        if ($autoSet === true) {
            $ac->autoSetProperties($name, $domainRoot);
        } else {
            $ac->setName($name);
            $ac->setControllersNamespace($controllersNamespace);
            $ac->setStartRoute($startRoute);
            $ac->setAppRoot($appRoot);
            $ac->setPathToControllers($pathToControllers);
            $ac->setPathToLocales($pathToLocales);
            $ac->setPathToCacheFiles($pathToCacheFiles);
            $ac->setPathToViews($pathToViews);
            $ac->setPathToAppRoutes($pathToAppRoutes);
            $ac->setPathToTargetLocale($pathToTargetLocale);
            $ac->setPathToMasterPage($pathToMasterPage);
        }

        $ac->setDefaultRouteConfig([
            "description" => "Descrição genérica.",
            "acceptmimes" => ["xhtml", "html"],
            "isusexhtml" => true,
            "middlewares" => ["app_mid_01", "app_mid_02", "app_mid_03"],
            "metadata" => [
                "Author" => "Aeon Digital",
                "CopyRight" => "20xx Aeon Digital",
                "FrameWork" => "PHP-Domain 0.9.0 [alpha]"
            ]
        ]);

        return $ac;
    }


    private function provider_application_router() : ApplicationRouter
    {
        $appConfig = $this->setApplicationConfigToTest(true);
        
        return new ApplicationRouter(
            $appConfig->getName(),
            $appConfig->getPathToAppRoutes(),
            $appConfig->getPathToControllers(),
            $appConfig->getControllersNamespace(),
            $appConfig->getDefaultRouteConfig()
        );
    }










    public function test_constructor_ok()
    {
        $appConfig = $this->setApplicationConfigToTest(true);
        
        $nMock = new ApplicationRouter(
            $appConfig->getName(),
            $appConfig->getPathToAppRoutes(),
            $appConfig->getPathToControllers(),
            $appConfig->getControllersNamespace(),
            $appConfig->getDefaultRouteConfig()
        );

        $this->assertTrue(is_a($nMock, ApplicationRouter::class));
    }


    public function test_method_set_default_route_config()
    {
        $nMock = $this->provider_application_router();
        $nMock->setDefaultRouteConfig(["property" => "value"]);
        $this->assertTrue(is_a($nMock, ApplicationRouter::class));
    }


    public function test_method_set_is_update_routes()
    {
        $nMock = $this->provider_application_router();
        $nMock->setIsUpdateRoutes(true);
        $this->assertTrue(is_a($nMock, ApplicationRouter::class));
    }


    public function test_method_force_update_routes()
    {
        $nMock = $this->provider_application_router();

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



        $nMock = $this->provider_application_router();
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
        $nMock = $this->provider_application_router();
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
        $nMock = $this->provider_application_router();
        $nMock->updateApplicationRoutes();
        $this->assertTrue(file_exists($appRoutes));


        $r = $nMock->selectTargetRawRoute("/site/list/nameasc/10");
        $this->assertNotNull($r);
        $this->assertTrue(is_array($r));
    }
}
