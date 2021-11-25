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
     * Indica se o método ``run()`` já foi ativado alguma vez.
     *
     * @var         bool
     */
    private bool $isRun = false;





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
                    "forceHttps"            => FORCE_HTTPS,
                    "environmentType"       => ENVIRONMENT,
                    "isDebugMode"           => DEBUG_MODE,
                    "isUpdateRoutes"        => UPDATE_ROUTES,
                    "hostedApps"            => HOSTED_APPS,
                    "defaultApp"            => DEFAULT_APP,
                    "rootSubPath"           => ROOT_SUBPATH,
                    "dateTimeLocal"         => DATETIME_LOCAL,
                    "timeout"               => REQUEST_TIMEOUT,
                    "maxFileSize"           => REQUEST_MAX_FILESIZE,
                    "maxPostSize"           => REQUEST_MAX_POSTSIZE,
                    "pathToErrorView"       => DEFAULT_ERROR_VIEW,
                    "pathToHttpMessageView" => DEFAULT_HTTP_MESSAGE_VIEW,
                    "applicationClassName"  => APPLICATION_CLASSNAME,
                    "developerHttpMethods"  => ["GET", "POST", "PUT", "PATCH", "DELETE"],
                    "frameworkHttpMethods"  => ["HEAD", "OPTIONS", "TRACE", "DEV", "CONNECT"]
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
        if ($this->isRun === false) {
            $this->isRun = true;
            $redirectTo = $this->serverConfig->getNewLocationPath();

            if ($this->serverConfig->getForceHttps() === true &&
                $this->serverConfig->getRequestIsUseHttps() === false) {
                $redirectTo = "https://" . $this->serverConfig->getRequestDomainName() . $redirectTo;
            }

            if ($redirectTo !== "") {
                \redirect($redirectTo);
            }
            else {
                $applicationNS      = $this->serverConfig->getApplicationNamespace();
                $this->application  = new $applicationNS($this->serverConfig);
                $this->application->run();
            }
        }
    }
}
