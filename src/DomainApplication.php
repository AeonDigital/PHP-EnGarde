<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\EnGarde\Interfaces\iApplication as iApplication;
use AeonDigital\EnGarde\ErrorListening as ErrorListening;
use AeonDigital\EnGarde\Handlers\ResponseHandler as ResponseHandler;
use AeonDigital\EnGarde\Handlers\MainHandler as MainHandler;
use AeonDigital\EnGarde\Handlers\RouteHandler as RouteHandler;




/**
 * Classe abstrata que deve ser herdada pelas classes
 * concretas em cada Aplicações *EnGarde*.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
abstract class DomainApplication implements iApplication
{
    use \AeonDigital\EnGarde\Traits\CommomProperties;





    /**
     * Permite configurar ou redefinir o objeto de configuração
     * da aplicação na classe concreta da mesma.
     */
    abstract public function configureApplication() : void;





    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
    public function run() : void
    {
        // Se este não for o método a ser executado para 
        // resolver esta rota, evoca o método alvo.
        if ($this->runMethodName !== "run") {
            // @codeCoverageIgnoreStart  
            $exec = $this->runMethodName;
            $this->$exec();
            // @codeCoverageIgnoreEnd  
        } 
        else {
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
                // Senão, se
                // A rota a ser acessada existe e foi encontrada...
                else {

                    // Conforme o método definido
                    switch ($targetMethod) {
                        case "OPTIONS":
                        case "TRACE":

                            // Inicia o manipulador responsável por gerar
                            // a view a ser devolvida ao UA.
                            $responseHandler = new ResponseHandler(
                                $this->domainConfig,
                                $this->serverConfig,
                                $this->serverRequest,
                                $this->applicationConfig,
                                $this->routeConfig,
                                $this->rawRouteConfig,
                                $this->serverConfig->getHttpTools()->createResponse()
                            );
                            
                            if ($targetMethod === "OPTIONS") {
                                $responseHandler->prepareResponseToOPTIONS();
                            } 
                            else {
                                $responseHandler->prepareResponseToTRACE();
                            }

                            $responseHandler->sendResponse();
                            $this->testViewDebug = $responseHandler->getResponse();
                            break;

                        default:
                            // Inicia o manipulador principal para os middlewares e 
                            // para a rota selecionada.
                            //$mainHandler = new MainHandler(new RouteHandler($this));

                            $this->testViewDebug = "aqui!";
                            break;
                    }
                }
            }




            // Havendo capturado alguma falha que não pode ser 
            // resolvida e precisa entregar ao UA uma mensagem
            // do que ocorreu...
            if ($httpErrorCode !== null) {
                $this->testViewDebug = ErrorListening::throwHTTPError($httpErrorCode, $httpErrorMessage);
            }
        }
    }





    private $testViewDebug = null;
    /**
     * Usado para testes em desenvolvimento.
     * Retorna um valor interno que poderá ser aferido
     * em ambiente de testes.
     *
     * @return      mixed
     */
    public function getTestViewDebug()
    {
        return $this->testViewDebug;
    }
}
