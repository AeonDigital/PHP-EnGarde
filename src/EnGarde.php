<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;








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
        $this->serverConfig = \AeonDigital\EnGarde\Config\Server::autoSetServerConfig();

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
        $this->serverConfig
            ->getApplication()
            ->run();
    }
}
