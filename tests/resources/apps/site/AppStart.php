<?php
declare (strict_types=1);

namespace site;

use AeonDigital\EnGarde\Domain\Application as Application;
use AeonDigital\EnGarde\Interfaces\Http\iMiddleware as iMiddleware;





/**
 * Classe base da aplicação.
 */
class AppStart extends Application
{



    public function customRun() : void
    {
        $this->testViewDebug = "custom run executed";
    }





    /**
     * Abaixo, segue o registro de métodos que tem como responsabilidade
     * iniciar e retornar instâncias de middlewares.
     *
     * A assinatura dos métodos deve ser compatível com :
     * > protected function middlewareName() : iMiddleware|MiddlewareInterface
     */
    protected function ctrl_mid_01() : iMiddleware
    {
        $mid = new \site\middlewares\TestMiddleware();
        $mid->setFrom("ctrl_mid_01");
        return $mid;
    }
    protected function ctrl_mid_02() : iMiddleware
    {
        $mid = new \site\middlewares\TestMiddleware();
        $mid->setFrom("ctrl_mid_02");
        return $mid;
    }
    protected function ctrl_mid_03() : iMiddleware
    {
        $mid = new \site\middlewares\TestMiddleware();
        $mid->setFrom("ctrl_mid_03");
        return $mid;
    }
    protected function route_mid_01() : iMiddleware
    {
        $mid = new \site\middlewares\TestMiddleware();
        $mid->setFrom("route_mid_01");
        return $mid;
    }
    protected function route_mid_02() : iMiddleware
    {
        $mid = new \site\middlewares\TestMiddleware();
        $mid->setFrom("route_mid_02");
        return $mid;
    }
    protected function route_mid_03() : iMiddleware
    {
        $mid = new \site\middlewares\TestMiddleware();
        $mid->setFrom("route_mid_03");
        return $mid;
    }
}
