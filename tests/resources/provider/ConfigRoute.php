<?php

$defaultRoute = [
    "application"               => "site",
    "namespace"                 => "\\site\\controller",
    "controller"                => "home",
    "action"                    => "index",
    "allowedMethods"            => ["GET", "POST"],
    "allowedMimeTypes"          => ["HTML", "JSON"],
    "method"                    => "GET",
    "routes"                    => [
        "/",
        "/index",
        "/home"
    ],
    "isUseXHTML"                => true,
    "runMethodName"             => "run",
    "customProperties"          => [],
    "description"               => "Teste",
    "devDescription"            => "Teste unitário",
    "relationedRoutes"          => [
        "/unit-test"
    ],
    "middlewares"               => [],
    "isSecure"                  => false,
    "isUseCache"                => true,
    "cacheTimeout"              => (60*60*24*7),
    "responseIsPrettyPrint"     => true,
    "responseIsDownload"        => false,
    "responseDownloadFileName"  => "",
    "responseHeaders"           => [],
    "masterPage"                => "masterPage.phtml",
    "view"                      => "/home/index.phtml",
    "styleSheets"               => [
        "main.css",
        "index.css"
    ],
    "javaScripts"               => [
        "main.js",
        "index.js"
    ],
    "metaData"                  => [
        "Framework" => "EnGarde!",
        "Copyright" => "Aeon Digital"
    ],
    "localeDictionary"          => "/locales/pt-br"
];

// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Config_Route($defaultRoute)
{
    return new \AeonDigital\EnGarde\Config\Route(
        $defaultRoute["application"],
        $defaultRoute["namespace"],
        $defaultRoute["controller"],
        $defaultRoute["action"],
        $defaultRoute["allowedMethods"],
        $defaultRoute["allowedMimeTypes"],
        $defaultRoute["method"],
        $defaultRoute["routes"],
        $defaultRoute["isUseXHTML"],
        $defaultRoute["runMethodName"],
        $defaultRoute["customProperties"],
        $defaultRoute["description"],
        $defaultRoute["devDescription"],
        $defaultRoute["relationedRoutes"],
        $defaultRoute["middlewares"],
        $defaultRoute["isSecure"],
        $defaultRoute["isUseCache"],
        $defaultRoute["cacheTimeout"],
        $defaultRoute["responseIsPrettyPrint"],
        $defaultRoute["responseIsDownload"],
        $defaultRoute["responseDownloadFileName"],
        $defaultRoute["responseHeaders"],
        $defaultRoute["masterPage"],
        $defaultRoute["view"],
        $defaultRoute["styleSheets"],
        $defaultRoute["javaScripts"],
        $defaultRoute["metaData"],
        $defaultRoute["localeDictionary"]
    );
}
