<?php
$baseTargetFileDir =  __DIR__ . "/files";
$defaultServerConfig = null;




function provider_PHPEnGardeConfig_DefineServerFiles()
{
    $_FILES = [
        "fieldOne" => [
            "name"      => "ua-file-name.png",
            "type"      => "image/png",
            "tmp_name"  => to_system_path(__DIR__ . "/files/image-resource.jpg"),
            "error"     => 0,
            "size"      => 1000
        ],
        "multiField" => [
            "name"      => ["upload-image-1.jpg", "upload-image-1.jpg"],
            "type"      => ["image/jpeg", "image/jpeg"],
            "tmp_name"  => [
                to_system_path(__DIR__ . "/files/upload-image-1.jpg"),
                to_system_path(__DIR__ . "/files/upload-image-2.jpg")
            ],
            "error"     => [0, 0],
            "size"      => [1000, 1000],
        ]
    ];
}





function provider_PHPEnGardeConfig_InstanceOf_ConfigRoute($cfg = null)
{
    return new \AeonDigital\EnGarde\Config\Route($cfg);
}



function provider_PHPEnGardeConfig_InstanceOf_ConfigApplication_AutoSet(
    $appName = "",
    $rootPath = "",
    $settings = null
) {
    return new \AeonDigital\EnGarde\Config\Application($appName, $rootPath, $settings);
}



function provider_PHPEnGardeConfig_InstanceOf_ConfigSecurity_AutoSet(
    $settings = null
) {
    if ($settings === null) {
        $settings = [
            "active"                => true,
            "dataCookieName"        => "cname",
            "securityCookieName"    => "sname",
            "routeToLogin"          => "login",
            "routeToStart"          => "start",
            "routeToResetPassword"  => "reset",
            "anonymousId"           => 1,
            "sessionType"           => "local",
            "sessionRenew"          => true,
            "sessionTimeout"        => 11,
            "allowedFaultByIP"      => 12,
            "ipBlockTimeout"        => 13,
            "allowedFaultByLogin"   => 14,
            "loginBlockTimeout"     => 15
        ];
    }
    return \AeonDigital\EnGarde\Config\Security::fromArray($settings);
}



function provider_PHPEnGardeConfig_InstanceOf_ConfigDomain(
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
    $rootPath = (($rootPath === "") ? to_system_path(__DIR__ . "/apps") : $rootPath);
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












function provider_PHPEnGardeConfig_InstanceOf_HttpFactory()
{
    return new \AeonDigital\EnGarde\Config\HttpFactory();
}


function provider_PHPEnGardeConfig_InstanceOf_ServerConfig(
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
            $httpHeaderAccept = "text/html, application/xhtml+xml, application/xml;q=0.9, */*;q=0.8";
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






function provider_PHPEnGardeConfig_InstanceOf_ApplicationConfig(
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


function provider_PHPEnGardeConfig_InstanceOf_ApplicationRouter()
{
    $applicationConfig = provider_PHPEnGardeConfig_InstanceOf_ApplicationConfig();

    return new \AeonDigital\EnGarde\Config\ApplicationRouter(
        $applicationConfig->getName(),
        $applicationConfig->getPathToAppRoutes(),
        $applicationConfig->getPathToControllers(),
        $applicationConfig->getControllersNamespace(),
        $applicationConfig->getDefaultRouteConfig()
    );
}


function provider_PHPEnGardeConfig_Configure_ErrorListening(
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
