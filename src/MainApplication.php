<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Engine\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Handler\HttpRawMessage as HttpRawMessage;



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


        // Inicia os objetos de configurações de segurança e controle de sessão
        $serverConfig->getSecurityConfig($this->defaultSecurityConfig);
        $serverConfig->getSecuritySession();


        // Inicia o objeto roteador para que seja possível
        // identificar qual rota está sendo requisitada.
        $router = new \AeonDigital\EnGarde\Engine\Router($serverConfig);
        if ($router->isToProcessApplicationRoutes() === true) {
            $router->processApplicationRoutes();

            // Atualiza, se necessário, o controle de permissões para as rotas.
            if ($serverConfig->getSecuritySession()->hasDataBase() === true) {
                $serverConfig->getSecuritySession()->processRoutesPermissions(
                    $serverConfig->getApplicationConfig()->getPathToAppRoutes(true)
                );
            }
        }



        // Verifica de que forma a rota deve ser processada conforme a ordem
        // de precedencia dos métodos de tratamento.
        $rawRoute = null;
        foreach ($serverConfig->getApplicationConfig()->getCheckRouteOrder() as $routeMethod) {
            if ($rawRoute === null) {
                switch ($routeMethod) {
                    // Identifica, a partir das configurações definidas nos controllers da aplicação
                    // a qual rota exatamente esta requisição deve corresponder.
                    case "native":
                        $rawRoute = $router->selectTargetRawRoute(
                            $serverConfig->getApplicationRequestUri()
                        );
                        break;

                    // Executa a regra "catchAll" definida pela aplicação, se ela existir.
                    case "catch-all":
                        $rawRoute = $this->checkCatchAll($serverConfig);
                        break;

                    // Verifica se a requisição atual deve causar um redirecionamento do UA para um outro
                    // local. Neste caso o redirecionamento deve interromper este fluxo.
                    case "redirect":
                        $this->checkRedirectRules($serverConfig);
                        break;
                }
            }
        }



        // Se a rota for identificada, inicia-a.
        // Caso ocorra alguma falha neste ponto ou se a rota não foi identificada será
        // apresentado ao UA uma mensagem de erro correspondente (404, 501 ...).
        if ($serverConfig->getRouteConfig($rawRoute, true) !== null) {
            $this->routeConfig = $serverConfig->getRouteConfig();
        }


        // Define a propriedade de configuração que está sendo usada.
        $this->serverConfig = $serverConfig;
        // Executa o protocolo de segurança da aplicação.
        $this->applyRouteSecuritySettings();
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
    private function applyRouteSecuritySettings() : void
    {
        // Retorna os objetos de configurações de segurança.
        $securityConfig = $this->serverConfig->getSecurityConfig();
        $securitySession = $this->serverConfig->getSecuritySession();


        // Apenas se a aplicação possui alguma configuração de segurança
        if ($securityConfig->getIsActive() === true) {
            $hasAuthentication = $securitySession->checkUserAgentSession();


            // SE
            //  o UA está identificado
            if ($hasAuthentication === true) {
                // SE
                //  a rota possui uma configuração própria
                if (isset($this->routeConfig) === true) {
                    // SE
                    //  a configuração indica que trata-se mesmo de uma rota protegida.
                    if ($this->routeConfig->getIsSecure() === true) {
                        $permission = (
                            $securityConfig->getRouteToStart() === $this->routeConfig->getActiveRoute() ||
                            $securitySession->checkRoutePermission(
                                $this->routeConfig->getMethod(),
                                $this->serverConfig->getRawRouteConfig()["route"],
                            )
                        );
                        // Se o usuário não possui permissão, mostra para ele a mensagem Http 403.
                        if ($permission === false) {
                            HttpRawMessage::throwHttpMessage(403);
                        }
                    }
                }
            }
            // SENÃO
            //  o UA não é reconhecido
            else {

                $freePass = false;
                if (isset($this->routeConfig) === true) {
                    $freeRoutes = [
                        $securityConfig->getRouteToLogin(),
                        $securityConfig->getRouteToResetPassword(),
                    ];
                    $freePass = (
                        \in_array($this->routeConfig->getActiveRoute(), $freeRoutes) ||
                        \in_array($this->routeConfig->getActiveRoute(true), $freeRoutes)
                    );
                }

                // SE
                //  não trata-se de uma rota livre
                // E
                //  não existe uma configuração para a rota
                // OU
                //  a configuração informa que trata-se de um recurso protegido
                if ($freePass === false &&
                    (isset($this->routeConfig) === false || $this->routeConfig->getIsSecure() === true)) {
                    $this->serverConfig->redirectTo(
                        $securityConfig->getRouteToLogin(), 401
                    );
                }
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
        // Se a rota necessita ter seus acessos registrados
        if (isset($this->routeConfig) === true && $this->routeConfig->getIsAutoLog() === true) {
            $this->serverConfig->getSecuritySession()->registerLogActivity(
                $this->routeConfig->getMethod(),
                $this->serverConfig->getApplicationRequestFullUri(),
                $this->serverConfig->getServerRequest()->getPostedFields(),
                $this->routeConfig->getController(),
                $this->routeConfig->getAction(),
                "autolog",
                ""
            );
        }



        $hasValidCache = false;

        // Identifica se o resultado desta rota é cacheável e, se existe um resultado pronto
        // para ser entregue.
        if ($this->hasValidResponseCacheFile() === true) {
            $this->response = $this->serverConfig->getHttpFactory()->createResponse();
            $responseCacheFileContents = \file_get_contents($this->getCacheFileName());

            // Resgata os headers a serem usados para o envio.
            $headers = \strtok($responseCacheFileContents, "\n");
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
                        if (\class_exists($callMiddleware) === true) {
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
                if ($hideAllOutputs === true) { \ob_start("mb_output_handler"); }


                // Executa os middlewares e action alvo retornando
                // um objeto "iResponse" contendo as informações
                // necessárias para a resposta ao UA.
                $this->response = $requestHandler->handle(
                    $this->serverConfig->getServerRequest()
                );


                // Caso necessário, esvazia o buffer e encerra-o
                if ($hideAllOutputs === true) { \ob_end_clean(); }


                // Aplica a camada de ajustes de segurança na view antes de enviá-la ao UA.
                $this->applyViewSecuritySettings();

                // Efetua o envio dos dados obtidos e processados para o UA.
                $this->sendResponse();

                // Cria o arquivo de cache, se for necessário.
                $this->saveOrUpdateResponseCache();
            }
        }
    }





    /**
     * Para qualquer view baseada ou compatível com XML aplica a camada de proteção que
     * irá excluir da mesma qualquer elemento/componente que não deva ser mostrado para
     * o perfil de usuário que o UA está usando.
     *
     * @return      void
     */
    private function applyViewSecuritySettings() : void
    {
        $useMime        = $this->serverConfig->getRouteConfig()->getResponseMime();
        $userProfile    = $this->serverConfig->getSecuritySession()->retrieveUserProfile();
        $appStage       = $this->serverConfig->getRouteConfig()->getAppStage();

        // Apenas se o sistema de segurança está ativo
        // E
        // trata-se de um mime compatível com este tipo de set de segurança
        if ($this->serverConfig->getSecurityConfig()->getIsActive() === true &&
            \in_array($useMime, ["html", "xhtml", "xml"]) === true && $userProfile !== null)
        {
            // Identifica o perfil do usuário logado.
            $profileId      = $userProfile["Id"];
            $profileName    = $userProfile["Name"];
            $allowAll       = $userProfile["AllowAll"];


            // Prepara o HTML ou XHTML com o "meta utf-8" para que os caracteres não ascii não sejam
            // convertidos para entities.
            $useMeta = "<meta charset=\"utf-8\"/>";
            $tmpMeta = $useMeta . "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>";
            $domBody = \str_replace($useMeta, $tmpMeta, (string)$this->response->getBody());



            // Inibe a mostragem de erros para evitar que tags HTML5 disparem erros.
            libxml_use_internal_errors(true);

            $dom = new \DOMDocument();
            $isXML = ($useMime === "xhtml" || $useMime === "xml");

            if ($isXML === true) { $dom->loadXML($domBody); }
            else { $dom->loadHTML($domBody); }
            $xPath = new \DOMXPath($dom);

            // Habilita a mostragem de erros.
            libxml_use_internal_errors(false);



            // Identifica todos os recursos que o usuário atual NÃO tem acesso.
            $strSQL = " SELECT
                            secdr.ResourceId
                        FROM
                            DomainRoute secdr
                            INNER JOIN secdup_to_secdr sec ON sec.DomainRoute_Id=secdr.Id
                        WHERE
                            sec.DomainUserProfile_Id=$profileId AND
                            sec.Allow=0;";
            $dtDeniedResources = $this->serverConfig->getSecuritySession()->getDAL()->getDataTable($strSQL);

            // Apenas se houver algum recurso que seja negado para o tipo de usuário atualmente logado...
            if ($dtDeniedResources !== null) {
                // Varre a arvore do DOM procurando por elementos que contenham o recurso a ser excluído
                foreach ($dtDeniedResources as $row) {
                    $targetNodes = $xPath->query("//*[@data-resource-id=\"" . $row["ResourceId"] . "\"]");
                    foreach ($targetNodes as $tgtNode) {
                        $tgtNode->parentNode->removeChild($tgtNode);
                    }
                }
            }


            // Varre a arvore do DOM procurando elementos que sejam denominados como específicos para
            // um ou outro tipo de perfil de usuário
            $targetNodes = $xPath->query("//*[@data-resource-profiles]");
            foreach ($targetNodes as $tgtNode) {
                $allowedProfiles = \array_map(
                    "trim",
                    \explode(",", $tgtNode->getAttribute("data-resource-profiles"))
                );

                if (\in_array($profileId, $allowedProfiles) === false &&
                    \in_array($profileName, $allowedProfiles) === false) {
                    $tgtNode->parentNode->removeChild($tgtNode);
                }
            }



            //
            // Caso exista uma definição de estágio para a aplicação...
            // Varre a árvore do DOM procurando elementos que NÃO estejam denominados como específicos para
            // o estágio atual e remove-os da marcação.
            $targetNodes = $xPath->query("//*[@data-resource-stages]");
            foreach ($targetNodes as $tgtNode) {
                $allowedStages = \array_map(
                    "trim",
                    \explode(",", $tgtNode->getAttribute("data-resource-stages"))
                );

                $useStage = $appStage;
                if ($tgtNode->getAttribute("data-resource-stage") !== "") {
                    $useStage = $tgtNode->getAttribute("data-resource-stage");
                }

                if ($useStage !== "" && \in_array($useStage, $allowedStages) === false) {
                    $tgtNode->parentNode->removeChild($tgtNode);
                }
            }




            $finalDOMBody = "";
            if ($isXML === true) { $finalDOMBody = (string)$dom->saveXML(); }
            else { $finalDOMBody = (string)$dom->saveHTML(); }
            $finalDOMBody = \str_replace($tmpMeta, $useMeta, $finalDOMBody);

            // Corrige dados especiais de atributos HTML que não devem ser encodados usando
            // o formato "percent-encode"
            $pattern = "/%5B%5B(\w+)%5D%5D/";
            $replacement = "[[$1]]";
            $finalDOMBody = preg_replace($pattern, $replacement, $finalDOMBody);


            $body = $this->serverConfig->getHttpFactory()->createStream();
            $body->write($finalDOMBody);
            $this->response = $this->response->withBody($body);
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
                $strPart = $streamBody->read(\min($partLength, $haveToSend));
                echo $strPart;

                $haveToSend -= $partLength;
            }
        }
    }









    /**
     * Tenta identificar qual rota deve ser utilizada com base em regras específicas
     * da aplicação concreta.
     *
     * @param       iServerConfig $serverConfig
     *              Objeto ``iServerConfig``.
     *
     * @return      ?array
     *              O retorno deve ser uma versão ``array`` de um objeto ``iRoute``.
     */
    protected function checkCatchAll(iServerConfig $serverConfig) : ?array
    {
        return null;
    }










    /**
     * Verifica se existe alguma regra de redirecionamento preparada para a URL requisitada.
     *
     * @param       iServerConfig $serverConfig
     *              Objeto de configuração de servidor a ser usado.
     *
     * @return      void
     */
    private function checkRedirectRules(iServerConfig $serverConfig) : void
    {
        if ($serverConfig->getSecuritySession()->hasDataBase() === true) {
            $DAL = $serverConfig->getSecuritySession()->getDAL();

            $requestURL = $serverConfig->getApplicationRequestUri();
            $requestFullURL = $serverConfig->getApplicationRequestFullUri();


            // Verifica se a URL de requisição completa combina perfeitamente com alguma regra definida.
            $this->checkRedirectAbsolute($serverConfig, $requestFullURL);
            if ($requestFullURL !== $requestURL) {
                // Verifica se a URL completa combina perfeitamente com alguma regra definida.
                $this->checkRedirectAbsolute($serverConfig, $requestURL);
            }


            // Resgata todas as regras dinamicas definidas.
            $strSQL = " SELECT
                            OriginURL, DestinyURL, KeepQuerystrings, HTTPCode, HTTPMessage
                        FROM
                            DomainRouteRedirect
                        WHERE
                            IsPregReplace=1
                        ORDER BY
                            LENGTH(OriginURL) DESC;";
            $dinamicRedirectRules = $DAL->getDataTable($strSQL);
            if ($dinamicRedirectRules !== null) {
                $this->checkRedirectDinamics($requestFullURL, $dinamicRedirectRules);
                if ($requestFullURL !== $requestURL) {
                    $this->checkRedirectDinamics($requestURL, $dinamicRedirectRules);
                }
            }
        }
    }
    /**
     * Verifica o redirecionamento de uma rota de forma absoluta, ou seja, identifica se existe
     * uma regra de redirecionamento cujo campo "OriginURL" case perfeitamente com a URL requisitada.
     *
     * @param       iServerConfig $serverConfig
     *              Objeto de configuração de servidor a ser usado.
     *
     * @param       string $requestURL
     *              URL requisitada.
     *
     * @return      void
     */
    private function checkRedirectAbsolute(iServerConfig $serverConfig, string $requestURL) : void
    {
        $DAL = $serverConfig->getSecuritySession()->getDAL();

        $strSQL = " SELECT
                        DestinyURL, HTTPCode, HTTPMessage
                    FROM
                        DomainRouteRedirect
                    WHERE
                        OriginURL=:OriginURL AND
                        IsPregReplace=0;";
        $parans = [
            "OriginURL" => $requestURL
        ];

        $redirectRule = $DAL->getDataRow($strSQL, $parans);
        if ($redirectRule !== null) {
            $serverConfig->redirectTo(
                $redirectRule["DestinyURL"],
                (int)$redirectRule["HTTPCode"],
                $redirectRule["HTTPMessage"]
            );
        }
    }
    /**
     * Verifica se há alguma regra de redirecionamento dinâmico que case com a URL requisitada.
     *
     * @param       string $requestURL
     *              URL requisitada.
     *
     * @param       array $dinamicRedirectRules
     *              Coleção de regras de redirecionamentos dinamicos.
     *
     * @return      void
     */
    private function checkRedirectDinamics(string $requestURL, array $dinamicRedirectRules) : void
    {
        foreach ($dinamicRedirectRules as $row) {
            if (\mb_str_pattern_match($requestURL, $row["OriginURL"]) === true) {
                $redirectTo         = \preg_replace($row["OriginURL"], $row["DestinyURL"], $requestURL);
                $parsedRedirectURL  = \parse_url($redirectTo);
                $parsedRequestURL   = \parse_url($requestURL);

                // Sendo para manter as querystrings da origem na URL de redirecionamento
                if ((bool)$row["KeepQuerystrings"] === true && $parsedRequestURL["query"] !== null) {
                    if ($parsedRedirectURL["query"] !== null) {
                        $parsedRedirectURL["query"] .= "&";
                    }
                    $parsedRedirectURL["query"] .= $parsedRequestURL["query"];
                    $redirectTo = \http_build_url($parsedRedirectURL);
                }


                $this->serverConfig->redirectTo(
                    $redirectTo,
                    (int)$row["HTTPCode"],
                    $row["HTTPMessage"]
                );
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
            if ($this->serverConfig->getRequestQueryStrings() !== "") {
                $qs = "_" . \sha1($this->serverConfig->getRequestQueryStrings());
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
