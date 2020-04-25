<?php
declare (strict_types=1);

namespace site\controllers;

use AeonDigital\EnGarde\MainController as MainController;



/**
 * Controller
 */
class Documentation extends MainController
{

    const defaultRouteConfig = [
        "description"       => "Home.",
        "allowedMimeTypes"  => ["html", "xhtml", "json"],
        "allowedMethods"    => ["GET"],
        "isUseXHTML"        => true
    ];


    //
    // Caso:        Verificação de rota não encontrada
    // Objetivo 01: Verificar se, quando digitado o nome de uma rota inexistente o framework irá
    //              mostrar o erro 404.
    //
    // URL:         /notexists


    //
    // Caso:        Verificação de método HTTP inválido
    // Objetivo 01: Verificar se, quando forçado um método HTTP não configurado, o framework irá mostrar
    //              o erro 501.
    //
    // URL:         /?_method=PUT


    //
    // Caso:        Redirecionamento para normalizar nome da aplicação
    // Objetivo 01: Verificar se, quando digitado o nome de uma aplicação válida, porem com ,
    //              case diferente do esperado a aplicação fará a "normalização", enviando o UA
    //              para a mesma rota em que estava, porem, com o nome da aplicação correto.
    //
    // URL:         /SITE


    //
    // Caso:        Negociação de conteúdo
    // Objetivo 01: Mostrar que é possível selecionar o Locale no qual a Aplicação será servida
    //              usando o parametro "_locale" na URL
    // URL:         /?_locale=en-US
    //
    // Objetivo 02: Mostrar que é possível selecionar o Mime no qual a Aplicação será servida
    //              usando o parametro "_mime" na URL
    // URL:         /?_mime=html
    //
    // Objetivo 03: Mostrar que é possível definir "isPrettyPrint" usando o parametro
    //              "_pretty_print" na URL
    // URL:         /?_pretty_print=true
    //
    // Objetivo 04: Mostrar que é possível definir "isDownload" usando o parametro
    //              "_download" na URL
    // URL:         /?_download=true


    //
    // Caso:        Mostrar erro personalizado
    // Objetivo 01: Verificar se a página de erros personalizado da aplicação está sendo carregada.
    //
    // URL:         /?_locale=invalid
    // URL:         /?_mime=invalid






    public static $registerRoute_GET_first = "/documentation first";
    public function first() {
        $this->routeConfig->setMasterPage("masterPage.phtml");
        $this->routeConfig->setView("/home/index.phtml");
        $this->viewData->appTitle = "Site";
        $this->viewData->viewTitle = "Página inicial";
    }



    public static $registerRoute_GET_first_alt = [
        "description"       => "Página alternativa à primeira... com um método 'run' diferente.",
        "allowedMethods"    => ["GET"],
        "routes"            => ["/first"],
        "action"            => "first",
        "runMethodName"     => "alternateRun"
    ];





    public static $registerRoute_GET_second = [
        "description"       => "Segunda página da aplicação",
        "allowedMethods"    => ["GET"],
        "routes"            => ["/second"],
        "action"            => "second"
    ];
    public function second()
    {
        echo "In Second page!";
    }
}
