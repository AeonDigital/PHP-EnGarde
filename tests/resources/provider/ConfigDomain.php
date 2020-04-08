<?php



// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Config_Domain(
    $autoSet = true,
    $version = "0.9.0 [alpha]",
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
    $domainConfig = new \AeonDigital\EnGarde\Config\Domain();

    if ($autoSet === true) {
        $domainConfig->setVersion($version);
        $domainConfig->setEnvironmentType($environmentType);
        $domainConfig->setIsDebugMode($isDebugMode);
        $domainConfig->setIsUpdateRoutes($isUpdateRoutes);
        $domainConfig->setRootPath($rootPath);
        $domainConfig->setHostedApps($hostedApps);
        $domainConfig->setDefaultApp($defaultApp);
        $domainConfig->setDateTimeLocal($dateTimeLocal);
        $domainConfig->setTimeOut($timeOut);
        $domainConfig->setMaxFileSize($maxFileSize);
        $domainConfig->setMaxPostSize($maxPostSize);
        $domainConfig->setApplicationClassName($applicationClassName);
    }

    return $domainConfig;
}
