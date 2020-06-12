<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Engine\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;
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
     * Objeto ``iRoute`` da rota atualmente sendo executada.
     *
     * @var         iRoute
     */
    protected iRoute $routeConfig;




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


        // Inicia o objeto roteador para que seja possível
        // identificar qual rota está sendo requisitada.
        $router = new \AeonDigital\EnGarde\Engine\Router($serverConfig);
        if ($router->isToProcessApplicationRoutes() === true) {
            $router->processApplicationRoutes();
        }


        // Identifica a rota e inicia o objeto de configuração da mesma
        // baseado na URI que a aplicação deseja.
        if ($serverConfig->getRouteConfig(
                $router->selectTargetRawRoute($serverConfig->getApplicationRequestUri()), true) !== null) {
            $this->routeConfig = $serverConfig->getRouteConfig();
        }


        // Define a propriedade de configuração que está sendo usada.
        $this->serverConfig = $serverConfig;
        // Executa o protocolo de segurança da aplicação.
        $this->applySecuritySettings();
    }





    /**
     * Inicia as instâncias de objetos responsáveis pela segurança da aplicação e efetua
     * todas as verificações possíveis para identificar se o UA tem ou não condições de executar
     * a rota que está requisitando.
     *
     * Conforme as configurações irá enviar o UA para uma das rotas definidas.
     *
     * @return      void
     */
    private function applySecuritySettings() : void
    {
        // Inicia os objetos de configurações de segurança.
        $securityConfig = $this->serverConfig->getSecurityConfig($this->defaultSecurityConfig);
        $securitySession = $this->serverConfig->getSecuritySession();

        // Apenas se a aplicação possui alguma configuração de segurança
        if ($securityConfig->getIsActive() === true) {
            $hasAuthentication = $securitySession->checkUserAgentSession();

            // SE
            //  o UA não está autenticado
            // E
            //  a rota não possui uma configuração específica,
            // OU
            //  está configurada como uma rota protegida
            if ($hasAuthentication === false &&
                (isset($this->routeConfig) === false || $this->routeConfig->getIsSecure() === true))
            {
                $this->serverConfig->redirectTo(
                    $securityConfig->getRouteToLogin(), 401
                );
            }
        }
    }





    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
    public function run() : void
    {
        $hasValidCache = false;

        // Identifica se o resultado desta rota é cacheável e, se existe um resultado pronto
        // para ser entregue.
        if ($this->hasValidResponseCacheFile() === true) {
            $this->response = $this->serverConfig->getHttpFactory()->createResponse();
            $responseCacheFileContents = \file_get_contents($this->getCacheFileName());

            // Resgata os headers a serem usados para o envio.
            $headers = strtok($responseCacheFileContents, "\n");
            $this->response = $this->response->withHeaders(\json_decode($headers, true));


            // Remove do corpo da mensagem os dados referentes aos headers
            $responseCacheFileContents = \trim(\str_replace($headers, "", $responseCacheFileContents));
            // Redefine o body
            $body = $this->response->getBody();
            $body->write($responseCacheFileContents);
            $this->response = $this->response->withBody($body);

            // Efetua o envio dos dados obtidos e processados para o UA.
            $this->sendResponse();
        }
        else {
            // Se este não for o método a ser executado para
            // resolver esta rota, evoca o método alvo.
            if (isset($this->routeConfig) === true &&
                $this->routeConfig->getRunMethodName() !== "run")
            {
                $exec = $this->routeConfig->getRunMethodName();
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
                if (isset($this->routeConfig) === true) {
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

                // Cria o arquivo de cache, se for necessário.
                $this->saveOrUpdateResponseCache();
            }
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
                $useVal = "";

                if (\is_string($value) === true) { $useVal = \trim($value); }
                elseif (\is_array($value) === true) { $useVal = \trim(\implode(", ", $value)); }

                if ($useVal === "") { \header($name); }
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









    private string $cacheFileName = "";
    /**
     * Identifica quando a rota atualmente definida possui instrução de que deva ser
     * cacheada.
     *
     * @return      bool
     */
    private function isRouteCacheable() : bool
    {
        return (isset($this->routeConfig) === true &&
                $this->routeConfig->getIsUseCache() === true);
    }
    /**
     * Monta o caminho completo do arquivo de cache correspondente a rota que está sendo executada
     * neste momento.
     *
     * @return      string
     */
    private function getCacheFileName() : string
    {
        if ($this->cacheFileName === "") {
            // Monta o nome base do arquivo de cache
            $baseCacheFileName = \str_replace("/", "_",
                $this->serverConfig->getRequestMethod() . "_" .
                \mb_str_replace_once(
                    "/" . $this->serverConfig->getApplicationName() . "/",
                    "",
                    $this->serverConfig->getApplicationRequestUri()
                )
            );

            // Existindo querystrings, cria um hash para identificar tal conjunto de valores
            $qs = "";
            if ($this->serverConfig->getServerRequest()->getQueryParams() !== []) {
                $qs = "_" . \sha1(\http_build_query($this->serverConfig->getServerRequest()->getQueryParams()));
            }

            $this->serverConfig->getApplicationConfig()->getPathToCacheFiles(true);
            $this->cacheFileName = \to_system_path(
                $this->serverConfig->getApplicationConfig()->getPathToCacheFiles(true) .
                DS .
                $baseCacheFileName . $qs . "." . $this->routeConfig->getResponseMime()
            );
        }
        return $this->cacheFileName;
    }
    /**
     * Caso esta seja uma rota cacheável e, seu arquivo de cache não exista, ou exista mas esteja
     * expirado, cria/atualiza o arquivo de cache alvo.
     *
     * @return      void
     */
    private function saveOrUpdateResponseCache() : void
    {
        if ($this->isRouteCacheable() === true) {
            $cacheFileName = $this->getCacheFileName();

            $strHeaders = json_encode($this->response->getHeaders()) . "\n";
            \file_put_contents($cacheFileName, $strHeaders . (string)$this->response->getBody());
        }
    }
    /**
     * Identifica se o arquivo de cache de nome passado existe e se ele ainda é válido.
     *
     * @return      bool
     *              Retornará ``true`` se o arquivo existir e sua data de criação estiver dentro do período
     *              definido como aceitável (cacheTimeout).
     *              Retornará ``false``se o arquivo não existir ou se sua data de criação está além do
     *              período de vida útil.
     */
    private function hasValidResponseCacheFile() : bool
    {
        $r = false;

        if ($this->isRouteCacheable() === true) {
            $cacheFileName = $this->getCacheFileName();
            if (\is_file($cacheFileName) === true) {
                // Identifica se o arquivo existente ainda está dentro do período de validade.
                $fileLastMod = new \DateTime();
                $fileLastMod->setTimestamp(\filemtime($cacheFileName));

                $diff = $fileLastMod->diff($this->serverConfig->getNow());
                $r = ($diff->format("%i") < $this->routeConfig->getCacheTimeout());
            }
        }

        return $r;
    }
}
