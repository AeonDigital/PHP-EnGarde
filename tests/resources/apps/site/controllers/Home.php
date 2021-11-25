<?php
declare (strict_types=1);

namespace site\controllers;










/**
 * Test Controller
 */
class Home
{

    const defaultRouteConfig = [
        "description"       => "Descrição genérica no controller.",
        "allowedMimeTypes"  => ["xhtml", "html", "txt"],
        "allowedMethods"    => "get",
        "isUseXHTML"        => true,
        "middlewares"       => ["ctrl_mid_01", "ctrl_mid_02", "ctrl_mid_03"],
        "metaData"          => [
            "Author" => "Aeon Digital",
            "CopyRight" => "20xx Aeon Digital",
            "FrameWork" => "PHP-AeonDigital\EnGarde 0.9.0 [alpha]"
        ]
    ];



    public static $registerRoute_GET_test = "GET /test test public no-cache";




    /**
     * [Method]      : GET
     * [Description] : Página inicial da aplicação.
     *
     * [Routes]      : /
     *                 /home
     */
    public static $registerRoute_GET_POST_default = [
        "description"       => "Página home da aplicação",

        "allowedMethods"    => ["GET", "POST"],
        "routes" => [
            "/",
            "/home"
        ],
        "action" => "default",

        "relationedRoutes" => ["/list"],

        "isSecure" => false,
        "allowedMimeTypes" => ["xhtml", "html", "txt", "json", "xml", "csv", "xls"],

        "isUseCache" => false,
        "cacheTimeout" => (2 * 60),

        "responseIsDownload" => false,
        "responseDownloadFileName" => "bem_vindo",
        "middlewares" => ["route_mid_01", "route_mid_02", "route_mid_03"]
    ];
    public function default()
    {
    }





    /**
     * [Methods]     : GET
     * [Description] : Evoca a view de lista.
     *
     * [Routes]      : /list
     *                 /list/orderby:[a-zA-Z]+
     */
    public static $registerRoute_GET_list = [
        "description" => "Evoca a view de lista.",

        "allowedMethods" => "GET",
        "routes" => [
            "/list",
            "/list/orderby:[a-zA-Z]+",
            "/list/orderby:[a-zA-Z]+/page:[0-9]+",
            "/configurando-uma-rota/propriedades/propertie:[a-zA-Z]+"
        ],
        "action" => "list",
        "allowedMimeTypes" => ["xhtml", "html"],
    ];
    public function list()
    {
    }





    /**
     * [Methods]     : GET
     * [Description] : Evoca a view par ao formulário de contato.
     *
     * [Routes]      : /contact
     */
    public static $registerRoute_GET_contact = [
        "description" => "Evoca a view para o formulário de contato.",

        "allowedMethods" => "GET",
        "routes" => [
            "/contact"
        ],
        "action" => "contact",
        "allowedMimeTypes" => ["xhtml", "html"],
        "isUseCache" => false,
    ];
    /**
     * [Methods]     : POST
     * [Description] : Recebe e processa os dados recebidos pelo formulário.
     *
     * [Routes]      : /contact
     */
    public static $registerRoute_POST_contact = [
        "description" => "Recebe os dados submetidos pelo formulário de contato, processa-os e retorna o resultado.",

        "allowedMethods" => "POST",
        "routes" => [
            "/contact"
        ],
        "action" => "contact",

        "allowedMimeTypes" => ["json", "xhtml", "html"],
        "isUseCache" => false,
        //"form"              => "/Site/FormModels/contact.php"
    ];
    public function contact()
    {
    }



}
