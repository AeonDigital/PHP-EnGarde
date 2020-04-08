<?php



// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Config_Server(
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
    $obj = new \AeonDigital\EnGarde\Config\Server([], true);
    $serverData = [];

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
