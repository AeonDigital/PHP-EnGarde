<?php
$baseTargetFileDir =  __DIR__ . "/files";





function provider_PHPEnGarde_InstanceOf_RequestHandler() {
    $reqHand = prov_instanceOf_EnGarde_HttpRequestHandler();
    return new \AeonDigital\EnGarde\RequestHandler($reqHand);
}

function provider_PHPEnGarde_InstanceOf_Middleware($useId) {
    $obj = new \AeonDigital\EnGarde\Tests\Concrete\Middleware01();
    $obj->setId($useId);
    return $obj;
}


function prov_instanceOf_Http_Response_02(
    $headers = null,
    $strBody = null,
    $viewData = null,
    $viewConfig = null
) {
    if ($headers === null) {
        $headers = [];
    }

    if ($strBody === null) {
        $strBody = "";
    }

    if ($viewData === null) {
        $viewData = null;
    }

    if ($viewConfig === null) {
        $viewConfig = null;
    }


    return new \AeonDigital\Http\Message\Response(
        200,
        "",
        "1.1",
        provider_PHPHTTPData_InstanceOf_HeaderCollection($headers),
        provider_PHPStream_InstanceOf_Stream_FromText($strBody),
        $viewData,
        $viewConfig
    );
}

function prov_instanceOf_EnGarde_Config_Route($cfg = null)
{
    $routeConfig = provider_PHPEnGardeConfig_InstanceOf_RouteConfig($cfg);
    $routeConfig->setMasterPage("masterPage.phtml");
    $routeConfig->setView("home/index.phtml");
    $routeConfig->setMetaData([
        "meta01" => "val01"
    ]);

    $routeConfig->setJavaScripts([
        "javascript01.js",
        "javascript02.js"
    ]);

    $routeConfig->setStyleSheets([
        "cssfile01.css",
        "cssfile02.css"
    ]);

    return $routeConfig;
}





function provider_PHPEnGarde_InstanceOf_DomainManager()
{
    $serverConfig = prov_instanceOf_EnGarde_Config_Server(true);
    $httpFactory = prov_instanceOf_EnGarde_HttpFactory();
    $serverConfig->setHttpFactory($httpFactory);


    $domainConfig = prov_instanceOf_EnGarde_Config_Domain(
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
        $serverConfig = prov_instanceOf_EnGarde_Config_Server(
            true, null, null, null, null, $requestMethod, $requestURI
        );
        $httpFactory = prov_instanceOf_EnGarde_HttpFactory();
        $serverConfig->setHttpFactory($httpFactory);
    }


    if ($domainConfig === null) {
        $domainConfig = prov_instanceOf_EnGarde_Config_Domain(
            true, $specialSet, $environmentType, $debugMode, false, to_system_path(__DIR__ . "/apps")
        );
        $domainConfig->setPathToErrorView("errorView.phtml");
    }

    return new \AeonDigital\EnGarde\DomainManager($serverConfig, $domainConfig);
}
