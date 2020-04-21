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
        // Inicia as configurações do servidor.
        $this->serverConfig = \AeonDigital\EnGarde\Config\Server::fromArray(
            [
                "SERVER"    => $_SERVER,
                "FILES"     => $_FILES,
                "ENGINE"    => [
                    "environmentType"       => "UTEST",
                    "isDebugMode"           => true,
                    "isUpdateRoutes"        => true,
                    "hostedApps"            => ["site", "blog"],
                    "defaultApp"            => "site",
                    "dateTimeLocal"         => "America/Sao_Paulo",
                    "timeout"               => 1200,
                    "maxFileSize"           => 100,
                    "maxPostSize"           => 100,
                    "pathToErrorView"       => "errorView.phtml",
                    "applicationClassName"  => "AppStart"
                ]
            ]
        );

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
        // Inicia o objeto da aplicação alvo.
        $applicationNS      = $this->serverConfig->getApplicationNamespace();
        $this->application  = new $applicationNS($this->serverConfig);

        if ($this->serverConfig->getNewLocationPath() !== "") {
            \redirect($this->serverConfig->getNewLocationPath());
        }
        else {
            $this->application->run();
        }
    }
}
