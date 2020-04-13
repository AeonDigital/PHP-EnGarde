<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Engine\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;






/**
 * Classe abstrata que deve ser herdada pelas classes concretas em cada
 * Aplicações ``EnGarde``.
 *
 * @codeCoverageIgnore
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
abstract class Application extends BObject implements iApplication
{





    /**
     * Configurações do Servidor.
     *
     * @var         iServerConfig
     */
    protected iServerConfig $serverConfig;

    /**
     * Indica se o método ``run()`` já foi ativado alguma vez.
     *
     * @var         bool
     */
    private bool $isRun = false;

    /**
     * Objeto que representa a configuração bruta da rota alvo.
     *
     * @var         array
     *
    protected array $rawRouteConfig = [];
    /**
     * Objeto que representa a configuração da rota alvo.
     *
     * @var         iRouteConfig
     *
    protected iRouteConfig $routeConfig;
    /**
     * Objeto ``iResponse``.
     *
     * @var         iResponse
     *
    protected iResponse $response;
    /**
     * Guarda a parte relativa da URI que está sendo executada no momento
     *
     * @var         string
     *
    protected string $executePath = "";
    /**
     * Nome do método que deve ser usado para resolver a rota que está ativa no momento.
     *
     * @var         string

    protected string $runMethodName = "run";*/





    /**
     * Seleciona o objeto ``iRouteConfig`` para esta instância.
     *
     * @return      void
     *
    private function selectTargetRouteConfig() : void
    {
        if ($this->routeConfig === null) {
            // P1 - Verifica necessidade de atualizar o arquivo de rotas da aplicação.
            $this->applicationRouter->setIsUpdateRoutes($this->domainConfig->getIsUpdateRoutes());

            // Sendo para atualizar as rotas
            // E
            // Estando com o debug mode ligado...
            // E
            // Estando em um ambiente definido como "local" ou "localtest"
            //
            // força o update de rotas em toda requisição
            if ($this->domainConfig->getIsUpdateRoutes() === true &&
                $this->domainConfig->getIsDebugMode() === true &&
                (
                    $this->domainConfig->getEnvironmentType() === "local" ||
                    $this->domainConfig->getEnvironmentType() === "localtest")
                )
            {
                $this->applicationRouter->forceUpdateRoutes();
            }

            // Efetua a recomposição do arquivo de rotas caso
            // seja necessário
            $this->applicationRouter->updateApplicationRoutes();




            // P2 - Identifica as configurações de execução da rota alvo.
            $requestURIPath = $this->serverRequest->getUri()->getPath();

            // Se o nome da aplicação não foi definido no caminho
            // relativo da URI que está sendo executada, adiciona-o
            $executePath = trim($requestURIPath, "/");
            if ($this->domainConfig->isApplicationNameOmitted() === true) {
                $executePath = $this->applicationConfig->getName() . "/" . $executePath;
            }
            $this->executePath = "/" . $executePath . "/";


            // Seleciona os dados da rota que deve ser executada.
            $this->rawRouteConfig = $this->applicationRouter->selectTargetRawRoute($this->executePath);


            // Adiciona os parametros definidos na própria URL, identificados pelo
            // roteador da Aplicação no objeto de requisição.
            $useAttributes = $this->applicationRouter->getSelectedRouteParans() ?? [];
            $this->serverRequest->setInitialAttributes($useAttributes);




            // P3 - Identificando exatamente a configuração da rota alvo
            $targetMethod = strtoupper($this->serverRequest->getMethod());
            if ($this->rawRouteConfig !== [] && isset($this->rawRouteConfig[$targetMethod]) === true) {
                $this->routeConfig = new \AeonDigital\EnGarde\Config\Route($this->rawRouteConfig[$targetMethod]);

                // P4 - Identifica se deve executar um método próprio
                $this->runMethodName = $this->routeConfig->getRunMethodName();
            }
        }
    }










    /**
     * Inicia uma Aplicação.
     *
     * @param       iServerConfig $serverConfig
     *              Instância ``iServerConfig``.
     */
    function __construct(iServerConfig $serverConfig)
    {
        $this->serverConfig = $serverConfig;




        /*
        $this->selectTargetRouteConfig();

        if ($this->routeConfig !== null) {
            $this->executeContentNegotiation();
        }*/
    }










    /**
     * Efetua a negociação de conteúdo para identificar de que forma os dados devem ser
     * retornados ao ``UA``.
     *
     * @return      void
     *
    private function executeContentNegotiation() : void
    {
        // Verifica qual locale deve ser usado para responder
        // esta requisição
        $useLocale = $this->routeConfig->negotiateLocale(
            $this->serverRequest->getResponseLocales(),
            $this->serverRequest->getResponseLanguages(),
            $this->applicationConfig->getLocales(),
            $this->applicationConfig->getDefaultLocale(),
            $this->serverRequest->getParam("_locale")
        );

        if ($useLocale === "") {
            $msg = "Locale \"$useLocale\" is not supported by this Application.";
            \AeonDigital\EnGarde\Config\ErrorListening::throwHTTPError(415, $msg);
        } else {
            $this->routeConfig->setResponseLocale($useLocale);
        }


        // Verifica qual mimetype deve ser usado para responder
        // esta requisição
        $routeMime = $this->routeConfig->negotiateMimeType(
            $this->serverRequest->getResponseMimes(),
            $this->serverRequest->getParam("_mime")
        );


        if ($routeMime["valid"] === false) {
            $useMime        = $routeMime["mime"];
            $useMimeType    = $routeMime["mimetype"];

            $msg            = "Media type \"$useMime | $useMimeType\" is not supported by this URL.";
            \AeonDigital\EnGarde\Config\ErrorListening::throwHTTPError(415, $msg);
        } else {
            $this->routeConfig->setResponseMime($routeMime["mime"]);
            $this->routeConfig->setResponseMimeType($routeMime["mimetype"]);
        }


        // Identifica se a rota é "naturalmente" um download.
        $isDownload_route = $this->routeConfig->getResponseIsDownload();
        // Identifica se há um parametro que force o download do resultado da rota.
        $isDownload_param = $this->serverRequest->getParam("_download");
        if ($isDownload_param !== null) {
            $isDownload_param = ($isDownload_param === "true" || $isDownload_param === "1");
        }
        // Aplica a regra conforme as prioridades pré-estipuladas.
        // O parametro encontrado na querystring é prioritário e pode ser usado para
        // negar o download de uma rota cuja configuração seja naturalmente a obtenção
        // de um documento.
        $this->routeConfig->setResponseIsDownload(
            (
                $isDownload_param === true ||
                (
                    ($isDownload_param === null || $isDownload_param === true) &&
                    $isDownload_route === true
                )
            )
        );



        // Identifica se é para usar "pretty print" no código fonte de retorno
        $prettyPrint = $this->serverRequest->getParam("_pretty_print");
        $this->routeConfig->setResponseIsPrettyPrint(($prettyPrint === "true" || $prettyPrint === "1"));
    }










    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
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
                        $this->serverConfig,
                        $this->domainConfig,
                        $this->applicationConfig,
                        $this->serverRequest,
                        $this->rawRouteConfig,
                        $this->routeConfig
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
                    $hideAllOutputs = ( $this->domainConfig->getEnvironmentType() === "production" ||
                                        $this->domainConfig->getIsDebugMode() === false);


                    // Caso necessário, inicia o buffer
                    // Com isso, esconderá todas as saídas explicitas originarias
                    // dos middlewares e da action.
                    if ($hideAllOutputs === true) { ob_start(); }


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
        // Identifica se está em um ambiente de testes.
        $isTestEnv = (  $this->domainConfig->getEnvironmentType() === "test" ||
                        $this->domainConfig->getEnvironmentType() === "testview" ||
                        $this->domainConfig->getEnvironmentType() === "localtest");


        // Quando NÃO se trata de um ambiente de testes,
        // efetua o envio dos dados processados para o UA.
        if ($isTestEnv === false) {

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
