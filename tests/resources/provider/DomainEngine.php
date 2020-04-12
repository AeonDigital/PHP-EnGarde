<?php



// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Domain_Engine(
    $environmentType = "localtest",
    $requestMethod = "GET",
    $requestURI = "/",
    $serverConfig = null,
    $domainConfig = null,
    $specialSet = "0.9.0 [alpha]",
    $debugMode = false
) {
    global $dirResources;

    if ($serverConfig === null) {
        $serverConfig = prov_instanceOf_EnGarde_Config_Server(
            true, null, null, null, null, $requestMethod, $requestURI
        );
        $httpFactory = prov_instanceOf_Http_Factory();
        $serverConfig->setHttpFactory($httpFactory);
    }


    if ($domainConfig === null) {
        $domainConfig = prov_instanceOf_EnGarde_Config_Engine(
            true, $specialSet, $environmentType, $debugMode, false, $dirResources . "/apps"
        );
        $domainConfig->setPathToErrorView("errorView.phtml");
    }

    return new \AeonDigital\EnGarde\Domain\Engine($serverConfig, $domainConfig);
}
