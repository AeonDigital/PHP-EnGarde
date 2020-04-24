<?php
declare (strict_types=1);

namespace site\controllers;





/**
 * Controller
 */
class Home
{

    const defaultRouteConfig = [
        "description"       => "Home.",
        "allowedMimeTypes"  => ["html"],
        "allowedMethods"    => ["GET"],
        "isUseXHTML"        => true
    ];





    /**
     * [Method]      : GET
     * [Description] : Página inicial da aplicação.
     *
     * [Routes]      : /
     *                 /home
     */
    public static $registerRoute_GET_default = [
        "description"       => "Página home da aplicação",
        "allowedMethods"    => ["GET"],
        "routes"            => [ "/", "/home" ],
        "action"            => "default",
        "allowedMimeTypes"  => ["html"]
    ];
    public function default()
    {
    }
}
