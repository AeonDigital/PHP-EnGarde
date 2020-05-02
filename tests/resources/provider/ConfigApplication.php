<?php

// Definição base para um objeto Config\Application
$defaultApplication = [
    "appName"                   => "site",
    "appRootPath"               => $dirResources . DS . "apps" . DS . "site",
    "pathToAppRoutes"           => "/AppRoutes.php",
    "pathToControllers"         => "/controllers",
    "pathToViews"               => "/views",
    "pathToViewsResources"      => "/resources",
    "pathToLocales"             => "/locales",
    "pathToCacheFiles"          => "/cache",
    "startRoute"                => "/home",
    "controllersNamespace"      => "\\site\\controllers",
    "locales"                   => ["pt-BR", "en-US"],
    "defaultLocale"             => "pt-BR",
    "isUseLabels"               => true,
    "defaultRouteConfig"        => [],
    "pathToErrorView"           => "/errorView.phtml",
    "httpSubSystemNamespaces"   => [
        "HEAD" => "\\subsystem\\responseHEAD"
    ]
];





// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Config_Application(
    $defaultApplication
) {
    return new \AeonDigital\EnGarde\Config\Application(
        $defaultApplication["appName"],
        $defaultApplication["appRootPath"],
        $defaultApplication["pathToAppRoutes"],
        $defaultApplication["pathToControllers"],
        $defaultApplication["pathToViews"],
        $defaultApplication["pathToViewsResources"],
        $defaultApplication["pathToLocales"],
        $defaultApplication["pathToCacheFiles"],
        $defaultApplication["startRoute"],
        $defaultApplication["controllersNamespace"],
        $defaultApplication["locales"],
        $defaultApplication["defaultLocale"],
        $defaultApplication["isUseLabels"],
        $defaultApplication["defaultRouteConfig"],
        $defaultApplication["pathToErrorView"],
        $defaultApplication["httpSubSystemNamespaces"]
    );
}
