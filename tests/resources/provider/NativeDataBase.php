<?php

$providerDAL = null;
$dirDataModels = $dirResources . DS . "datamodel";


function provider_connection_credentials()
{
    return [
        "UTEST" => [
            "site" => [
                "Anonymous" => [
                    "dbType"            => "mysql",
                    "dbHost"            => "localhost",
                    "dbName"            => "test",
                    "dbUserName"        => "root",
                    "dbUserPassword"    => "admin"
                ],
                "Desenvolvedor" => [
                    "dbType"            => "mysql",
                    "dbHost"            => "localhost",
                    "dbName"            => "test",
                    "dbUserName"        => "root",
                    "dbUserPassword"    => "admin"
                ],
                "Administrador" => [
                    "dbType"            => "mysql",
                    "dbHost"            => "localhost",
                    "dbName"            => "test",
                    "dbUserName"        => "root",
                    "dbUserPassword"    => "admin"
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
