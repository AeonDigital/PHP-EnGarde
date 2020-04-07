<?php
$dirRoot        = str_replace("/", DIRECTORY_SEPARATOR, realpath(__DIR__ . "/.."));
$dirResources   = str_replace("/", DIRECTORY_SEPARATOR, $dirRoot . "/tests/resources");
$dirFiles       = str_replace("/", DIRECTORY_SEPARATOR, $dirResources . "/files");


require_once $dirRoot . "/vendor/autoload.php";
require_once $dirResources . "/load_providers.php";


/*
<?php
require_once $dirRoot . "/tests/src/concrete/RequestHandler01.php";
require_once $dirRoot . "/tests/src/concrete/Middleware01.php";
require_once $dirRoot . "/tests/src/apps/site/AppStart.php";
require_once $dirRoot . "/tests/src/apps/site/controllers/Home.php";
require_once $dirRoot . "/tests/src/apps/site/middlewares/TestMiddleware.php";
*/
