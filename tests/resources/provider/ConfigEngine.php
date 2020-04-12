<?php



// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Config_Engine(
    $autoSet = true,
    $environmentType = "test",
    $isDebugMode = false,
    $isUpdateRoutes = false,
    $rootPath = "",
    $hostedApps = ["site", "blog"],
    $defaultApp = "site",
    $dateTimeLocal = "America/Sao_Paulo",
    $timeOut = 1200,
    $maxFileSize = 100,
    $maxPostSize = 100,
    $applicationClassName = "AppStart"
) {
    $rootPath = (($rootPath === "") ? to_system_path(dirname(__DIR__) . "/apps") : $rootPath);
    $engineConfig = new \AeonDigital\EnGarde\Config\Engine();

    if ($autoSet === true) {
        $engineConfig->setEnvironmentType($environmentType);
        $engineConfig->setIsDebugMode($isDebugMode);
        $engineConfig->setIsUpdateRoutes($isUpdateRoutes);
        $engineConfig->setRootPath($rootPath);
        $engineConfig->setHostedApps($hostedApps);
        $engineConfig->setDefaultApp($defaultApp);
        $engineConfig->setDateTimeLocal($dateTimeLocal);
        $engineConfig->setTimeOut($timeOut);
        $engineConfig->setMaxFileSize($maxFileSize);
        $engineConfig->setMaxPostSize($maxPostSize);
        $engineConfig->setApplicationClassName($applicationClassName);
    }

    return $engineConfig;
}
