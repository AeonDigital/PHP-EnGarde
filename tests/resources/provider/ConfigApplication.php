<?php



// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Config_Application(
    $autoSet = true,
    $name = "site",
    $rootPath = "",
    $controllersNamespace = "site\\controllers",
    $startRoute = "/",
    $appRootPath = "",
    $pathToControllers = "/controllers",
    $pathToLocales = null,
    $pathToCacheFiles = null,
    $pathToViews = null,
    $pathToAppRoutes = null,
    $pathToTargetLocale = null,
    $pathToMasterPage = null
) {
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

    return $applicationConfig;
}



function prov_instanceOf_EnGarde_Config_Application_autoSet(
    $appName = "",
    $rootPath = "",
    $settings = null
) {
    return new \AeonDigital\EnGarde\Config\Application($appName, $rootPath, $settings);
}
