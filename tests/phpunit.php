<?php
/**
 * Coleção de recursos que devem ser carregados para executar
 * os testes unitários.
 */
$rootDir = realpath(__DIR__ . "/..");
$srcDir = $rootDir . "/src";
$conDir = $rootDir . "/tests/src/concrete";

require_once $rootDir . "/vendor/autoload.php";

require_once $srcDir . "/Interfaces/iDomainConfig.php";
require_once $srcDir . "/Config/DomainConfig.php";

require_once $srcDir . "/Interfaces/iApplicationConfig.php";
require_once $srcDir . "/Config/ApplicationConfig.php";

require_once $srcDir . "/Interfaces/iApplicationRouter.php";
require_once $srcDir . "/ApplicationRouter.php";

require_once $srcDir . "/Interfaces/iRouteConfig.php";
require_once $srcDir . "/Config/RouteConfig.php";

require_once $srcDir . "/Interfaces/iApplication.php";
require_once $srcDir . "/Traits/CommomProperties.php";
require_once $srcDir . "/DomainApplication.php";
require_once $conDir . "/AppConfig.php";

require_once $srcDir . "/ErrorListening.php";
require_once $srcDir . "/DomainManager.php";

require_once $srcDir . "/Interfaces/iResponseHandler.php";
require_once $srcDir . "/Handlers/ResponseHandler.php";
