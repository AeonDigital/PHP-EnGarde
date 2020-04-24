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





    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    protected iServerConfig $serverConfig;
    /**
     * Objeto ``iResponse``.
     *
     * @var         iResponse
     */
    protected iResponse $response;
    /**
     * Objeto ``stdClass``.
     *
     * Deve ser preenchido durante a execução da ``Action`` e poderá ser acessado nas views.
     * Tem como finalidade agregar todas as informações que o ``UA`` está requisitando.
     *
     * @var         \stdClass
     */
    protected \stdClass $viewData;
    /**
     * Objeto ``stdClass``.
     *
     * Deve ser preenchido durante a execução da ``Action`` e poderá ser acessado nas views.
     * Tem como finalidade agregar informações que sirvam para a configuração da view e que não
     * devem ser expostas ao ``UA``.
     *
     * @var         \stdClass
     */
    protected \stdClass $viewConfig;










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
        $this->response     = $response;

        $this->viewData     = new \stdClass();
        $this->viewConfig   = new \stdClass();
    }





    /**
     * Retorna a instância ``iResponse``.
     * Aplica no objeto ``iResponse`` as propriedades ``viewData`` (obtido do resultado da
     * execução da action);
     * ``viewConfig`` (obtido com a manipulação das propriedades variáveis do objeto
     * **routeConfig**);
     * ``headers`` (padrões + os definidos pela action)
     *
     * @return      iResponse
     */
    public function getResponse() : iResponse
    {
        $useViewConfig = $this->serverConfig->getRouteConfig()->getActionAttributes();
        foreach ($this->viewConfig as $key => $value) {
            if (isset($useViewConfig[$key]) === false) {
                $useViewConfig[$key] = $value;
            }
        }

        return $this->response->withActionProperties(
            $this->viewData,
            (object)$useViewConfig,
            $this->routeConfig->getResponseHeaders()
        );
    }
}
