<?php

// Definição base para um objeto Config\Application
$defaultApplication = [
    "appName"               => "site",
    "appRootPath"           => $dirResources . DS . "apps" . DS . "site",
    "pathToAppRoutes"       => "/AppRoutes.php",
    "pathToControllers"     => "/controllers",
    "pathToViews"           => "/views",
    "pathToViewsResources"  => "/resources",
    "pathToLocales"         => "/locales",
    "pathToCacheFiles"      => "/cache",
    "startRoute"            => "/home",
    "controllersNamespace"  => "controllers",
    "locales"               => ["pt-BR", "en-US"],
    "defaultLocale"         => "pt-BR",
    "isUseLabels"           => true,
    "defaultRouteConfig"    => [],
    "pathToErrorView"       => "/errorView.phtml"
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
        $defaultApplication["pathToErrorView"]
    );
    /*
    $rootPath   = (($rootPath === "")   ? to_system_path(dirname(__DIR__) . "/apps"): $rootPath) . DIRECTORY_SEPARATOR;
    $appRootPath= (($appRootPath === "")? to_system_path($rootPath . "/" . $name)   : $appRootPath) . DIRECTORY_SEPARATOR;

    $applicationConfig = new \AeonDigital\EnGarde\Config\Application();
    if ($autoSet === true) {
        $applicationConfig->autoSetProperties($name, $rootPath);
    } else {
        $applicationConfig->setName($name);
        $applicationConfig->setControllersNamespace($controllersNamespace);
        $applicationConfig->setStartRoute($startRoute);
        $applicationConfig->setAppRootPath($appRootPath);
        $applicationConfig->setPathToControllers($pathToControllers);
        $applicationConfig->setPathToLocales($pathToLocales);
        $applicationConfig->setPathToCacheFiles($pathToCacheFiles);
        $applicationConfig->setPathToViews($pathToViews);
        $applicationConfig->setPathToAppRoutes($pathToAppRoutes);
        $applicationConfig->setPathToTargetLocale($pathToTargetLocale);
        $applicationConfig->setPathToMasterPage($pathToMasterPage);
    }


    $applicationConfig->setDefaultRouteConfig([
        "description" => "Descrição genérica.",
        "acceptmimes" => ["xhtml", "html"],
        "isusexhtml" => true,
        "middlewares" => ["app_mid_01", "app_mid_02", "app_mid_03"],
        "metadata" => [
            "Author" => "Aeon Digital",
            "CopyRight" => "20xx Aeon Digital",
            "FrameWork" => "PHP-Domain 0.9.0 [alpha]"
        ]
    ]);

    return $applicationConfig;*/
}
