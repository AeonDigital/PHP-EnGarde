<?php



// ---
// Objetos e processos de uso variado.




// ---
// Geração de Instâncias de objetos.

function provider_PHPEnGarde_InstanceOf_ConfigDomain(
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




/*
$baseTargetFileDir =  __DIR__ . "/files";
$defaultServerConfig = null;















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
    $serverRequest = $serverRequest->withCookieParams([]);


    $response = null;
    $routeConfig = null;
    $tempAppRoutes = require(__DIR__ . "/concrete/AppRoutes.php");
    if ($requestMethod === "OPTIONS" || $requestMethod === "TRACE") {
        $response = provider_PHPHTTPMessage_InstanceOf_Response();
    } else {
        $routeConfig = provider_PHPEnGarde_InstanceOf_RouteConfig($tempAppRoutes["simple"]["/^\\/site\\//"][$requestMethod]);

        $routeMime = $routeConfig->negotiateMimeType(
            $serverRequest->getResponseMimes(),
            $serverRequest->getParam("_mime")
        );
        $routeConfig->setResponseMime($routeMime["mime"]);
        $routeConfig->setResponseMimeType($routeMime["mimetype"]);

        $isDownload_route = $routeConfig->getResponseIsDownload();
        $isDownload_param = $serverRequest->getParam("_download");
        if ($isDownload_param !== null) {
            $isDownload_param = ($isDownload_param === "true" || $isDownload_param === "1");
        }
        $routeConfig->setResponseIsDownload(
            (
                $isDownload_param === true ||
                (
                    ($isDownload_param === null || $isDownload_param === true) &&
                    $isDownload_route === true
                )
            )
        );

        $prettyPrint = $serverRequest->getParam("_pretty_print");
        $routeConfig->setResponseIsPrettyPrint(($prettyPrint === "true" || $prettyPrint === "1"));





        $viewData = (object)[
            "appTitle" => "Application Title",
            "viewTitle" => "View Title",
            "mimeContent" => null
        ];


        $mime = $routeConfig->getResponseMime();

        if ($mime === "html") {
            $viewData->mimeContent = "This is a HTML document.";
        }
        elseif ($mime === "xhtml") {
            $viewData->mimeContent = "This is a X/HTML document.";
        }
        elseif ($mime === "json") {
            $viewData->mimeContent = "This is a JSON document.";
        }
        elseif ($mime === "txt") {
            $routeConfig->setMasterPage(null);
            $routeConfig->setView(null);

            $viewData->subData = [
                "attr1" => "val1",
                "attr2" => "val2",
                "attr3" => "val3",
                "attr4" => 8383738,
                "attr5" => new \DateTime("2000-01-01 00:00:00"),
                "attr6" => $routeConfig
            ];
        }
        elseif ($mime === "xml") {
            $routeConfig->setMasterPage(null);
            $routeConfig->setView(null);
        }
        elseif ($mime === "csv" || $mime === "xls" || $mime === "xlsx") {
            $viewData->metaData = (object)[
                "authorName" => "Rianna Cantarelli",
                "companyName" => "Aeon Digital",
                "createdDate" => new \DateTime("2019-02-10 10:10:10"),
                "keywords" => "key1, key2, key3",
                "description" => "Teste de criação de planilhas"
            ];
            $viewData->dataTable = [
                ["nome", "email", "categoria", "cpf", "number", "data"],
                ["n1\"com aspas e acentuação", "email@1", "cat1", "cpf1", 1, new \DateTime("2001-01-01 01:01:01")],
                ["n2", "email@2", "cat2", "cpf2", 2, new \DateTime("2002-02-02 02:02:02")],
                ["n3", "email@3", "cat3", "cpf3", 3, new \DateTime("2003-03-03 03:03:03")],
                ["n4", "email@4", "cat4", "cpf4", 4, new \DateTime("2004-04-04 04:04:04")]
            ];
        }
        elseif ($mime === "pdf") {
            $routeConfig->setMasterPage("masterPagePDF.phtml");
            $routeConfig->setView("home/indexPDF.phtml");
            $viewData->mimeContent = "This is a PDF document.";
            $viewData->metaData = (object)[
                "authorName" => "Rianna Cantarelli",
                "companyName" => "Aeon Digital",
                "createdDate" => new \DateTime("2019-02-10 10:10:10"),
                "keywords" => "key1, key2, key3",
                "description" => "Teste de criação de planilhas"
            ];
        }


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


        // Identifica se é para usar "pretty print" no código fonte de retorno
        $prettyPrint = $serverRequest->getParam("_pretty_print");
        $routeConfig->setResponseIsPrettyPrint(($prettyPrint === "true" || $prettyPrint === "1"));
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













function provider_PHPEnGarde_InstanceOf_ServerConfig(
    $autoSet = true,
    $serverIP = null,
    $serverPort = null,
    $serverDomain = null,
    $serverScript = null,
    $requestMethod = null,
    $requestURI = null,
    $requestQueryString = null,
    $requestCookies = null,
    $httpHeaderContentType = null,
    $httpHeaderUserAgent = null,
    $httpHeaderAccept = null,
    $httpHeaderAcceptLanguage = null,
    $httpHeaderAcceptEncoding = null
) {
    global $defaultServerConfig;
    $obj = new \AeonDigital\EnGarde\Config\ServerConfig(null, true);
    $serverData = null;

    if ($autoSet === true) {
        if ($serverIP === null) {
            $serverIP = "200.200.100.50";
        }
        if ($serverPort === null) {
            $serverPort = 80;
        }
        if ($serverDomain === null) {
            $serverDomain = "test.server.com.br";
        }
        if ($serverScript === null) {
            $serverScript = "/index.php";
        }
        if ($requestMethod === null) {
            $requestMethod = "GET";
        }
        if ($requestURI === null) {
            $requestURI = "/";
        }
        if ($requestQueryString === null) {
            $requestQueryString = "qskey1=valor 1&qskey2=valor 2";
        }
        if ($requestCookies === null) {
            $requestCookies = "first=primeiro+valor%3A+rianna%40gmail.com; second=segundo+valor%3A+http%3A%2F%2Faeondigital.com.br";
        }
        if ($httpHeaderContentType === null) {
            $httpHeaderContentType = "text/html; charset=utf-8";
        }
        if ($httpHeaderUserAgent === null) {
            $httpHeaderUserAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0";
        }
        if ($httpHeaderAccept === null) {
            $httpHeaderAccept = "text/html, application/xhtml+xml, application/xml;q=0.9, * /*;q=0.8";
        }
        if ($httpHeaderAcceptLanguage === null) {
            $httpHeaderAcceptLanguage = "pt-BR, pt;q=0.8, en-US;q=0.5, en;q=0.3";
        }
        if ($httpHeaderAcceptEncoding === null) {
            $httpHeaderAcceptEncoding = "gzip, deflate";
        }

        $documentRoot = "/var/www/html";
        $serverData = [
            "DOCUMENT_ROOT"         => $documentRoot,
            "REMOTE_ADDR"           => $serverIP,
            "REMOTE_PORT"           => "64011",
            "SERVER_SOFTWARE"       => "PHP 7.1.1 Development Server",
            "SERVER_PROTOCOL"       => "HTTP/1.1",
            "SERVER_NAME"           => $serverDomain,
            "SERVER_PORT"           => $serverPort,

            "REQUEST_METHOD"        => $requestMethod,
            "REQUEST_URI"           => $requestURI,
            "QUERY_STRING"          => $requestQueryString,

            "SCRIPT_NAME"           => $serverScript,
            "SCRIPT_FILENAME"       => $documentRoot . $serverScript,
            "PHP_SELF"              => $serverScript,

            "HTTP_HOST"             => $serverDomain,
            "HTTP_COOKIE"           => $requestCookies,

            "HTTP_USER_AGENT"       => $httpHeaderUserAgent,
            "HTTP_ACCEPT"           => $httpHeaderAccept,
            "HTTP_ACCEPT_LANGUAGE"  => $httpHeaderAcceptLanguage,
            "HTTP_ACCEPT_ENCODING"  => $httpHeaderAcceptEncoding,

            "HTTP_CONNECTION"       => "keep-alive",
            "HTTP_UPGRADE_INSECURE_REQUESTS" => "1",
            "REQUEST_TIME_FLOAT"    => 1507429648.193122,
            "REQUEST_TIME"          => 1507429648,
            "CONTENT_TYPE"          => $httpHeaderContentType,
            "CONTENT_LENGTH"        => 1500,
            "PHP_AUTH_USER"         => 1,
            "PHP_AUTH_PW"           => 1,
            "PHP_AUTH_DIGEST"       => 1,
            "AUTH_TYPE"             => 1
        ];

        $defaultServerConfig = $serverData;
    }


    $obj->setServerVariables($serverData);
    return $obj;
}






function provider_PHPEnGarde_InstanceOf_ApplicationConfig(
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
    $rootPath   = (($rootPath === "")   ? to_system_path(__DIR__ . "/apps")         : $rootPath) . DIRECTORY_SEPARATOR;
    $appRootPath= (($appRootPath === "")? to_system_path($rootPath . "/" . $name)   : $appRootPath) . DIRECTORY_SEPARATOR;

    $applicationConfig = new \AeonDigital\EnGarde\Config\ApplicationConfig();
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


function provider_PHPEnGarde_InstanceOf_ApplicationRouter()
{
    $applicationConfig = provider_PHPEnGarde_InstanceOf_ApplicationConfig();

    return new \AeonDigital\EnGarde\Config\ApplicationRouter(
        $applicationConfig->getName(),
        $applicationConfig->getPathToAppRoutes(),
        $applicationConfig->getPathToControllers(),
        $applicationConfig->getControllersNamespace(),
        $applicationConfig->getDefaultRouteConfig()
    );
}


function provider_PHPEnGarde_Configure_ErrorListening(
    $debugMode = false,
    $env = "test",
    $method = "get",
    $pathToErrorView = null
) {
    \AeonDigital\EnGarde\Config\ErrorListening::setContext(
        __DIR__,
        $env,
        $debugMode,
        "http",
        $method,
        $pathToErrorView
    );
}
*/
