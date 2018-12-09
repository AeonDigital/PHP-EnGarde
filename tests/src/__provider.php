<?php
$baseTargetFileDir =  __DIR__ . "/files";



function provider_PHPEnGarde_InstanceOf_DomainManager() 
{
    $serverConfig = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(true);
    $httpFactory = provider_PHPEnGardeConfig_InstanceOf_HttpFactory();
    $serverConfig->setHttpFactory($httpFactory);


    $domainConfig = provider_PHPEnGardeConfig_InstanceOf_DomainConfig(
        true, "0.9.0 [alpha]", "test", false, false, to_system_path(__DIR__ . "/apps")
    );
    $domainConfig->setPathToErrorView("errorView.phtml");


    return new \AeonDigital\EnGarde\DomainManager($serverConfig, $domainConfig);
}


function provider_PHPEnGarde_InstanceOf_DomainManager_AutoSet(
    $environmentType = "localtest",
    $requestMethod = "GET",
    $requestURI = "/",
    $serverConfig = null,
    $domainConfig = null,
    $specialSet = "0.9.0 [alpha]",
    $debugMode = false
) {
    if ($serverConfig === null) {
        $serverConfig = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(
            true, null, null, null, null, $requestMethod, $requestURI
        );
        $httpFactory = provider_PHPEnGardeConfig_InstanceOf_HttpFactory();
        $serverConfig->setHttpFactory($httpFactory);
    }


    if ($domainConfig === null) {
        $domainConfig = provider_PHPEnGardeConfig_InstanceOf_DomainConfig(
            true, $specialSet, $environmentType, $debugMode, false, to_system_path(__DIR__ . "/apps")
        );
        $domainConfig->setPathToErrorView("errorView.phtml");
    }

    return new \AeonDigital\EnGarde\DomainManager($serverConfig, $domainConfig);
}
