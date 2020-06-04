<?php

$defaultSecurity = [
    "isActive"              => true,
    "dataCookieName"        => "cname",
    "securityCookieName"    => "sname",
    "routeToLogin"          => "login",
    "routeToStart"          => "start",
    "routeToResetPassword"  => "reset",
    "anonymousId"           => 1,
    "sessionType"           => "local",
    "isSessionRenew"        => true,
    "sessionTimeout"        => 40,
    "allowedFaultByIP"      => 50,
    "ipBlockTimeout"        => 50,
    "allowedFaultByLogin"   => 5,
    "loginBlockTimeout"     => 20,
    "allowedIPRanges"       => [],
    "deniedIPRanges"        => [],
    "dbCredentials"         => []
];


// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Config_Security(
    $defaultSecurity = null
) {
    return new \AeonDigital\EnGarde\Config\Security(
        $defaultSecurity["isActive"],
        $defaultSecurity["dataCookieName"],
        $defaultSecurity["securityCookieName"],
        $defaultSecurity["routeToLogin"],
        $defaultSecurity["routeToStart"],
        $defaultSecurity["routeToResetPassword"],
        $defaultSecurity["anonymousId"],
        $defaultSecurity["sessionType"],
        $defaultSecurity["isSessionRenew"],
        $defaultSecurity["sessionTimeout"],
        $defaultSecurity["allowedFaultByIP"],
        $defaultSecurity["ipBlockTimeout"],
        $defaultSecurity["allowedFaultByLogin"],
        $defaultSecurity["loginBlockTimeout"],
        $defaultSecurity["allowedIPRanges"],
        $defaultSecurity["deniedIPRanges"],
        $defaultSecurity["dbCredentials"]
    );
}
