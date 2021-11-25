<?php
$dirRoot        = str_replace("/", DIRECTORY_SEPARATOR, realpath(__DIR__ . "/.."));
$dirResources   = str_replace("/", DIRECTORY_SEPARATOR, $dirRoot . "/tests/resources");
$dirFiles       = str_replace("/", DIRECTORY_SEPARATOR, $dirResources . "/files");


require_once $dirRoot . "/vendor/autoload.php";
require_once $dirResources . "/load_providers.php";






const ENV_DATABASE = [
    "LCL" => [
        "site" => [
            "ANONYMOUS" => [
                "dbType"            => "mysql",
                "dbHost"            => "localhost",
                "dbName"            => "database_name",
                "dbUserName"        => "username",
                "dbUserPassword"    => "password",
                "dbSSLCA"           => null
            ]
        ]
    ],
    "UTEST" => [
        "site" => [
            "ANONYMOUS" => [
                "dbType"            => "mysql",
                "dbHost"            => "localhost",
                "dbName"            => "database_name",
                "dbUserName"        => "username",
                "dbUserPassword"    => "password",
                "dbSSLCA"           => null
            ]
        ]
    ]
];
