<?php
$baseTargetFileDir =  __DIR__ . "/files";




function provider_PHPEnGarde_InstanceOf_Concrete_RequestHandler() {
    return new \AeonDigital\EnGarde\Tests\Concrete\RequestHandler01();
}

function provider_PHPEnGarde_InstanceOf_RequestHandler() {
    $reqHand = provider_PHPEnGarde_InstanceOf_Concrete_RequestHandler();
    return new \AeonDigital\EnGarde\RequestHandler($reqHand);
}

function provider_PHPEnGarde_InstanceOf_Middleware($useId) {
    $obj = new \AeonDigital\EnGarde\Tests\Concrete\Middleware01();
    $obj->setId($useId);
    return $obj;
}


function provider_PHPEnGarde_InstanceOf_ResponseHandler(
    $environmentType = "localtest",
    $requestMethod = "GET",
    $url = "http://aeondigital.com.br",
    $serverConfig = null,
    $domainConfig = null,
    $applicationConfig = null,
    $specialSet = "0.9.0 [alpha]",
    $debugMode = false
) {
    $serverRequest = provider_PHPHTTPMessage_InstanceOf_ServerRequest_02($requestMethod, $url);

    $response = null;
    $routeConfig = null;
    $tempAppRoutes = require(__DIR__ . "/concrete/AppRoutes.php");
    if ($requestMethod === "OPTIONS" || $requestMethod === "TRACE") {
        $response = provider_PHPHTTPMessage_InstanceOf_Response();
    } else {
        $routeConfig = provider_PHPEnGarde_InstanceOf_RouteConfig($tempAppRoutes["simple"]["/^\\/site\\//"][$requestMethod]);

        $viewData = (object)[
            "appTitle" => "Application Title",
            "viewTitle" => "View Title",
        ];

        $response = provider_PHPEnGarde_InstanceOf_Response(
            null,
            null,
            $viewData,
            null
        );
    }


    if ($serverConfig === null) {
        $serverConfig = provider_PHPEnGardeConfig_InstanceOf_ServerConfig(
            true, null, null, null, null, $requestMethod, $serverRequest->getUri()->getRelativeUri()
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

    if ($applicationConfig === null) {
        $applicationConfig = provider_PHPEnGardeConfig_InstanceOf_ApplicationConfig(
            true,
            "site",
            to_system_path(__DIR__ . "/apps")
        );
        $applicationConfig->setLocales(["pt-BR", "en-US"]);
        $applicationConfig->setDefaultLocale("pt-BR");
    }



    if ($routeConfig !== null) {
        // Verifica qual locale deve ser usado para responder 
        // esta requisição
        $useLocale = $routeConfig->negotiateLocale(
            $serverRequest->getResponseLocales(),
            $serverRequest->getResponseLanguages(),
            $applicationConfig->getLocales(),
            $applicationConfig->getDefaultLocale(),
            $serverRequest->getParam("_locale")
        );
        $routeConfig->setResponseLocale($useLocale);



        // Verifica qual mimetype deve ser usado para responder 
        // esta requisição
        $routeMime = $routeConfig->negotiateMimeType(
            $serverRequest->getResponseMimes(),
            $serverRequest->getParam("_mime")
        );
        $routeConfig->setResponseMime($routeMime["mime"]);
        $routeConfig->setResponseMimeType($routeMime["mimetype"]);
    }



    return new \AeonDigital\EnGarde\ResponseHandler(
        $serverConfig,
        $domainConfig,
        $applicationConfig,
        $serverRequest,
        $tempAppRoutes["simple"]["/^\\/site\\//"],
        $routeConfig,
        $response
    );
}


function provider_PHPEnGarde_InstanceOf_Response(
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

function provider_PHPEnGarde_InstanceOf_RouteConfig($cfg = null) 
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
