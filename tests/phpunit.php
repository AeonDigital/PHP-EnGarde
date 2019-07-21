<?php
$rootDir = realpath(__DIR__ . "/..");
require_once $rootDir . "/vendor/autoload.php";
require_once $rootDir . "/vendor/aeondigital/phpstream/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpuri/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpdata/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phphttpmessage/tests/src/__provider.php";
require_once $rootDir . "/vendor/aeondigital/phpengardeconfig/tests/src/__provider.php";
require_once $rootDir . "/tests/src/__provider.php";
require_once $rootDir . "/tests/src/concrete/RequestHandler01.php";
require_once $rootDir . "/tests/src/concrete/Middleware01.php";
require_once $rootDir . "/tests/src/apps/site/AppStart.php";
require_once $rootDir . "/tests/src/apps/site/controllers/Home.php";
require_once $rootDir . "/tests/src/apps/site/middlewares/TestMiddleware.php";
