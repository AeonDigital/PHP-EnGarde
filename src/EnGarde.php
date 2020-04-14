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
     * Objeto ``Engine\iApplication``.
     *
     * @var         iApplication
     */
    private iApplication $application;





    /**
     * Inicia o motor de aplicações.
     *
     * @param       bool $autorun
     *              Indica se deve rodar a aplicação imediatamente.
     */
    function __construct(bool $autorun = true)
    {
        // Inicia as instâncias de configuração
        // - iServer | iEngine | iApplication | iSecurity
        $this->serverConfig = \AeonDigital\EnGarde\Config\Server::autoSetServerConfig();

        // Identifica o nome da classe principal da aplicação alvo e inicia sua instância.
        // Neste momento, se a aplicação possui alguma configuração especial, aplica-a.

        // PROSSEGUIR DAQUI.
        // MUDAR O MOMENTO EM QUE AS INSTÂNCIAS DE CONFIGURAÇÃO SÃO INICIADAS PARA PERMITIR
        // QUE A APLICAÇÃO EFETUE SUAS PRÓPRIAS ALTERAÇÕES EM iApplication e iRoute
        $applicationNS      = $this->serverConfig->getEngineConfig()->retrieveApplicationNS();
        $this->application  = new $applicationNS($this);


        // Executa a aplicação
        if ($autorun === true) {
            $this->run();
        }
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
