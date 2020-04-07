<?php



// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Config_Security_autoSet(
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
