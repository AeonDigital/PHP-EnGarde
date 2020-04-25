<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Engine\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;





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
abstract class MainApplication implements iApplication
{



    /**
     * Objeto ``Config\iServer``.
     *
     * @var         iServerConfig
     */
    protected iServerConfig $serverConfig;
    /**
     * Objeto ``iResponse`` resultante da execução do
     * controller e action alvos.
     *
     * @var         iResponse
     */
    protected iResponse $response;





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
        $rc = $serverConfig->getRouteConfig(
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
        if ($this->serverConfig->getRouteConfig() !== null &&
            $this->serverConfig->getRouteConfig()->getRunMethodName() !== "run")
        {
            $exec = $this->serverConfig->getRouteConfig()->getRunMethodName();
            $this->$exec();
        }
        else {
            // Inicia uma instância "RouteResolver" (trata-se de um iRequestHandler) responsável
            // por iniciar o controller alvo e executar o método correspondente a rota.
            $resolver = new \AeonDigital\EnGarde\Handler\RouteResolver(
                $this->serverConfig
            );


            // Inicia a instância do manipulador da requisição.
            // e passa para ele o resolver da rota para ser executado após
            // os middlewares.
            $requestHandler = new \AeonDigital\Http\Server\RequestHandler($resolver);


            // Registra os middlewares caso existam
            if ($this->serverConfig->getRouteConfig() !== null) {
                $middlewares = $this->serverConfig->getRouteConfig()->getMiddlewares();
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
            $hideAllOutputs = ( $this->serverConfig->getEnvironmentType() === "PRD" ||
                                $this->serverConfig->getIsDebugMode() === false);


            // Caso necessário, inicia o buffer
            // Com isso, esconderá todas as saídas explicitas originarias
            // dos middlewares e da action.
            if ($hideAllOutputs === true) { ob_start("mb_output_handler"); }


            // Executa os middlewares e action alvo retornando
            // um objeto "iResponse" contendo as informações
            // necessárias para a resposta ao UA.
            $this->response = $requestHandler->handle(
                $this->serverConfig->getServerRequest()
            );


            // Caso necessário, esvazia o buffer e encerra-o
            if ($hideAllOutputs === true) { ob_end_clean(); }


            // Efetua o envio dos dados obtidos e processados para o UA.
            $this->sendResponse();
        }
    }





    /**
     * Efetivamente envia os dados para o ``UA``.
     *
     * @return      void
     */
    private function sendResponse() : void
    {
        // Quando NÃO se trata de um ambiente de testes,
        // efetua o envio dos dados processados para o UA.
        if ($this->serverConfig->getEnvironmentType() !== "UTEST") {
            // Envia os Headers para o UA
            foreach ($this->response->getHeaders() as $name => $value) {
                if ($value === "") { \header($name); }
                else { \header($name . ": " . \implode(", ", $value)); }
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
}
