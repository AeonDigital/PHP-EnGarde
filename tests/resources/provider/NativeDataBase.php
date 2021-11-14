<?php

$providerDAL = null;
$dirDataModels = $dirResources . DS . "datamodel";


function provider_connection_credentials()
{
    return [
        "UTEST" => [
            "site" => [
                "Anonymous" => [
                    "dbType"            => getenv("DATABASE_TYPE"), // export DATABASE_TYPE=mysql       | $Env:DATABASE_TYPE="mysql"
                    "dbHost"            => getenv("DATABASE_HOST"), // export DATABASE_HOST=localhost   | $ENV:DATABASE_HOST="localhost"
                    "dbName"            => getenv("DATABASE_NAME"), // export DATABASE_NAME=test        | $Env:DATABASE_NAME="test"
                    "dbUserName"        => getenv("DATABASE_USER"), // export DATABASE_USER=root        | $Env:DATABASE_USER="root"
                    "dbUserPassword"    => getenv("DATABASE_PASS"), // export DATABASE_PASS=root        | $Env:DATABASE_PASS="root"
                ],
                "Desenvolvedor" => [
                    "dbType"            => getenv("DATABASE_TYPE"), // export DATABASE_TYPE=mysql
                    "dbHost"            => getenv("DATABASE_HOST"), // export DATABASE_HOST=localhost
                    "dbName"            => getenv("DATABASE_NAME"), // export DATABASE_NAME=test
                    "dbUserName"        => getenv("DATABASE_USER"), // export DATABASE_USER=root
                    "dbUserPassword"    => getenv("DATABASE_PASS"), // export DATABASE_PASS=root
                ],
                "Administrador" => [
                    "dbType"            => getenv("DATABASE_TYPE"), // export DATABASE_TYPE=mysql
                    "dbHost"            => getenv("DATABASE_HOST"), // export DATABASE_HOST=localhost
                    "dbName"            => getenv("DATABASE_NAME"), // export DATABASE_NAME=test
                    "dbUserName"        => getenv("DATABASE_USER"), // export DATABASE_USER=root
                    "dbUserPassword"    => getenv("DATABASE_PASS"), // export DATABASE_PASS=root
                ]
            ]
        ]
    ];
}



function providerNDB_DAL()
{
    global $providerDAL;

    if ($providerDAL === null) {
        $con = provider_connection_credentials()["UTEST"]["site"]["Desenvolvedor"];
        $providerDAL = new \AeonDigital\DAL\DAL(
            $con["dbType"],
            $con["dbHost"],
            $con["dbName"],
            $con["dbUserName"],
            $con["dbUserPassword"]);
    }
    return $providerDAL;
}

function providerNDB_factory()
{
    global $dirDataModels;
    return new \AeonDigital\ORM\DataTableFactory($dirDataModels, providerNDB_DAL());
}

function providerNDB_schema()
{
    return new \AeonDigital\ORM\Schema(providerNDB_factory());
}

function providerNDB_executeCreateSchema()
{
    global $dirDataModels;
    $tgtFile = $dirDataModels . DS . "_projectData.php";
    if (file_exists($tgtFile) === true) { unlink($tgtFile); }
    $tgtFile = $dirDataModels . DS . "_projectSchema.sql";
    if (file_exists($tgtFile) === true) { unlink($tgtFile); }

    $obj = providerNDB_schema();
    $obj->executeCreateSchema(true);
}
