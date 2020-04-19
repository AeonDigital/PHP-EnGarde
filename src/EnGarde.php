<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\EnGarde\Interfaces\Engine\iApplication as iApplication;







/**
 * Motor das aplicações do domínio.
 *
 * @codeCoverageIgnore
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class EnGarde extends BObject
{



    /**
     * Configurações do Servidor.
     *
     * @var         iServerConfig
     */
    private iServerConfig $serverConfig;





    /**
     * Inicia o motor de aplicações.
     *
     * @param       bool $autorun
     *              Indica se deve rodar a aplicação imediatamente.
     */
    function __construct(bool $autorun = true)
    {
        // Inicia as configurações do servidor.
        $this->serverConfig = \AeonDigital\EnGarde\Config\Server::fromContext();

        // Executa a aplicação
        $this->initiApplication();
        if ($autorun === true) {
            $this->run();
        }
    }





    /**
     * Objeto ``Engine\iApplication``.
     *
     * @var         iApplication
     */
    private iApplication $application;
    /**
     * Inicia a aplicação alvo.
     *
     * @return      void
     */
    private function initiApplication() : void
    {
        $applicationNS      = $this->serverConfig->retrieveApplicationNS();
        $this->application  = new $applicationNS($this);

        // PROSSEGUIR DAQUI. <---
        // MUDAR O MOMENTO EM QUE AS INSTÂNCIAS DE CONFIGURAÇÃO SÃO INICIADAS PARA PERMITIR
        // QUE A APLICAÇÃO EFETUE SUAS PRÓPRIAS ALTERAÇÕES EM iApplication e iRoute


    }









    /**
     * Efetivamente roda a aplicação.
     *
     * @return      void
     */
    public function run() : void
    {
        $this->application->run();
    }
}
