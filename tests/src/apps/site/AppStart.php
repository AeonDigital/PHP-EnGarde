<?php
declare (strict_types = 1);

namespace site;

use AeonDigital\EnGarde\DomainApplication as DomainApplication;






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
    }

}
