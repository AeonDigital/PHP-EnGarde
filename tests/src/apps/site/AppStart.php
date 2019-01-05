<?php
declare (strict_types = 1);

namespace site;

use AeonDigital\EnGarde\DomainApplication as DomainApplication;
use AeonDigital\EnGarde\Interfaces\iMiddleware as iMiddleware;





/**
 * Classe base da aplicação.
 */
class AppStart extends DomainApplication
{



    public function configureApplication() : void
    {
        $this->applicationConfig->setLocales(["pt-BR", "en-US"]);
        $this->applicationConfig->setDefaultLocale("pt-BR");
        $this->applicationConfig->setIsUseLabels(true);
        $this->applicationConfig->setPathToErrorView("/views/_shared/errorView.phtml");

        if ($this->domainConfig->getVersion() !== "0.9.0 [alpha]") {
            $this->runMethodName = $this->domainConfig->getVersion();
        }

        
        // Define as especificações de rota válidas para toda a aplicação.
        $this->applicationConfig->setDefaultRouteConfig([
            "masterPage" => "masterpage.phtml"
        ]);
    }





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
