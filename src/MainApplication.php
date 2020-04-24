<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Engine\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;






/**
 * Classe abstrata que deve ser herdada pelas classes concretas em cada Aplicações.
 *
 * @codeCoverageIgnore
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
abstract class MainApplication extends BObject implements iApplication
{



    /**
     * Objeto ``Config\iServer``.
     *
     * @var         iServerConfig
     */
    protected iServerConfig $serverConfig;



    /**
     * Configurações padrões para a aplicação.
     * Pode ser extendido na classe final da aplicação alvo.
     *
     * @var         array
     */
    protected array $defaultApplicationConfig = [];
    /**
     * Configurações padrões para a aplicação.
     * Pode ser extendido na classe final da aplicação alvo.
     *
     * @var         array
     */
    protected array $defaultSecurityConfig = [];










    /**
     * Inicia uma Aplicação.
     *
     * @param       iServerConfig $serverConfig
     *              Instância ``iServerConfig``.
     */
    function __construct(iServerConfig $serverConfig)
    {
        // Inicia o objeto de configuração da aplicação.
        $serverConfig->getApplicationConfig(
            \array_merge([
                "appName"       => $serverConfig->getApplicationName(),
                "appRootPath"   => $serverConfig->getRootPath() . DS . $serverConfig->getApplicationName()
            ],
            $this->defaultApplicationConfig
        ));


        // Inicia o objeto de configuração de segurança.
        $serverConfig->getSecurityConfig($this->defaultSecurityConfig);


        // Inicia o objeto roteador para que seja possível
        // identificar qual rota está sendo requisitada.
        $router = new \AeonDigital\EnGarde\Engine\Router($serverConfig);
        if ($router->isToProcessApplicationRoutes() === true) {
            $router->processApplicationRoutes();
        }


        // Identifica a rota e inicia o objeto de configuração da mesma
        // baseado na URI que a aplicação deseja.
        $serverConfig->getRouteConfig(
            $router->selectTargetRawRoute(
                $serverConfig->getApplicationRequestUri()
            ),
            true
        );


        // Define a propriedade de configuração que está sendo usada.
        $this->serverConfig = $serverConfig;
    }




    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
    public function run() : void
    {
        // Se este não for o método a ser executado para
        // resolver esta rota, evoca o método alvo.
        /*if ($this->serverConfig->getRouteConfig()->getRunMethodName() !== "run") {
            $exec = $this->serverConfig->getRouteConfig()->getRunMethodName();
            $this->$exec();
        }
        else {

        }*/
    }











    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     *
    public function run() : void
    {
        if ($this->isRun === false) {
            $this->isRun = true;

            // Se este não for o método a ser executado para
            // resolver esta rota, evoca o método alvo.
            if ($this->runMethodName !== "run") {
                $exec = $this->runMethodName;
                $this->$exec();
            }
            else {
                if ($this->checkRouteErrors() === true) {
                    $targetMethod = strtoupper($this->serverRequest->getMethod());



                    // Inicia uma instância "iRequestHandler" responsável
                    // por iniciar o controller alvo e executar o método correspondente a rota.
                    $resolver = new \AeonDigital\EnGarde\Handler\RouteResolver(
                        $this->serverConfig
                    );


                    // Inicia a instância do manipulador da requisição.
                    // e passa para ele o resolver da rota para ser executado após
                    // os middlewares.
                    $requestHandler = new \AeonDigital\Http\Server\RequestHandler($resolver);


                    // Registra os middlewares caso existam
                    if ($this->routeConfig !== null) {
                        $middlewares = $this->routeConfig->getMiddlewares();
                        foreach ($middlewares as $callMiddleware) {

                            // Se o middleware está registrado com seu nome completo
                            if (class_exists($callMiddleware) === true) {
                                $requestHandler->add(new $callMiddleware());
                            }
                            // Senão, o middleware registrado deve corresponder a um
                            // método da aplicação atual.
                            else {
                                $requestHandler->add($this->{$callMiddleware}());
                            }
                        }
                    }


                    // Ocultará qualquer saida de dados dos middlewares
                    // ou das actions quando estiver em um ambiente de produção
                    // OU
                    // quando o debug mode estiver ativo
                    $hideAllOutputs = ( $this->domainConfig->getEnvironmentType() === "PRD" ||
                                        $this->domainConfig->getIsDebugMode() === false);


                    // Caso necessário, inicia o buffer
                    // Com isso, esconderá todas as saídas explicitas originarias
                    // dos middlewares e da action.
                    if ($hideAllOutputs === true) { ob_start("mb_output_handler); }


                    // Executa os middlewares e action alvo retornando
                    // um objeto "iResponse" contendo as informações
                    // necessárias para a resposta ao UA.
                    $this->response = $requestHandler->handle($this->serverRequest);


                    // Caso necessário, esvazia o buffer e encerra-o
                    if ($hideAllOutputs === true) { ob_end_clean(); }


                    // Efetua o envio dos dados obtidos e processados para o UA.
                    $this->sendResponse();
                }
            }
        }
    }





    /**
     * Verifica se há erros na seleção da configuração da rota alvo.
     *
     * @return      bool
     *
    private function checkRouteErrors() : bool
    {
        $targetMethod       = strtoupper($this->serverRequest->getMethod());
        $httpErrorCode      = null;
        $httpErrorMessage   = null;


        // Se a rota acessada não for encontrada.
        if ($this->rawRouteConfig === null) {
            $httpErrorCode = 404;
            $httpErrorMessage = "Not Found";
        }
        // Senão, se
        // A rota a ser acessada está configurada
        else {
            $hasTargetMethod = (
                isset($this->rawRouteConfig[$targetMethod]) === true ||
                $targetMethod === "OPTIONS" ||
                $targetMethod === "TRACE"
            );


            // Se a rota não está preparada para servir
            // a uma requisição com o método especificado...
            if ($hasTargetMethod === false) {
                $httpErrorCode      = 501;
                $httpErrorMessage   = "Method \"$targetMethod\" is not implemented in this route.";
            }
        }


        // Havendo capturado alguma falha que não pode ser
        // resolvida e precisa entregar ao UA uma mensagem
        // do que ocorreu...
        if ($httpErrorCode !== null) {
            $this->testViewDebug = \AeonDigital\EnGarde\Config\ErrorListening::throwHTTPError($httpErrorCode, $httpErrorMessage);
            return false;
        } else {
            return true;
        }
    }


    /**
     * Efetivamente envia os dados para o ``UA``.
     *
     * @return      void
     *
    private function sendResponse() : void
    {

        // Quando NÃO se trata de um ambiente de testes,
        // efetua o envio dos dados processados para o UA.
        if ($this->domainConfig->getEnvironmentType() === "UTEST") {

            // Se o sistema de segurança está ativo os seguintes
            // headers serão adicionados
            if ($this->applicationConfig->getSecuritySettings()->isActive() === true) {
                $this->response = $this->response->withHeaders(
                    [
                        "Expires" => "Tue, 01 Jan 2000 00:00:00 UTC",
                        "Last-Modified" => gmdate("D, d M Y H:i:s") . " UTC",
                        "Cache-Control" => "no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0",
                        "Pragma" => "no-cache"
                    ],
                    true
                );
            }

            // Envia os Headers para o UA
            foreach ($this->response->getHeaders() as $name => $value) {
                if ($value === "") { header($name); }
                else { header($name . ": " . implode(", ", $value)); }
            }


            // Prepara o corpo da resposta para ser enviado.
            $streamBody = $this->response->getBody();
            if ($streamBody->isSeekable() === true) {
                $streamBody->rewind();
            }


            // Separa o envio do corpo do documento em partes
            // para entrega-lo ao UA.
            $partLength     = 1024;
            $totalLength    = $streamBody->getSize();
            $haveToSend     = $totalLength;
            while ($haveToSend > 0 && $streamBody->eof() === false) {
                $strPart = $streamBody->read(min($partLength, $haveToSend));
                echo $strPart;

                $haveToSend -= $partLength;
            }
        }
    }


    protected $testViewDebug = null;
    /**
     * Usado para testes em desenvolvimento.
     * Retorna um valor interno que poderá ser aferido em ambiente de testes.
     *
     * @return      mixed

    public function getTestViewDebug()
    {
        return $this->testViewDebug;
    }*/
}
