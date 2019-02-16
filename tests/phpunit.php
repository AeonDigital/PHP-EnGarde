<?php
/**
 * Coleção de recursos que devem ser carregados para executar
 * os testes unitários.
 */
$rootDir = realpath(__DIR__ . "/..");
$srcDir = $rootDir . "/src";
$appDir = $rootDir . "/tests/src/apps/site";
$conDir = $rootDir . "/tests/src/concrete";

require_once $rootDir . "/vendor/autoload.php";
require_once $rootDir . "/vendor/aeondigital/phpstream/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpuri/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpdata/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpmessage/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phpengardeconfig/tests/src/__provider.php";
require_once $rootDir . "/tests/src/__provider.php";


require_once $srcDir . "/Interfaces/iMiddleware.php";
require_once $srcDir . "/Interfaces/iRequestHandler.php";
require_once $srcDir . "/RequestHandler.php";
require_once $conDir . "/RequestHandler01.php";
require_once $conDir . "/Middleware01.php";


require_once $srcDir . "/Interfaces/iResponseHandler.php";
require_once $srcDir . "/ResponseHandler.php";

require_once $srcDir . "/Interfaces/iMimeHandler.php";
require_once $srcDir . "/MimeHandler/aMimeHandler.php";
require_once $srcDir . "/MimeHandler/HTML.php";
require_once $srcDir . "/MimeHandler/XHTML.php";
require_once $srcDir . "/MimeHandler/JSON.php";
require_once $srcDir . "/MimeHandler/TXT.php";
require_once $srcDir . "/MimeHandler/XML.php";
require_once $srcDir . "/MimeHandler/CSV.php";
require_once $srcDir . "/MimeHandler/XLS.php";
require_once $srcDir . "/MimeHandler/XLSX.php";


require_once $srcDir . "/DomainManager.php";
require_once $srcDir . "/RouteResolver.php";


require_once $srcDir . "/Interfaces/iApplication.php";
require_once $srcDir . "/DomainApplication.php";
require_once $appDir . "/AppStart.php";


require_once $srcDir . "/Interfaces/iController.php";
require_once $srcDir . "/DomainController.php";
require_once $appDir . "/controllers/Home.php";
require_once $appDir . "/middlewares/TestMiddleware.php";
