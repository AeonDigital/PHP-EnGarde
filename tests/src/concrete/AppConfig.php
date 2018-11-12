<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Tests\Concrete;

use AeonDigital\EnGarde\DomainApplication as DomainApplication;








/**
 * Classe concreta para "DomainApplication".
 */
class AppConfig extends DomainApplication
{
    const defaultRouteConfig = [
        "description" => "Descrição genérica.",
        "acceptmimes" => ["xhtml", "html"],
        "isusexhtml" => true,
        "middlewares" => ["app_mid_01", "app_mid_02", "app_mid_03"],
        "metadata" => [
            "Author" => "Aeon Digital",
            "CopyRight" => "20xx Aeon Digital",
            "FrameWork" => "CodeCraft 0.9.0 [alpha]"
        ]
    ];


    public function configureApplication() : void {}
}
