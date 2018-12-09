<?php
/**
 * Coleção de recursos que devem ser carregados para executar
 * os testes unitários.
 */
$rootDir = realpath(__DIR__ . "/..");
$srcDir = $rootDir . "/src";
$appDir = $rootDir . "/tests/src/apps/site";

require_once $rootDir . "/vendor/autoload.php";
require_once $rootDir . "/vendor/aeondigital/phpstream/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpuri/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpdata/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpmessage/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phpengardeconfig/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phpengarderequestmanager/tests/src/__provider.php";
require_once $rootDir . "/tests/src/__provider.php";

require_once $srcDir . "/DomainManager.php";

require_once $srcDir . "/RouteResolver.php";

require_once $srcDir . "/Interfaces/iApplication.php";
require_once $srcDir . "/DomainApplication.php";
require_once $appDir . "/AppStart.php";

require_once $srcDir . "/Interfaces/iResponseHandler.php";
require_once $srcDir . "/ResponseHandler.php";

require_once $srcDir . "/Interfaces/iController.php";
require_once $srcDir . "/DomainController.php";
require_once $appDir . "/controllers/Home.php";
require_once $appDir . "/middlewares/TestMiddleware.php";
