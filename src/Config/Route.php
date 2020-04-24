<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;







/**
 * Implementação de ``Config\iRoute``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Route extends BObject implements iRoute
{
    use \AeonDigital\Http\Traits\MimeTypeData;
    use \AeonDigital\Traits\MainCheckArgumentException;





    //
    // Os seguintes itens representam valores que DEVEM estar definidos para
    // que seja possível identificar com precisão a rota que deve ser executada
    // e suas configurações mais essenciais.
    //
    // APENAS PODEM SER DEFINIDOS ANTES DE INICIAR O PROCESSAMENTO DA ROTA EM SI.

    /**
     * Nome da aplicação que está sendo executada.
     *
     * @var         string
     */
    private string $application = "";
    /**
     * Retorna o nome da aplicação que está sendo executada.
     *
     * @return      string
     */
    public function getApplication() : string
    {
        return $this->application;
    }
    /**
     * Define o nome da aplicação que está sendo executada.
     *
     * @param       string $application
     *              Nome da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setApplication(string $application) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "application", $application, ["is string not empty"]
        );
        $this->application = $application;
    }





    /**
     * Namespace completa do controller que está respondendo a requisição.
     *
     * @var         string
     */
    private string $namespace = "";
    /**
     * Retorna a namespace completa do controller que está respondendo a requisição.
     *
     * @return      string
     */
    public function getNamespace() : string
    {
        return $this->namespace;
    }
    /**
     * Define a namespace completa do controller que está respondendo a requisição.
     *
     * @param       string $namespace
     *              Namespace do controller.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setNamespace(string $namespace) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "namespace", $namespace, ["is string not empty"]
        );
        $this->namespace = $namespace;
    }





    /**
     * Nome do controller que possui a action que deve resolver a rota.
     *
     * @var         string
     */
    private string $controller = "";
    /**
     * Retorna o nome do controller que possui a action que deve resolver a rota.
     *
     * @return      string
     */
    public function getController() : string
    {
        return $this->controller;
    }
    /**
     * Define o nome do controller que possui a action que deve resolver a rota.
     *
     * @param       string $controller
     *              Nome do controller.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setController(string $controller) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "controller", $controller, ["is string not empty"]
        );
        $this->controller = $controller;
    }





    /**
     * Retorna a namespace completa do controller que deve responder a esta
     * requisição.
     *
     * @return      string
     */
    function getControllerNamespace() : string
    {
        return $this->namespace . "\\" . $this->controller;
    }





    /**
     * Nome da action que resolve a rota.
     *
     * @var         string
     */
    private string $action = "";
    /**
     * Retorna o nome da action que resolve a rota.
     *
     * @return      string
     */
    public function getAction() : string
    {
        return $this->action;
    }
    /**
     * Define o nome da action que resolve a rota.
     *
     * @param       string $action
     *              Nome da action.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setAction(string $action) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "action", $action, ["is string not empty"]
        );
        $this->action = $action;
    }





    /**
     * Métodos ``HTTP`` que podem ser usados para esta mesma rota.
     *
     * @var         array
     */
    private array $allowedMethods = [];
    /**
     * Retorna os métodos ``HTTP`` que podem ser usados para esta mesma rota.
     *
     * @return      array
     */
    public function getAllowedMethods() : array
    {
        return $this->allowedMethods;
    }
    /**
     * Define os métodos ``HTTP`` que podem ser usados para esta mesma rota.
     *
     * @param       array $allowedMethods
     *              Métodos ``HTTP``.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setAllowedMethods(array $allowedMethods) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "allowedMethods", $allowedMethods, [
                ["validate" => "is array not empty"],
                [
                    "validate" => "foreach array child",
                    "foreachChild" => [
                        [
                            "validate" => "is allowed value",
                            "allowedValues" => [
                                "GET", "HEAD", "POST", "PUT", "PATCH", "DELETE",
                                "CONNECT", "OPTIONS", "TRACE"
                            ],
                            "caseInsensitive" => true
                        ]
                    ]
                ]
            ]
        );
        $this->allowedMethods= \array_map("strtoupper", $allowedMethods);
    }





    /**
     * Array associativo contendo a coleção de mimetypes que esta rota é capaz de
     * devolver como resposta.
     *
     * @var         array
     */
    private array $allowedMimeTypes = [];
    /**
     * Retorna um array associativo contendo a coleção de mimetypes que esta rota é capaz de
     * devolver como resposta.
     *
     * Esperado array associativo onde as chaves devem ser os valores abreviados (mime) e os
     * valores correspondem ao nome completo do (mimetype).
     *
     * Ex:
     * ```
     *  [ "txt" => "text/plain", "xhtml" => "application/xhtml+xml" ]
     * ```
     *
     * @return      array
     */
    public function getAllowedMimeTypes() : array
    {
        return $this->allowedMimeTypes;
    }
    /**
     * Define um array associativo contendo a coleção de mimetypes que esta rota é capaz de
     * devolver como resposta.
     *
     * Pode ser definido passando um array simples contendo unicamente a versão ``abreviada`` de
     * um mime (como ``txt``) ou usando um array associativo onde as chaves devem ser os valores
     * abreviados e os valores correspondem ao nome completo do mimetype
     *
     * Ex:
     * ```
     *  [ "txt", "xhtml" ]
     *   ou
     *  [ "txt" => "text/plain", "xhtml" => "application/xhtml+xml" ]
     * ```
     *
     * @param       array $allowedMimeTypes
     *              Array associativo contendo os mimes a serem usados.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setAllowedMimeTypes(array $allowedMimeTypes) : void
    {
        $this->allowedMimeTypes = $this->mainCheckForInvalidArgumentException(
            "allowedMimeTypes", $allowedMimeTypes, [
                [
                    "validate" => "is array not empty",
                    "executeBeforeReturn" => function($args) {
                        return (
                            (\array_is_assoc($args["argValue"]) === false) ?
                            \array_map("strtolower", $args["argValue"]) :
                            \array_map("strtolower", \array_keys($args["argValue"]))
                        );
                    }
                ],
                [
                    "validate" => "foreach array child",
                    "foreachChild" => [
                        [
                            "validate" => "is allowed value",
                            "allowedValues" => \array_keys($this->responseMimeTypes),
                            "caseInsensitive" => true
                        ]
                    ],
                    "executeBeforeReturn" => function($args) {
                        $nArr = [];
                        foreach ($args["argValue"] as $mime) {
                            $nArr[$mime] = $this->responseMimeTypes[$mime];
                        }

                        if (\key_exists("html", $nArr) === true) {
                            $r["xhtml"] = $this->responseMimeTypes["xhtml"];
                        }
                        return $nArr;
                    }
                ]
            ]
        );
    }





    /**
     * Método ``HTTP`` que está sendo usado para evocar esta rota.
     *
     * @var         string
     */
    private string $method = "";
    /**
     * Retorna o método ``HTTP`` que está sendo usado para evocar esta rota.
     *
     * @return      string
     */
    public function getMethod() : string
    {
        return $this->method;
    }
    /**
     * Define o método ``HTTP`` que está sendo usado para evocar esta rota.
     *
     * @param       string $method
     *              Método HTTP.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setMethod(string $method) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "method", $method, [
                [
                    "conditions" => "is string not empty",
                    "validate" => "is allowed value",
                    "allowedValues" => $this->allowedMethods,
                    "caseInsensitive" => true
                ]
            ]
        );
        $this->method = \strtoupper($method);
    }





    /**
     * Rota que está sendo resolvida e seus respectivos aliases.
     *
     * @var         array
     */
    private array $routes = [];
    /**
     * Retorna a rota que está sendo resolvida e seus respectivos aliases.
     * As rotas devem sempre ser definidas de forma relativa à raiz (começando com "/").
     *
     * @return      array
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }
    /**
     * Define a rota que está sendo resolvida e seus respectivos aliases.
     * As rotas devem sempre ser definidas de forma relativa à raiz (começando com "/").
     *
     * @param       array $routes
     *              Coleção de rotas que apontam para o mesmo recurso.
     *              A primeira rota definida será considerada a padrão.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setRoutes(array $routes) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "routes", $routes, [
                ["validate" => "is array not empty"],
                [
                    "validate" => "foreach array child",
                    "foreachChild" => [
                        ["validate" => "is string not empty"],
                    ],
                    "executeBeforeReturn" => function($args) {
                        $nArr = [];
                        foreach ($args["argValue"] as $r) {
                            $nArr[] = "/" . \trim($r, " /");
                        }
                        return $nArr;
                    }
                ]

            ]
        );
        $this->routes = $routes;
    }





    /**
     * Indica se a aplicação deve priorizar o uso do mime ``xhtml`` sobre o ``html``.
     *
     * @var         bool
     */
    private bool $isUseXHTML = false;
    /**
     * Retorna ``true`` caso aplicação deve priorizar o uso do mime ``xhtml`` sobre o ``html``.
     *
     * @return      bool
     */
    public function getIsUseXHTML() : bool
    {
        return $this->isUseXHTML;
    }
    /**
     * Define se a aplicação deve priorizar o uso do mime ``xhtml`` sobre o ``html``.
     *
     * @param       bool $isUseXHTML
     *              Indica se deve ser usado o mime ``xhtml``.
     *
     * @return      void
     */
    private function setIsUseXHTML(bool $isUseXHTML) : void
    {
        $this->isUseXHTML = $isUseXHTML;
    }





    /**
     * Nome do método que deve ser executado na classe da Aplicação para resolver a rota.
     *
     * @var         string
     */
    private string $runMethodName = "run";
    /**
     * Retorna o nome do método que deve ser executado na classe da Aplicação para resolver a rota.
     * Se não for definido deve retornar ``run`` como valor padrão.
     *
     * @return      string
     */
    public function getRunMethodName() : string
    {
        return $this->runMethodName;
    }
    /*
     * Define o nome do método que deve ser executado na classe da Aplicação para resolver a rota.
     *
     * @param       string $runMethodName
     *              Nome do método a ser executado.
     *
     * @return      void
     */
    private function setRunMethodName(string $runMethodName) : void
    {
        if ($runMethodName !== "") {
            $this->runMethodName = $runMethodName;
        }
    }





    /**
     * Coleção de propriedades customizadas da rota.
     *
     * @var         array
     */
    private array $customProperties = [];
    /**
     * Resgata um array associativo contendo propriedades customizadas para o processamento
     * da rota.
     *
     * @return      array
     */
    public function getCustomProperties() : array
    {
        return $this->customProperties;
    }
    /**
     * Define uma coleção de propriedades customizadas para o processamento da rota.
     *
     * @param       array $customProperties
     *              Array associativo contendo as informações customizadas.
     *
     * @return      void
     */
    private function setCustomProperties(array $customProperties) : void
    {
        $this->customProperties = $customProperties;
    }










    //
    // Os itens abaixo representam valores que PODEM ser definidos e tem como objetivo
    // aumentar as informações sobre esta a rota aqui representada mas não tem nenhuma
    // obrigatoriedade em ser usados.
    //
    // APENAS PODEM SER DEFINIDOS ANTES DE INICIAR O PROCESSAMENTO DA ROTA EM SI.

    /**
     * Descrição sobre a ação executada por esta rota.
     *
     * @var         string
     */
    private string $description = "";
    /**
     * Retorna uma descrição sobre a ação executada por esta rota.
     *
     * @return      string
     */
    public function getDescription() : string
    {
        return $this->description;
    }
    /**
     * Define uma descrição sobre a ação executada por esta rota.
     *
     * @param       string $description
     *              Descrição para a rota.
     *
     * @return      void
     */
    private function setDescription(string $description) : void
    {
        $this->description = $description;
    }





    /**
     * Descrição técnica para a rota.
     *
     * @var         string
     */
    private string $devDescription = "";
    /**
     * Retorna uma descrição técnica para a rota.
     * O formato MarkDown pode ser utilizado.
     *
     * @return      string
     */
    public function getDevDescription() : string
    {
        return $this->devDescription;
    }
    /**
     * Define uma descrição técnica para a rota.
     * O formato MarkDown pode ser utilizado.
     *
     * @param       string $devDescription
     *              Descrição técnica para a rota.
     *
     * @return      void
     */
    private function setDevDescription(string $devDescription) : void
    {
        $this->devDescription = $devDescription;
    }





    /**
     * Coleção de rotas e/ou URLs que tem relação com esta.
     *
     * @var         array
     */
    private array $relationedRoutes = [];
    /**
     * Retorna uma coleção de rotas e/ou URLs que tem relação com esta.
     *
     * @return      array
     */
    public function getRelationedRoutes() : array
    {
        return $this->relationedRoutes;
    }
    /**
     * Define uma coleção de rotas e/ou URLs que tem relação com esta.
     *
     * @param       array $relationedRoutes
     *              Coleção de rotas.
     *
     * @return      void
     */
    private function setRelationedRoutes(array $relationedRoutes) : void
    {
        $nrroutes = [];
        foreach ($relationedRoutes as $i => $r) {
            if (\is_string($r) === true && $r !== "") {
                $nrroutes[] = "/" . \trim($r, " /");
            }
        }
        $this->relationedRoutes = $nrroutes;
    }










    //
    // A partir daqui estão métodos que representam sub sistema que PODEM ou não serem
    // usados conforme cada rota.
    //
    // APENAS PODEM SER DEFINIDOS ANTES DE INICIAR O PROCESSAMENTO DA ROTA EM SI.


    //
    // SUB-SISTEMA: MIDDLEWARES

    /**
     * Coleção de nomes de Middlewares que devem ser executados durante o
     * processamento da rota alvo.
     *
     * @var         array
     */
    private array $middlewares = [];
    /**
     * Retorna a coleção de nomes de Middlewares que devem ser executados durante o
     * processamento da rota alvo.
     *
     * Cada item do array refere-se a um método existente na classe da aplicação que retorna uma
     * instância do Middleware alvo.
     *
     * @return      array
     */
    public function getMiddlewares() : array
    {
        return $this->middlewares;
    }
    /**
     * Define a coleção de nomes de Middlewares que devem ser executados durante o
     * processamento da rota alvo.
     *
     * Cada item do array refere-se a um método existente na classe da aplicação que retorna uma
     * instância do Middleware alvo.
     *
     * @param       array $middlewares
     *              Array de strings onde cada uma corresponde a um método que retorna o
     *              respectivo middleware.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setMiddlewares(array $middlewares) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "middlewares", $middlewares, [
                [
                    "conditions" => "is array not empty",
                    "validate" => "foreach array child",
                    "foreachChild" => [
                        [
                            "validate" => "is string not empty"
                        ]
                    ]
                ],
            ]
        );
        $this->middlewares = $middlewares;
    }





    //
    // SUB-SISTEMA: SEGURANÇA

    /**
     * Indica se a rota deve ser protegida pelo sistema de segurança da aplicação.
     *
     * @var         bool
     */
    private bool $isSecure = false;
    /**
     * Retorna ``true`` se a rota deve ser protegida pelo sistema de segurança da aplicação.
     *
     * Uma rota definida como segura DEVE ter o sistema de cache desabilitado.
     *
     * @return      bool
     */
    public function getIsSecure() : bool
    {
        return $this->isSecure;
    }
    /**
     * Define se a rota deve ser protegida pelo sistema de segurança da aplicação.
     *
     * @param       bool $isSecure
     *              Use "true" para proteger a rota.
     *
     * @return      void
     */
    private function setIsSecure(bool $isSecure) : void
    {
        $this->isSecure = $isSecure;
    }





    //
    // SUB-SISTEMA: CACHE

    /**
     * Indica se a rota possui um conteúdo cacheável.
     *
     * @var         bool
     */
    private bool $isUseCache = false;
    /**
     * Retorna ``true`` se a rota possui um conteúdo cacheável.
     *
     * Apenas retornará ``true`` se, alem de definido assim a propriedade ``cacheTimeout`` for
     * maior que zero, ``isSecure`` for ``false`` e o método que está sendo usado para responder
     * ao ``UA`` for ``HEAD`` ou ``GET``.
     *
     * @return      bool
     */
    public function getIsUseCache() : bool
    {
        return (
            $this->isUseCache === true &&
            $this->cacheTimeout > 0 &&
            $this->isSecure === false &&
            \in_array($this->getMethod(), ["HEAD", "GET"])
        );
    }
    /**
     * Define se a rota possui um conteúdo cacheável.
     *
     * @param       bool $isUseCache
     *              Use ``true`` para definir que a rota deve ser cacheada.
     *
     * @return      void
     */
    private function setIsUseCache(bool $isUseCache) : void
    {
        $this->isUseCache = $isUseCache;
    }





    /**
     * Tempo (em minutos) pelo qual o documento em cache deve ser armazenado até
     * expirar.
     *
     * @var         int
     */
    private int $cacheTimeout = 0;
    /**
     * Retorna o tempo (em minutos) pelo qual o documento em cache deve ser armazenado até
     * expirar.
     *
     * Um valor igual a ``0`` indica que o armazenamento não deve ser feito (tal qual se o sistema
     * de cache estivesse desativado).
     *
     * Não deve existir uma forma de cache infinito.
     *
     * @return      int
     */
    public function getCacheTimeout() : int
    {
        return $this->cacheTimeout;
    }
    /**
     * Define o tempo (em minutos) pelo qual o documento em cache deve ser armazenado até
     * expirar.
     *
     * @param       int $cacheTimeout
     *              Tempo (em minutos) para o timeout do documento em cache.
     *
     * @return      void
     */
    public function setCacheTimeout(int $cacheTimeout) : void
    {
        $this->cacheTimeout = (($cacheTimeout < 0) ? 0 : $cacheTimeout);
    }





    //
    // SUB-SISTEMA: NEGOCIAÇÃO DE CONTEÚDO
    // Não é um sistema em si, mas uma coleção de valores que serão inferidos antes de
    // efetivamente executar a rota.

    /**
     * Locale a ser usado para resolver esta rota.
     *
     * @var         string
     */
    private string $responseLocale = "";
    /**
     * Retorna o Locale a ser usado para resolver esta rota.
     *
     * @return      string
     */
    public function getResponseLocale() : string
    {
        return $this->responseLocale;
    }





    /**
     * Mime (extenção) a ser usado para resolver esta rota.
     *
     * @var         string
     */
    private string $responseMime = "";
    /**
     * Retorna o Mime (extenção) a ser usado para resolver esta rota.
     *
     * @return      string
     */
    public function getResponseMime() : string
    {
        return $this->responseMime;
    }





    /**
     * MimeType (canônico) a ser usado para resolver esta rota.
     *
     * @var         string
     */
    private string $responseMimeType = "";
    /**
     * Retorna o MimeType (canônico) a ser usado para resolver esta rota.
     *
     * @return      string
     */
    public function getResponseMimeType() : string
    {
        return $this->responseMimeType;
    }





    /**
     * Indica quando o código de retorno deve ser tratado para facilitar a leitura por humanos.
     *
     * @var         bool
     */
    private bool $responseIsPrettyPrint = false;
    /**
     * Quando ``true`` indica que o código de retorno deve passar por algum tratamento que
     * facilite a leitura do mesmo por humanos.
     *
     * @return      bool
     */
    public function getResponseIsPrettyPrint() : bool
    {
        return $this->responseIsPrettyPrint;
    }
    /**
     * Define se o código de retorno deve passar por algum tratamento que facilite a leitura
     * do mesmo por humanos.
     *
     * @param       bool $responseIsPrettyPrint
     *              Indica se o código deve ser tratado ou não.
     *
     * @return      void
     */
    private function setResponseIsPrettyPrint(bool $responseIsPrettyPrint) : void
    {
        $this->responseIsPrettyPrint = $responseIsPrettyPrint;
    }





    /**
     * Indica se o resultado da execução da rota deve ser um download.
     *
     * @var         bool
     */
    private bool $responseIsDownload = false;
    /**
     * Retorna ``true`` se o resultado da execução da rota deve ser uma resposta em formato de
     * download.
     *
     * @return      bool
     */
    public function getResponseIsDownload() : bool
    {
        return $this->responseIsDownload;
    }
    /**
     * Define se o resultado da execução da rota deve ser uma resposta em formato de download.
     *
     * @param       bool $responseIsDownload
     *              Use ``true`` para definir que o resultado a ser submetido ao UA é um download.
     *
     * @return      void
     */
    public function setResponseIsDownload(bool $responseIsDownload) : void
    {
        $this->responseIsDownload = $responseIsDownload;
    }





    /**
     * Processa a negociação de conteúdo para identificar qual locale deve ser usado para
     * responder a esta rota.
     *
     * Esta ação deve ser executada ANTES do processamento da rota para que tal resultado
     * seja conhecido durante sua execução.
     *
     * Irá preencher o valor que deve ser retornado em ``$this->getResponseLocale()``.
     *
     * @param       ?array $requestLocales
     *              Coleção de Locales que o ``UA`` explicitou preferência.
     *
     * @param       ?array $requestLanguages
     *              Coleção de linguagens em que o ``UA`` explicitou preferência.
     *
     * @param       ?array $applicationLocales
     *              Coleção de locales usados pela Aplicação.
     *
     * @param       ?string $defaultLocale
     *              Locale padrão da Aplicação.
     *
     * @param       ?string $forceLocale
     *              Locale que terá prioridade sobre os demais podendo inclusive ser um que a
     *              aplicação não esteja apta a servir.
     *
     * @return      bool
     *              Retorna ``true`` caso tenha sido possível identificar o locale a ser usado.
     */
    public function negotiateLocale(
        ?array $requestLocales,
        ?array $requestLanguages,
        ?array $applicationLocales,
        ?string $defaultLocale,
        ?string $forceLocale
    ) : bool {
        $useLocale = "";

        if ($this->responseLocale === "") {
            // Havendo um locale que deve ser usado de forma forçada.
            if ($forceLocale !== null) {
                $useLocale = $forceLocale;
            }
            // Senão, negocia o locale que deve ser usado
            else {

                // Verifica se algum dos Locales definidos pelos headers
                // enviados pelo UA são também fornecidos pela aplicação.
                if ($requestLocales === null) { $requestLocales = []; }
                foreach ($requestLocales as $headerLocale) {
                    if (\array_in_ci($headerLocale, $applicationLocales) === true) {
                        $useLocale = $headerLocale;
                        break;
                    }
                }


                // Se nenhum dos locales servidos pela aplicação corresponde
                // a algum que o UA queira, verifica se há linguas compatíveis
                if ($useLocale === "") {
                    // Linguagens que o UA passou como sendo aquelas que ele prefere.
                    if ($requestLanguages === null) { $requestLanguages = []; }

                    $appLanguages = [];
                    $appLan = [];
                    foreach ($requestLanguages as $i => $headerLanguage) {
                        if ($i === 0) {
                            foreach ($applicationLocales as $appLocale) {
                                $appLanguages[$appLocale] = \substr($appLocale, 0, 2);
                            }
                            $appLan = \array_values($appLanguages);
                        }

                        if (\array_in_ci($headerLanguage, $appLan) === true) {
                            $useLocale = \array_search($headerLanguage, $appLanguages);
                            break;
                        }
                    }
                }


                // Se nenhum locale foi identificado
                // usa o padrão
                if ($useLocale === "") { $useLocale = $defaultLocale; }
            }

            $this->responseLocale = \strtolower($useLocale);
        }

        return ($this->responseLocale !== "");
    }





    /**
     * Processa a negociação de conteúdo para identificar qual mimetype deve ser usado para
     * responder a esta rota.
     *
     * Esta ação deve ser executada ANTES do processamento da rota para que tal resultado
     * seja conhecido durante sua execução.
     *
     * Irá preencher os valores que devem ser retornados nos métodos ``$this->getResponseMime()``
     * e ``$this->getResponseMimeType()``.
     *
     * @param       ?array $requestMimes
     *              Coleção de mimeTypes que o ``UA`` explicitou preferência.
     *
     * @param       ?string $forceMime
     *              Mime que terá prioridade sobre os demais podendo inclusive ser um que a rota
     *              não esteja apta a utilizar.
     *
     * @return      bool
     *              Retorna ``true`` caso tenha sido possível identificar o mimetype a ser usado.
     */
    public function negotiateMimeType(
        ?array $requestMimes,
        ?string $forceMime
    ) : bool {

        if ($this->responseMime === "") {
            $allowedMimeTypes   = $this->getAllowedMimeTypes();
            $isUseXhtml         = $this->getIsUseXHTML();

            $useAny             = false;
            $useMime            = null;


            // Se um dado mimetype está sendo forçado
            if ($forceMime !== null) {
                // Se o mimetype que está sendo forçado é válido
                if (isset($this->responseMimeTypes[$forceMime]) === true) {
                    $useMime = $forceMime;
                }
            }
            else {
                if ($requestMimes === null) {
                    $requestMimes = [
                        ["mime" => "", "mimetype" => ""]
                    ];
                }

                // Verifica se algum dos Mimes definidos pelos headers
                // enviados pelo UA são fornecidos por esta rota.
                foreach ($requestMimes as $headerMime) {
                    $rMime = $headerMime["mime"];
                    $useAny = (($rMime === "*/*") ? true : $useAny);
                    if (isset($allowedMimeTypes[$rMime]) === true) {
                        $useMime = $rMime;
                        break;
                    }
                }
            }


            // Se não encontrou um mime compatível mas entre as regras
            // do UA é permitido usar qualquer um, seleciona o primeiro
            // que a rota disponibiliza
            if ($useMime === null && $useAny === true) {
                $useMime = \key($allowedMimeTypes);
            }


            // Sendo para retornar um documento "html" e
            // a aplicação estando configurada para forçar uma
            // saida "xhtml", identifica esta situação e força-a.
            if ($useMime === "html" && $isUseXhtml === true) {
                $useMime = "xhtml";
            }


            // Tendo encontrado algum mime para ser usado,
            // preenche o mimetype
            if ($useMime !== null) {
                $this->responseMime     = $useMime;
                $this->responseMimeType = $this->responseMimeTypes[$useMime];
            }
        }

        return ($this->responseMime !== "");
    }










    //
    // OS ITENS ABAIXO PODEM TER SEUS VALORES ALTERADOS DURANTE A EXECUÇÃO DA ROTA.

    /**
     * Nome do documento enviado por download.
     *
     * @var         string
     */
    private string $responseDownloadFileName = "";
    /**
     * Retorna o nome do documento que deve ser devolvido ao efetuar o download da rota.
     * Se nenhum nome for definido de forma explicita, este valor será criado a partir do nome da
     * rota principal.
     *
     * @return      string
     */
    public function getResponseDownloadFileName() : string
    {
        return $this->responseDownloadFileName;
    }
    /**
     * Define o nome do documento que deve ser devolvido ao efetuar o download da rota.
     *
     * @param       string $responseDownloadFileName
     *              Nome do arquivo que será enviado ao UA como um download.
     *
     * @return      void
     */
    public function setResponseDownloadFileName(string $responseDownloadFileName) : void
    {
        $this->responseDownloadFileName = $responseDownloadFileName;
    }





    /**
     * Coleção de headers a serem enviados para o ``UA``.
     *
     * @var         array
     */
    private array $responseHeaders = [];
    /**
     * Retorna a coleção de headers a serem enviados na resposta para o ``UA``.
     *
     * @return      array
     */
    public function getResponseHeaders() : array
    {
        return $this->responseHeaders;
    }
    /**
     * Define uma coleção de headers a serem enviados na resposta para o ``UA``.
     * As chaves de valores informadas devem ser tratadas em ``case-insensitive``.
     *
     * @param       array $responseHeaders
     *              Array associativo [key => value] contendo a coleção de headers a serem
     *              enviados ao ``UA``.
     *
     * @return      void
     */
    public function setResponseHeaders(array $responseHeaders) : void
    {
        $headers = [];
        foreach ($responseHeaders as $k => $v) {
            if (\is_string($k) === true && $k !== "" && \array_in_ci($k, \array_keys($headers)) === false) {
                $headers[$k] = (string)$v;
            }
        }
        $this->responseHeaders = $headers;
    }
    /**
     * Adiciona novos itens na coleção de headers.
     *
     * @param       array $responseHeaders
     *              Array associativo [key => value] contendo a coleção de headers a serem
     *              enviados ao ``UA``.
     *
     * @return      void
     */
    public function addResponseHeaders(array $responseHeaders) : void
    {
        $this->setResponseHeaders(\array_merge($this->responseHeaders, $responseHeaders));
    }










    //
    // Os itens a seguir podem ter seus valores pré-definidos na definição principal da rota.
    // Quando não definidos, irão herdar (se possível) as definições existentes na configuração
    // de sua própria aplicação.
    //
    // TODOS OS ITENS ABAIXO PODEM SER REDEFINIDOS EM TEMPO DE EXECUÇÃO DURANTE O PROCESSAMENTO
    // DESTA PRÓPRIA ROTA.

    /**
     * Caminho relativo (a partir de ``appRootPath``) até a master page que será utilizada.
     *
     * @var         string
     */
    private string $masterPage = "";
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até a master page que será
     * utilizada.
     *
     * @return      string
     */
    public function getMasterPage() : string
    {
        return $this->masterPage;
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até a master page que será
     * utilizada.
     *
     * @param       string $masterPage
     *              Caminho relativo até a master page.
     *
     * @return      void
     */
    public function setMasterPage(string $masterPage) : void
    {
        $this->masterPage = $masterPage;
    }





    /**
     * Caminho relativo (a partir do diretório definido para as views) até a view que será utilizada.
     *
     * @var         string
     */
    private string $view = "";
    /**
     * Retorna o caminho relativo (a partir do diretório definido para as views) até a view
     * que será utilizada.
     *
     * @return      string
     */
    public function getView() : string
    {
        return $this->view;
    }
    /**
     * Define o caminho relativo (a partir do diretório definido para as views) até a view
     * que será utilizada.
     *
     * @param       string $view
     *              Caminho relativo até a view.
     *
     * @return      void
     */
    public function setView(string $view) : void
    {
        $this->view = $view;
    }





    /**
     * Coleção de folhas de estilo que devem ser vinculados na view.
     *
     * @var         array
     */
    private array $styleSheets = [];
    /**
     * Retorna uma coleção de caminhos até as folhas de estilos que devem ser incorporadas no
     * documento final (caso trate-se de um formato que aceita este tipo de recurso).
     *
     * @return      array
     */
    public function getStyleSheets() : array
    {
        return $this->styleSheets;
    }
    /**
     * Redefine toda coleção de caminhos até as folhas de estilos que devem ser incorporadas no
     * documento final (caso trate-se de um formato que aceita este tipo de recurso.)
     *
     * Os caminhos dos CSSs devem ser relativos e iniciando a partir do diretório destinado
     * aos recursos HTML definidos em ``iApplicationConfig->getPathToViewsResources();``.
     *
     * @param       array $styleSheets
     *              Coleção de folhas de estilos.
     *
     * @return      void
     */
    public function setStyleSheets(array $styleSheets) : void
    {
        $styles = [];
        foreach ($styleSheets as $i => $s) {
            if (\is_string($s) !== false && $s !== "") {
                $styles[] = $s;
            }
        }
        $this->styleSheets = $styles;
    }
    /**
     * Adiciona novas folhas de estilo na coleção existente.
     *
     * Os caminhos dos CSSs devem ser relativos e iniciando a partir do diretório destinado aos
     * recursos HTML definidos em ``iApplicationConfig->getPathToViewsResources();``.
     *
     * @param       array $styleSheets
     *              Coleção de folhas de estilo a serem adicionadas na lista atual.
     *
     * @return      void
     */
    public function addStyleSheets(array $styleSheets) : void
    {
        $this->setStyleSheets(\array_merge($this->styleSheets, $styleSheets));
    }





    /**
     * Coleção de scripts que devem ser vinculados na view.
     *
     * @var         array
     */
    private array $javaScripts = [];
    /**
     * Retorna uma coleção de caminhos até as scripts que devem ser incorporadas no documento
     * final (caso trate-se de um formato que aceita este tipo de recurso).
     *
     * @return      array
     */
    public function getJavaScripts() : array
    {
        return $this->javaScripts;
    }
    /**
     * Redefine toda coleção de caminhos até as scripts que devem ser incorporadas no documento
     * final (caso trate-se de um formato que aceita este tipo de recurso.)
     *
     * Os caminhos dos scripts devem ser relativos e iniciando a partir do diretório destinado aos
     * recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
     *
     * @param       array $javaScripts
     *              Coleção de scripts.
     *
     * @return      void
     */
    public function setJavaScripts(array $javaScripts) : void
    {
        $scripts = [];
        foreach ($javaScripts as $i => $s) {
            if (\is_string($s) !== false && $s !== "") {
                $scripts[] = $s;
            }
        }
        $this->javaScripts = $scripts;
    }
    /**
     * Adiciona novos scripts na coleção existente.
     *
     * Os caminhos dos scripts devem ser relativos e iniciando a partir do diretório destinado aos
     * recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
     *
     * @param       array $javaScripts
     *              Coleção de scripts a serem adicionadas na lista atual.
     *
     * @return      void
     */
    public function addJavaScripts(array $javaScripts) : void
    {
        $this->setJavaScripts(\array_merge($this->javaScripts, $javaScripts));
    }





    /**
     * Coleção de metadados a serem incorporados na view X/HTML.
     *
     * @var         array
     */
    private array $metaData = [];
    /**
     * Retorna a coleção de metadados a serem incorporados nas views ``X/HTML``.
     *
     * @return      array
     */
    public function getMetaData() : array
    {
        return $this->metaData;
    }
    /**
     * Redefinr a coleção de metadados a serem incorporados nas views ``X/HTML``.
     * As chaves de valores informadas devem ser tratadas em ``case-insensitive``.
     *
     * @param       array $metaData
     *              Array associativo [key => value] contendo a coleção de itens a serem adicionados
     *              na tag <head> em formato <meta name="key" content="value" />
     *
     * @return      void
     */
    public function setMetaData(array $metaData) : void
    {
        $meta = [];
        foreach ($metaData as $k => $v) {
            if (\is_string($k) === true && $k !== "" && \array_in_ci($k, \array_keys($meta)) === false) {
                $meta[$k] = (string)$v;
            }
        }
        $this->metaData = $meta;
    }
    /**
     * Adiciona novos itens na coleção existente.
     *
     * @param       array $metaData
     *              Array associativo [key => value] contendo a coleção de itens a serem adicionados
     *              na tag <head> em formato <meta name="key" content="value" />
     *
     * @return      void
     */
    public function addMetaData(array $metaData) : void
    {
        $this->setMetaData(\array_merge($this->metaData, $metaData));
    }





    /**
     * Caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
     * que será usado para responder a requisição.
     *
     * @var         string
     */
    private string $localeDictionary = "";
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
     * que será usado para responder a requisição.
     *
     * @return      string
     */
    public function getLocaleDictionary() : string
    {
        return $this->localeDictionary;
    }
    /*
     * Define o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do
     * locale que será usado para responder a requisição.
     *
     * @param       string $localeDictionary
     *              Caminho relativo até o arquivo de legendas.
     *
     * @return      void
     */
    public function setLocaleDictionary(string $localeDictionary) : void
    {
        $this->localeDictionary = $localeDictionary;
    }










    /**
     * Inicia uma instância de configuração para a rota.
     *
     * @param       string $application
     *              Obrigatório. Nome da aplicação que está sendo executada.
     *
     * @param       string $namespace
     *              Obrigatório. Namespace completa do controller que está respondendo a requisição.
     *
     * @param       string $controller
     *              Obrigatório. Nome do controller que possui a action que deve resolver a rota.
     *
     * @param       string $action
     *              Obrigatório. Nome da action que resolve a rota.
     *
     * @param       array $allowedMethods
     *              Obrigatório. Métodos ``HTTP`` que podem ser usados para esta mesma rota.
     *
     * @param       array $allowedMimeTypes
     *              Obrigatório. Array contendo a coleção de mimetypes que esta rota é capaz de
     *              devolver como resposta.
     *
     * @param       string $method
     *              Obrigatório. Método ``HTTP`` que está sendo usado para evocar esta rota.
     *
     * @param       array $routes
     *              Obrigatório. Rota que está sendo resolvida e seus respectivos aliases.
     *
     * @param       bool $isUseXHTML
     *              Indica se a aplicação deve priorizar o uso do mime ``xhtml`` sobre o ``html``.
     *
     * @param       string $runMethodName
     *              Nome do método que deve ser executado na classe da Aplicação para resolver a rota.
     *
     * @param       array $customProperties
     *              Coleção de propriedades customizadas da rota.
     *
     * @param       string $description
     *              Descrição sobre a ação executada por esta rota.
     *
     * @param       string $devDescription
     *              Descrição técnica para a rota.
     *
     * @param       array $relationedRoutes
     *              Coleção de rotas e/ou URLs que tem relação com esta.
     *
     * @param       array $middlewares
     *              Coleção de nomes de Middlewares que devem ser executados durante o
     *              processamento da rota alvo.
     *
     * @param       bool $isSecure
     *              Indica se a rota deve ser protegida pelo sistema de segurança da aplicação.
     *
     * @param       bool $isUseCache
     *              Indica se a rota possui um conteúdo cacheável.
     *
     * @param       int $cacheTimeout
     *              Tempo (em minutos) pelo qual o documento em cache deve ser armazenado até
     *              expirar.
     *
     * @param       bool $responseIsPrettyPrint
     *              Indica quando o código de retorno deve ser tratado para facilitar a leitura por humanos.
     *
     * @param       bool $responseIsDownload
     *              Indica se o resultado da execução da rota deve ser um download.
     *
     * @param       string $responseDownloadFileName
     *              Nome do documento enviado por download.
     *
     * @param       array $responseHeaders
     *              Coleção de headers a serem enviados para o ``UA``.
     *
     * @param       string $masterPage
     *              Caminho relativo (a partir de ``appRootPath``) até a master page que será utilizada.
     *
     * @param       string $view
     *              Caminho relativo (a partir do diretório definido para as views) até a view que será utilizada.
     *
     * @param       array $styleSheets
     *              Coleção de folhas de estilo que devem ser vinculados na view.
     *
     * @param       array $javaScripts
     *              Coleção de scripts que devem ser vinculados na view.
     *
     * @param       array $metaData
     *              Coleção de metadados a serem incorporados na view X/HTML.
     *
     * @param       string $localeDictionary
     *              Caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
     *              que será usado para responder a requisição.
     *
     */
    function __construct(
        string $application,
        string $namespace,
        string $controller,
        string $action,
        array $allowedMethods,
        array $allowedMimeTypes,
        string $method,
        array $routes,
        bool $isUseXHTML,
        string $runMethodName,
        array $customProperties,
        string $description,
        string $devDescription,
        array $relationedRoutes,
        array $middlewares,
        bool $isSecure,
        bool $isUseCache,
        int $cacheTimeout,
        bool $responseIsPrettyPrint = false,
        bool $responseIsDownload = false,
        string $responseDownloadFileName = "",
        array $responseHeaders = [],
        string $masterPage = "",
        string $view = "",
        array $styleSheets = [],
        array $javaScripts = [],
        array $metaData = [],
        string $localeDictionary = ""
    ) {
        $this->setApplication($application);
        $this->setNamespace($namespace);
        $this->setController($controller);
        $this->setAction($action);
        $this->setAllowedMethods($allowedMethods);
        $this->setAllowedMimeTypes($allowedMimeTypes);
        $this->setMethod($method);
        $this->setRoutes($routes);
        $this->setIsUseXHTML($isUseXHTML);
        $this->setRunMethodName($runMethodName);
        $this->setCustomProperties($customProperties);
        $this->setDescription($description);
        $this->setDevDescription($devDescription);
        $this->setRelationedRoutes($relationedRoutes);
        $this->setMiddlewares($middlewares);
        $this->setIsSecure($isSecure);
        $this->setIsUseCache($isUseCache);
        $this->setCacheTimeout($cacheTimeout);

        $this->setResponseIsPrettyPrint($responseIsPrettyPrint);
        $this->setResponseIsDownload($responseIsDownload);
        $this->setResponseDownloadFileName($responseDownloadFileName);
        $this->setResponseHeaders($responseHeaders);
        $this->setMasterPage($masterPage);
        $this->setView($view);
        $this->setStyleSheets($styleSheets);
        $this->setJavaScripts($javaScripts);
        $this->setMetaData($metaData);
        $this->setLocaleDictionary($localeDictionary);
    }










    //
    // Métodos de criação e extração dos dados aqui definidos.

    /**
     * Retorna uma instância configurada a partir de um array que contenha
     * as chaves correlacionadas a cada propriedade aqui definida.
     *
     * @codeCoverageIgnore
     *
     * @param       array $config
     *              Array associativo contendo os valores a serem definidos para a instância.
     *
     * @return      iRoute
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public static function fromArray(array $config) : iRoute
    {
        $useConfig = \array_merge(
            [
                "application"               => "",
                "namespace"                 => "",
                "controller"                => "",
                "action"                    => "",
                "allowedMethods"            => [],
                "allowedMimeTypes"          => [],
                "method"                    => "",
                "routes"                    => [],
                "isUseXHTML"                => false,
                "runMethodName"             => "",
                "customProperties"          => [],
                "description"               => "",
                "devDescription"            => "",
                "relationedRoutes"          => [],
                "middlewares"               => [],
                "isSecure"                  => false,
                "isUseCache"                => false,
                "cacheTimeout"              => 0,
                "responseIsPrettyPrint"     => false,
                "responseIsDownload"        => false,
                "responseDownloadFileName"  => "",
                "responseHeaders"           => [],
                "masterPage"                => "",
                "view"                      => "",
                "styleSheets"               => [],
                "javaScripts"               => [],
                "metaData"                  => [],
                "localeDictionary"          => ""
            ],
            $config
        );


        return new Route(
            $useConfig["application"],
            $useConfig["namespace"],
            $useConfig["controller"],
            $useConfig["action"],
            $useConfig["allowedMethods"],
            $useConfig["allowedMimeTypes"],
            $useConfig["method"],
            $useConfig["routes"],
            $useConfig["isUseXHTML"],
            $useConfig["runMethodName"],
            $useConfig["customProperties"],
            $useConfig["description"],
            $useConfig["devDescription"],
            $useConfig["relationedRoutes"],
            $useConfig["middlewares"],
            $useConfig["isSecure"],
            $useConfig["isUseCache"],
            $useConfig["cacheTimeout"],
            $useConfig["responseIsPrettyPrint"],
            $useConfig["responseIsDownload"],
            $useConfig["responseDownloadFileName"],
            $useConfig["responseHeaders"],
            $useConfig["masterPage"],
            $useConfig["view"],
            $useConfig["styleSheets"],
            $useConfig["javaScripts"],
            $useConfig["metaData"],
            $useConfig["localeDictionary"]
        );
    }
    /**
     * Retorna uma instância configurada a partir de uma uma string estruturada de forma a
     * receber os valores mínimos a serem usados para as definições de uma rota.
     *
     * @codeCoverageIgnore
     *
     * @param       string $config
     *              String estruturada.
     *
     * @return      iRoute
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public static function fromString(string $config) : iRoute
    {

    }
    /**
     * Converte as propriedades definidas neste objeto para um ``array associativo``.
     *
     * @codeCoverageIgnore
     *
     * @return      array
     */
    public function toArray() : array
    {
        return [
            "application"               => $this->getApplication(),
            "namespace"                 => $this->getNamespace(),
            "controller"                => $this->getController(),
            "action"                    => $this->getAction(),
            "allowedMethods"            => $this->getAllowedMethods(),
            "allowedMimeTypes"          => $this->getAllowedMimeTypes(),
            "method"                    => $this->getMethod(),
            "routes"                    => $this->getRoutes(),
            "isUseXHTML"                => $this->getIsUseXHTML(),
            "runMethodName"             => $this->getRunMethodName(),
            "customProperties"          => $this->getCustomProperties(),
            "description"               => $this->getDescription(),
            "devDescription"            => $this->getDevDescription(),
            "relationedRoutes"          => $this->getRelationedRoutes(),
            "middlewares"               => $this->getMiddlewares(),
            "isSecure"                  => $this->getIsSecure(),
            "isUseCache"                => $this->getIsUseCache(),
            "cacheTimeout"              => $this->getCacheTimeout(),
            "responseIsPrettyPrint"     => $this->getResponseIsPrettyPrint(),
            "responseIsDownload"        => $this->getResponseIsDownload(),
            "responseDownloadFileName"  => $this->getResponseDownloadFileName(),
            "responseHeaders"           => $this->getResponseHeaders(),
            "masterPage"                => $this->getMasterPage(),
            "view"                      => $this->getView(),
            "styleSheets"               => $this->getStyleSheets(),
            "javaScripts"               => $this->getJavaScripts(),
            "metaData"                  => $this->getMetaData(),
            "localeDictionary"          => $this->getLocaleDictionary()
        ];
    }
}
