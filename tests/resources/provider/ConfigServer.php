<?php

// Definição de um objeto $_SERVER
// para os testes
$defaultServerVariables = [
    "DOCUMENT_ROOT"         => $dirResources . DS . "apps",
    "REMOTE_ADDR"           => "200.200.100.50",
    "REMOTE_PORT"           => "64011",
    "SERVER_SOFTWARE"       => "PHP 7.1.1 Development Server",
    "SERVER_PROTOCOL"       => "HTTP/1.1",
    "SERVER_NAME"           => "test.server.com.br",
    "SERVER_PORT"           => "80",

    "REQUEST_METHOD"        => "GET",
    "REQUEST_URI"           => "/",
    "QUERY_STRING"          => "qskey1=valor 1&qskey2=valor 2",

    "SCRIPT_NAME"           => "/index.php",
    "SCRIPT_FILENAME"       => $dirResources . DS . "apps" . DS . "index.php",
    "PHP_SELF"              => "/index.php",

    "HTTP_HOST"             => "test.server.com.br",
    "HTTP_COOKIE"           => "first=primeiro+valor%3A+rianna%40gmail.com; second=segundo+valor%3A+http%3A%2F%2Faeondigital.com.br",

    "HTTP_USER_AGENT"       => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:56.0) Gecko/20100101 Firefox/56.0",
    "HTTP_ACCEPT"           => "text/html, application/xhtml+xml, application/xml;q=0.9, */*;q=0.8",
    "HTTP_ACCEPT_LANGUAGE"  => "pt-BR, pt;q=0.8, en-US;q=0.5, en;q=0.3",
    "HTTP_ACCEPT_ENCODING"  => "gzip, deflate",

    "HTTP_CONNECTION"       => "keep-alive",
    "HTTP_UPGRADE_INSECURE_REQUESTS" => "1",
    "REQUEST_TIME_FLOAT"    => 1507429648.193122,
    "REQUEST_TIME"          => 1507429648,
    "CONTENT_TYPE"          => "text/html; charset=utf-8",
    "CONTENT_LENGTH"        => 1500,
    "PHP_AUTH_USER"         => 1,
    "PHP_AUTH_PW"           => 1,
    "PHP_AUTH_DIGEST"       => 1,
    "AUTH_TYPE"             => 1
];
// Definições complementares para a configuração
// do motor de aplicações.
$defaultEngineVariables = [
    "forceHttps"            => false,
    "environmentType"       => "UTEST",
    "isDebugMode"           => true,
    "isUpdateRoutes"        => true,
    "hostedApps"            => ["site", "blog"],
    "defaultApp"            => "site",
    "rootSubPath"           => "",
    "dateTimeLocal"         => "America/Sao_Paulo",
    "timeout"               => 1200,
    "maxFileSize"           => 100,
    "maxPostSize"           => 100,
    "pathToErrorView"       => "/errorView.phtml",
    "pathToHttpMessageView" => "/httpMessage.phtml",
    "applicationClassName"  => "AppStart",
    "developerHttpMethods"  => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "frameworkHttpMethods"  => ["HEAD", "OPTIONS", "TRACE", "DEV", "CONNECT"]
];





// ---
// Geração de Instâncias de objetos.
function prov_instanceOf_EnGarde_Config_Server(
    $serverVariables = [],
    $uploadedFiles = [],
    $engineVariables = null
) {
    global $defaultEngineVariables;
    $engineVariables = $engineVariables ?? $defaultEngineVariables;

    return new \AeonDigital\EnGarde\Config\Server(
        $serverVariables,
        $uploadedFiles,
        $engineVariables
    );
}
