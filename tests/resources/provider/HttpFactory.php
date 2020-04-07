<?php



// ---
// Objetos e processos de uso variado.

function prov_defineGlobal_FILES()
{
    $_FILES = [
        "fieldOne" => [
            "name"      => "ua-file-name.png",
            "type"      => "image/png",
            "tmp_name"  => to_system_path(dirname(__DIR__) . "/files/image-resource.jpg"),
            "error"     => 0,
            "size"      => 1000
        ],
        "multiField" => [
            "name"      => ["upload-image-1.jpg", "upload-image-1.jpg"],
            "type"      => ["image/jpeg", "image/jpeg"],
            "tmp_name"  => [
                to_system_path(dirname(__DIR__) . "/files/upload-image-1.jpg"),
                to_system_path(dirname(__DIR__) . "/files/upload-image-2.jpg")
            ],
            "error"     => [0, 0],
            "size"      => [1000, 1000],
        ]
    ];
}





// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_HttpFactory()
{
    return new \AeonDigital\EnGarde\Http\Factory();
}
