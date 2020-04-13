<?php



// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_EnGarde_Engine_Router()
{
    $applicationConfig = prov_instanceOf_EnGarde_Config_Application();

    return new \AeonDigital\EnGarde\Engine\Router(
        $applicationConfig->getName(),
        $applicationConfig->getPathToAppRoutes(),
        $applicationConfig->getPathToControllers(),
        $applicationConfig->getControllersNamespace(),
        $applicationConfig->getDefaultRouteConfig()
    );
}
