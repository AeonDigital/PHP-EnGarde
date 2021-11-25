<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\EnGarde\Interfaces\Engine\iController as iController;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;






/**
 * Classe abstrata que deve ser herdada pelos controllers das aplicações.
 *
 * @codeCoverageIgnore
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
abstract class MainController implements iController
{
    use \AeonDigital\EnGarde\Traits\ActionTools;





    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância ``iServerConfig``.
     *
     * @param       iResponse $response
     *              Instância ``iResponse``.
     */
    function __construct(
        iServerConfig $serverConfig,
        iResponse $response
    ) {
        $this->serverConfig = $serverConfig;
        $this->routeConfig  = $serverConfig->getRouteConfig();
        $this->response     = $response;

        $this->viewData     = new \stdClass();
        $this->viewConfig   = new \stdClass();

        if ($this->serverConfig->hasDefinedSecuritySettings() === true &&
            $this->serverConfig->getSecuritySession()->hasDataBase() === true) {
            $this->DAL = $this->serverConfig->getSecuritySession()->getDAL();
        }
    }










    /**
     * Retorna a instância ``iResponse``.
     *
     * Aplica no objeto ``iResponse`` as propriedades ``viewData``, ``viewConfig`` e
     * ``headers``. Todos manipuláveis durante a execução da action.
     *
     * @return      iResponse
     */
    public function getResponse() : iResponse
    {
        return $this->response->withActionProperties(
            $this->viewData,
            $this->viewConfig,
            $this->serverConfig->getRouteConfig()->getResponseHeaders()
        );
    }
}
