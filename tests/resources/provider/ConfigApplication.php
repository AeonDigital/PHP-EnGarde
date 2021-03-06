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
    "pathToLocalData"           => "/localData",
    "startRoute"                => "/home",
    "controllersNamespace"      => "\\site\\controllers",
    "locales"                   => ["pt-BR", "en-US"],
    "defaultLocale"             => "pt-BR",
    "isUseLabels"               => true,
    "defaultRouteConfig"        => [],
    "checkRouteOrder"           => ["native"],
    "pathToErrorView"           => "/errorView.phtml",
    "pathToHttpMessageView"     => "/httpMessage.phtml",
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
        $defaultApplication["pathToLocalData"],
        $defaultApplication["startRoute"],
        $defaultApplication["controllersNamespace"],
        $defaultApplication["locales"],
        $defaultApplication["defaultLocale"],
        $defaultApplication["isUseLabels"],
        $defaultApplication["defaultRouteConfig"],
        $defaultApplication["checkRouteOrder"],
        $defaultApplication["pathToErrorView"],
        $defaultApplication["pathToHttpMessageView"],
        $defaultApplication["httpSubSystemNamespaces"]
    );
}
