<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;








/**
 * Implementação de ``iRoute``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Route implements iRoute
{
    use \AeonDigital\Http\Traits\MimeTypeData;





    /**
     * Enquanto for ``false`` permite que as propriedades sejam alteradas.
     *
     * Quando ``true`` apenas as propriedades devidamente identificadas é que podem ser alteradas.
     *
     * @var     bool
     */
    private $isLockProperties = false;










    /**
     * Verifica se o método ``HTTP`` indicado é válido.
     *
     * @param       string $method
     *              Método que será verificado.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function checkMethod(string $method) : bool
    {
        $validMethod = ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "CONNECT", "OPTIONS", "TRACE"];
        if (array_in_ci($method, $validMethod) === false) {
            $err = "Invalid Method. Expected one of : \"" . implode("\", \"", $validMethod) . "\".";
            throw new \InvalidArgumentException($err);
        }
        return true;
    }










    /**
     * Nome da aplicação que está sendo executada.
     *
     * @var         string
     */
    private $application = null;
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
     * Este valor não pode ser sobrescrito.
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $application
     *              Nome da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setApplication(string $application) : void
    {
        if ($this->isLockProperties === false) {
            if ($this->application === null) {
                if ($application === "") {
                    $err = "Invalid Application. Must be a not empty string.";
                    throw new \InvalidArgumentException($err);
                }
                $this->application = $application;
            }
        }
    }










    /**
     * Namespace completa do controller que está respondendo a requisição.
     *
     * @var         string
     */
    private $namespace = null;
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
     * Este valor não pode ser sobrescrito.
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $namespace
     *              Namespace do controller.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setNamespace(string $namespace) : void
    {
        if ($this->isLockProperties === false) {
            if ($this->namespace === null) {
                if ($namespace === "") {
                    $err = "Invalid Namespace. Must be a not empty string.";
                    throw new \InvalidArgumentException($err);
                }
                $this->namespace = $namespace;
            }
        }
    }










    /**
     * Nome do controller que possui a action que deve resolver a rota.
     *
     * @var         string
     */
    private $controller = null;
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
     * Este valor não pode ser sobrescrito.
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $controller
     *              Nome do controller.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setController(string $controller) : void
    {
        if ($this->isLockProperties === false) {
            if ($this->controller === null) {
                if ($controller === "") {
                    $err = "Invalid Controller. Must be a not empty string.";
                    throw new \InvalidArgumentException($err);
                }
                $this->controller = $controller;
            }
        }
    }










    /**
     * Nome da action que resolve a rota.
     *
     * @var         string
     */
    private $action = null;
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
     * Este valor não pode ser sobrescrito.
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $action
     *              Nome da action.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setAction(string $action) : void
    {
        if ($this->isLockProperties === false) {
            if ($this->action === null) {
                if ($action === "") {
                    $err = "Invalid Action. Must be a not empty string.";
                    throw new \InvalidArgumentException($err);
                }
                $this->action = $action;
            }
        }
    }










    /**
     * Método ``HTTP`` usado para evocar esta rota.
     *
     * @var         string
     */
    private $method = null;
    /**
     * Retorna o método ``HTTP`` que deve ser usado para evocar esta rota.
     *
     * @return      string
     */
    public function getMethod() : string
    {
        return $this->method;
    }
    /**
     * Define o método ``HTTP`` que deve ser usado para evocar esta rota.
     *
     * Este valor não pode ser sobrescrito.
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $method
     *              Método HTTP.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setMethod(string $method) : void
    {
        if ($this->isLockProperties === false) {
            if ($this->method === null) {
                $this->checkMethod($method);
                $this->method = strtoupper($method);
            }
        }
    }










    /**
     * Método ``HTTP`` usado para evocar esta rota.
     *
     * @var         string
     */
    private $allowedMethods = null;
    /**
     * Retorna os métodos ``HTTP`` que podem ser usados para esta mesma rota.
     *
     * @return      array
     */
    public function getAllowedMethods() : array
    {
        if ($this->allowedMethods === null && $this->method !== null) {
            $this->allowedMethods = [$this->method];
        }
        return $this->allowedMethods;
    }
    /**
     * Define os métodos ``HTTP`` que podem ser usados para esta mesma rota.
     *
     * Este valor não pode ser sobrescrito.
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       array $methods
     *              Métodos ``HTTP``.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setAllowedMethods(array $methods) : void
    {
        if ($this->isLockProperties === false) {
            if ($this->allowedMethods === null) {
                $this->allowedMethods = [];
                foreach ($methods as $method) {
                    $this->checkMethod($method);
                    $this->allowedMethods[] = strtoupper($method);
                }
            }
        }
    }










    /**
     * Rota que está sendo resolvida e seus respectivos aliases.
     *
     * @var         array
     */
    private $routes = null;
    /**
     * Retorna a rota que está sendo resolvida e seus respectivos aliases.
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
     * Este valor não pode ser sobrescrito.
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
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
    public function setRoutes(array $routes) : void
    {
        if ($this->isLockProperties === false) {
            if ($this->routes === null) {
                if (count($routes) === 0) {
                    $err = "Invalid Routes. The array must have at last one value.";
                    throw new \InvalidArgumentException($err);
                } else {
                    foreach ($routes as $i => $r) {
                        if (is_string($r) === false || $r === "") {
                            $err = "Invalid Route definition. Empty strings are not valid.";
                            throw new \InvalidArgumentException($err);
                        }
                        $routes[$i] = "/" . trim($r, " /");
                    }
                }
                $this->routes = $routes;
            }
        }
    }










    /**
     * Array associativo contendo a coleção de mimetypes que esta rota é capaz de devolver como
     * resposta.
     *
     * @var         array
     */
    private $acceptMimes = null;
    /**
     * Retorna um array associativo contendo a coleção de mimetypes que esta rota é capaz de
     * devolver como resposta.
     *
     * @return      array
     */
    public function getAcceptMimes() : array
    {
        $r = (($this->acceptMimes === null) ? ["html" => "text/html"] : $this->acceptMimes);
        if (isset($r["html"]) === true) {
            $r["xhtml"] = "application/xhtml+xml";
        }
        return $r;
    }
    /**
     * Define uma coleção de mimetypes que esta rota deve ser capaz de devolver como resposta.
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
     * Este valor não pode ser sobrescrito.
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       array $acceptMimes
     *              Array associativo contendo os mimes a serem usados.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setAcceptMimes(array $acceptMimes) : void
    {
        if ($this->isLockProperties === false) {
            if ($this->acceptMimes === null) {
                if (count($acceptMimes) === 0) {
                    $err = "Invalid definition of AcceptMimes. The array must have at last one value.";
                    throw new \InvalidArgumentException($err);
                }


                $v = [];
                $keyMimes = array_keys($this->responseMimeTypes);
                $keyValues = ((array_is_assoc($acceptMimes) === false) ? $acceptMimes : array_keys($acceptMimes));

                foreach ($keyValues as $mime) {
                    if ($mime === null || array_in_ci($mime, $keyMimes) === false) {
                        $err = "Unsuported mime [ \"$mime\" ].";
                        throw new \InvalidArgumentException($err);
                        break;
                    } else {
                        $m = strtolower($mime);
                        $v[$m] = $this->responseMimeTypes[$m];
                    }
                }

                $this->acceptMimes = $v;
            }
        }
    }










    /**
     * Indica sobre se a aplicação deve priorizar o uso do mime ``xhtml``.
     *
     * @var         bool
     */
    private $isUseXHTML = false;
    /**
     * Retorna ``true`` caso aplicação deve priorizar o uso do mime ``xhtml``.
     *
     * @return      bool
     */
    public function getIsUseXHTML() : bool
    {
        return $this->isUseXHTML;
    }
    /**
     * Retorna se a aplicação deve priorizar o uso do mime ``xhtml``.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       bool $isUseXHTML
     *              Indica se deve ser usado o mime ``xhtml``.
     *
     * @return      void
     */
    public function setIsUseXHTML(bool $isUseXHTML) : void
    {
        if ($this->isLockProperties === false) {
            $this->isUseXHTML = $isUseXHTML;
        }
    }










    /**
     * Coleção de middlewares que devem ser acionados ao longo do processamento desta rota.
     *
     * @var         array
     */
    private $middlewares = [];
    /**
     * Retorna a coleção de nomes de Middlewares que devem ser executados durante o
     * processamento da rota alvo.
     *
     * @return      array
     */
    public function getMiddlewares() : array
    {
        return $this->middlewares;
    }
    /**
     * Define uma coleção de Middlewares que devem ser executados durante o processamento da
     * rota alvo.
     * Cada entrada refere-se a um método existente na classe da aplicação que retorna uma
     * instância do Middleware alvo.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
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
    public function setMiddlewares(array $middlewares) : void
    {
        if ($this->isLockProperties === false) {
            foreach ($middlewares as $i => $r) {
                if (is_string($r) === false || $r === "") {
                    $err = "Invalid Middleware definition. Empty strings are not valid.";
                    throw new \InvalidArgumentException($err);
                }
            }
            $this->middlewares = $middlewares;
        }
    }
    /**
     * Adiciona novos itens ao final da lista de middlewares a serem executados.
     * Cada entrada refere-se a um método existente na classe da aplicação que retorna uma
     * instância do Middleware alvo.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       array $middlewares
     *              Array de strings onde cada uma corresponde a um método que retorna o
     *              respectivo middleware.
     *
     * @return      void
     */
    public function addMiddlewares(array $middlewares) : void
    {
        if ($this->isLockProperties === false) {
            $this->setMiddlewares(array_merge($this->middlewares, $middlewares));
        }
    }











    /**
     * Coleção de rotas que tem relação com esta.
     *
     * @var         array
     */
    private $relationedRoutes = null;
    /**
     * Retorna uma coleção de rotas e/ou URLs que tem relação com esta.
     *
     * @return      ?array
     */
    public function getRelationedRoutes() : ?array
    {
        return $this->relationedRoutes;
    }
    /**
     * Define uma coleção de rotas e/ou URLs que tem relação com esta.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       ?array $relationedRoutes
     *              Coleção de rotas.
     *
     * @return      void
     */
    public function setRelationedRoutes(?array $relationedRoutes) : void
    {
        if ($this->isLockProperties === false) {
            $relationedRoutes = (
                ($relationedRoutes === null || count($relationedRoutes) === 0) ? null : $relationedRoutes
            );
            $nrroutes = null;

            if ($relationedRoutes !== null) {
                $nrroutes = [];
                foreach ($relationedRoutes as $i => $r) {
                    if (is_string($r) === true && $r !== "") {
                        $nrroutes[] = "/" . trim($r, " /");
                    }
                }
            }

            $this->relationedRoutes = $nrroutes;
        }
    }










    /**
     * Descrição sobre a ação executada por esta rota.
     *
     * @var         ?string
     */
    private $description = null;
    /**
     * Retorna uma descrição sobre a ação executada por esta rota.
     *
     * @return      ?string
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }
    /**
     * Define uma descrição sobre a ação executada por esta rota.
     * Esta descrição deve ter um teor mais abrangente e não técnico.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       ?string $description
     *              Descrição para a rota.
     *
     * @return      void
     */
    public function setDescription(?string $description) : void
    {
        if ($this->isLockProperties === false) {
            $this->description = (($description === "") ? null : $description);
        }
    }










    /**
     * Descrição da rota com detalhes voltado para desenvolvedores.
     *
     * @var         ?string
     */
    private $devDescription = null;
    /**
     * Retorna uma descrição técnica para a rota.
     * O formato MarkDown pode ser utilizado.
     *
     * @return      ?string
     */
    public function getDevDescription() : ?string
    {
        return $this->devDescription;
    }
    /**
     * Define uma descrição técnica para a rota.
     * O formato MarkDown pode ser utilizado.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       ?string $devDescription
     *              Descrição técnica para a rota.
     *
     * @return      void
     */
    public function setDevDescription(?string $devDescription) : void
    {
        if ($this->isLockProperties === false) {
            $this->devDescription = (($devDescription === "") ? null : $devDescription);
        }
    }










    /**
     * Indica sobre se a rota é protegida pelo sistema de segurança do domínio.
     *
     * @var         bool
     */
    private $isSecure = false;
    /**
     * Retorna ``true`` se a rota é protegida pelo sistema de segurança do aplicação.
     *
     * @return      bool
     */
    public function getIsSecure() : bool
    {
        return $this->isSecure;
    }
    /**
     * Define se a a rota deve ser protegida pelo sistema de segurança da aplicação.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * Uma rota definida como segura terá seu sistema de cache desabilitado
     * para toda rota protegida.
     *
     * @param       bool $isSecure
     *              Use "true" para proteger a rota.
     *
     * @return      void
     */
    public function setIsSecure(bool $isSecure) : void
    {
        if ($this->isLockProperties === false) {
            $this->isSecure = $isSecure;
        }
    }










    /**
     * Indica sobre se a rota possui um conteúdo cacheável.
     *
     * @var         bool
     */
    private $isUseCache = false;
    /**
     * Retorna ``true`` se a rota possui um conteúdo cacheável.
     *
     * Uma rota definida como segura terá seu sistema de cache desabilitado para toda rota protegida.
     *
     * @return      bool
     */
    public function getIsUseCache() : bool
    {
        return ($this->isUseCache === true && $this->cacheTimeout > 0 && $this->isSecure === false);
    }
    /**
     * Define se a rota possui um conteúdo cacheável.
     *
     * Esta característica só é válida para respostas obtidas com os métodos HTTP ``HEAD`` e ``GET``.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       bool $isUseCache
     *              Use ``true`` para definir que a rota deve ser cacheada.
     *
     * @return      void
     */
    public function setIsUseCache(bool $isUseCache) : void
    {
        if ($this->isLockProperties === false) {
            $this->isUseCache = $isUseCache;
        }
    }





    /**
     * Indica o tempo (em segundos) pelo qual o documento de cache deve ser armazenado até expirar.
     *
     * @var         int
     */
    private $cacheTimeout = 0;
    /**
     * Retorna o tempo (em segundos) pelo qual o documento em cache deve ser armazenado até
     * expirar.
     *
     * @return      int
     */
    public function getCacheTimeout() : int
    {
        return $this->cacheTimeout;
    }
    /**
     * Define o tempo (em segundos) pelo qual o documento em cache deve ser armazenado até
     * expirar.
     *
     * Um valor menor ou igual a ``0`` indica que o armazenamento não deve ser feito (tal qual
     * se o sistema de cache estivesse desativado).
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       int $cacheTimeout
     *              Tempo (em segundos) para o timeout do documento em cache.
     *
     * @return      void
     */
    public function setCacheTimeout(int $cacheTimeout) : void
    {
        if ($this->isLockProperties === false) {
            $this->cacheTimeout = (($cacheTimeout < 0) ? 0 : $cacheTimeout);
        }
    }















    /**
     * Coleção de headers a serem enviados para o ``UA``.
     *
     * @var         array
     */
    private $responseHeaders = [];
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
     * Pode ser redefinido durante o processamento da rota.
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
            if (is_string($k) === true && $k !== "" && array_in_ci($k, array_keys($headers)) === false) {
                $headers[$k] = (string)$v;
            }
        }

        $this->responseHeaders = $headers;
    }
    /**
     * Adiciona novos itens na coleção de headers.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       array $responseHeaders
     *              Array associativo [key => value] contendo a coleção de headers a serem
     *              enviados ao ``UA``.
     *
     * @return      void
     */
    public function addResponseHeaders(array $responseHeaders) : void
    {
        $this->setResponseHeaders(array_merge($this->responseHeaders, $responseHeaders));
    }





    /**
     * Mime (extenção) a ser usado para resolver esta rota.
     *
     * @var         ?string
     */
    private $responseMime = null;
    /**
     * Retorna o Mime (extenção) a ser usado para resolver esta rota.
     *
     * @return      ?string
     */
    public function getResponseMime() : ?string
    {
        return $this->responseMime;
    }
    /**
     * Define o Mime (extenção) a ser usado para resolver esta rota.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       ?string $mime
     *              Mime (extenção) que será usado.
     *
     * @return      void
     */
    public function setResponseMime(?string $mime) : void
    {
        if ($this->isLockProperties === false) {
            $this->responseMime = (($mime === "") ? null : $mime);
        }
    }





    /**
     * MimeType (canônico) a ser usado para resolver esta rota.
     *
     * @var         ?string
     */
    private $responseMimeType = null;
    /**
     * Retorna o MimeType (canônico) a ser usado para resolver esta rota.
     *
     * @return      ?string
     */
    public function getResponseMimeType() : ?string
    {
        return $this->responseMimeType;
    }
    /**
     * Define o MimeType (canônico) a ser usado para resolver esta rota.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       ?string $mimeType
     *              MimeType (canônico) que será usado.
     *
     * @return      void
     */
    public function setResponseMimeType(?string $mimeType) : void
    {
        if ($this->isLockProperties === false) {
            $this->responseMimeType = (($mimeType === "") ? null : $mimeType);
        }
    }





    /**
     * Locale a ser usado para resolver esta rota.
     *
     * @var         ?string
     */
    private $responseLocale = null;
    /**
     * Retorna o Locale a ser usado para resolver esta rota.
     *
     * @return      ?string
     */
    public function getResponseLocale() : ?string
    {
        return $this->responseLocale;
    }
    /**
     * Define o Locale a ser usado para resolver esta rota.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       ?string $locale
     *              Locale que será usado.
     *
     * @return      void
     */
    public function setResponseLocale(?string $locale) : void
    {
        if ($this->isLockProperties === false) {
            $this->responseLocale = (($locale === "") ? null : $locale);
        }
    }





    /**
     * Indica quando o código de retorno deve ser tratado para facilitar a leitura por humanos.
     *
     * @var         bool
     */
    private $responseIsPrettyPrint = false;
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
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       bool $isPrettyPrint
     *              Indica se o código deve ser tratado ou não.
     *
     * @return      void
     */
    public function setResponseIsPrettyPrint(bool $isPrettyPrint) : void
    {
        if ($this->isLockProperties === false) {
            $this->responseIsPrettyPrint = $isPrettyPrint;
        }
    }





    /**
     * Indica se o resultado da execução da rota deve ser um download.
     *
     * @var         bool
     */
    private $responseIsDownload = false;
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
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       bool $isDownload
     *              Use ``true`` para definir que o resultado a ser submetido ao UA é um download.
     *
     * @return      void
     */
    public function setResponseIsDownload(bool $isDownload) : void
    {
        if ($this->isLockProperties === false) {
            $this->responseIsDownload = $isDownload;
        }
    }





    /**
     * Nome do documento enviado por download.
     *
     * @var         ?string
     */
    private $responseDownloadFileName = null;
    /**
     * Retorna o nome do documento que deve ser devolvido ao efetuar o download da rota.
     * Se nenhum nome for definido de forma explicita, este valor será criado a partir do nome da
     * rota principal.
     *
     * @return      ?string
     */
    public function getResponseDownloadFileName() : ?string
    {
        return $this->responseDownloadFileName;
    }
    /**
     * Define o nome do documento que deve ser devolvido ao efetuar o download da rota.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       ?string $downloadFileName
     *              Nome do arquivo que será enviado ao UA como um download.
     *
     * @return      void
     */
    public function setResponseDownloadFileName(?string $downloadFileName) : void
    {
        $this->responseDownloadFileName = (($downloadFileName === "") ? null : $downloadFileName);
    }










    /**
     * Caminho relativo (a partir de ``appRootPath``) até a master page que será utilizada.
     *
     * @var         ?string
     */
    private $masterPage = null;
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até a master page que será
     * utilizada.
     *
     * @return      ?string
     */
    public function getMasterPage() : ?string
    {
        return $this->masterPage;
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até a master page que será
     * utilizada.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       ?string $masterPage
     *              Caminho relativo até a master page.
     *
     * @return      void
     */
    public function setMasterPage(?string $masterPage) : void
    {
        $this->masterPage = (($masterPage === "") ? null : $masterPage);
    }





    /**
     * Caminho relativo (a partir do diretório definido para as views) até a view que será utilizada.
     *
     * @var         ?string
     */
    private $view = null;
    /**
     * Retorna o caminho relativo (a partir do diretório definido para as views) até a view
     * que será utilizada.
     *
     * @return      ?string
     */
    public function getView() : ?string
    {
        return $this->view;
    }
    /**
     * Define o caminho relativo (a partir do diretório definido para as views) até a view
     * que será utilizada.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       ?string $view
     *              Caminho relativo até a view.
     *
     * @return      void
     */
    public function setView(?string $view) : void
    {
        $this->view = (($view === "") ? null : $view);
    }





    /**
     * Caminho relativo até um arquivo de formulário que esteja sendo utilizado pela rota.
     *
     * @var         ?string
     */
    private $form = null;
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até um arquivo de formulário
     * que esteja sendo utilizado pela rota.
     *
     * @return      ?string
     */
    public function getForm() : ?string
    {
        return $this->form;
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até um arquivo de formulário
     * que esteja sendo utilizado pela rota.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       ?string $form
     *              Caminho relativo até o arquivo que define o formulário alvo.
     *
     * @return      void
     */
    public function setForm(?string $form) : void
    {
        if ($this->isLockProperties === false) {
            $this->form = (($form === "") ? null : $form);
        }
    }




    /**
     * Coleção de folhas de estilo que devem ser vinculados na view.
     *
     * @var         array
     */
    private $styleSheets = [];
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
     * Define uma coleção de caminhos até as folhas de estilos que devem ser incorporadas no
     * documento final (caso trate-se de um formato que aceita este tipo de recurso.)
     *
     * Os caminhos dos CSSs devem ser relativos e iniciando a partir do diretório destinado
     * aos recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
     *
     * Pode ser redefinido durante o processamento da rota.
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
            if (is_string($s) !== false && $s !== "") {
                $styles[] = $s;
            }
        }

        $this->styleSheets = $styles;
    }
    /**
     * Adiciona novas folhas de estilo na coleção existente.
     *
     * Os caminhos dos CSSs devem ser relativos e iniciando a partir do diretório destinado aos
     * recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       array $styleSheets
     *              Coleção de folhas de estilo a serem adicionadas na lista atual.
     *
     * @return      void
     */
    public function addStyleSheets(array $styleSheets) : void
    {
        $this->setStyleSheets(array_merge($this->styleSheets, $styleSheets));
    }





    /**
     * Coleção de scripts que devem ser vinculados na view.
     *
     * @var         array
     */
    private $javaScripts = [];
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
     * Define uma coleção de caminhos até as scripts que devem ser incorporadas no documento
     * final (caso trate-se de um formato que aceita este tipo de recurso.)
     *
     * Os caminhos dos scripts devem ser relativos e iniciando a partir do diretório destinado aos
     * recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
     *
     * Pode ser redefinido durante o processamento da rota.
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
            if (is_string($s) !== false && $s !== "") {
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
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       array $javaScripts
     *              Coleção de scripts a serem adicionadas na lista atual.
     *
     * @return      void
     */
    public function addJavaScripts(array $javaScripts) : void
    {
        $this->setJavaScripts(array_merge($this->javaScripts, $javaScripts));
    }





    /**
     * Caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
     * que será usado para responder a requisição.
     *
     * @var         ?string
     */
    private $localeDictionary = null;
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
     * que será usado para responder a requisição.
     *
     * @return      ?string
     */
    public function getLocaleDictionary() : ?string
    {
        return $this->localeDictionary;
    }
    /*
     * Define o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do
     * locale que será usado para responder a requisição.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       ?string $localeDictionary
     *              Caminho relativo até o arquivo de legendas.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setLocaleDictionary(?string $localeDictionary) : void
    {
        $this->localeDictionary = (($localeDictionary === "") ? null : $localeDictionary);
    }





    /**
     * Coleção de metadados a serem incorporados na view X/HTML.
     *
     * @var         array
     */
    private $metaData = [];
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
     * Define uma coleção de metadados a serem incorporados nas views ``X/HTML``.
     * As chaves de valores informadas devem ser tratadas em ``case-insensitive``.
     *
     * Pode ser redefinido durante o processamento da rota.
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
            if (is_string($k) === true && $k !== "" && array_in_ci($k, array_keys($meta)) === false) {
                $meta[$k] = (string)$v;
            }
        }

        $this->metaData = $meta;
    }
    /**
     * Adiciona novos itens na coleção existente.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       array $metaData
     *              Array associativo [key => value] contendo a coleção de itens a serem adicionados
     *              na tag <head> em formato <meta name="key" content="value" />
     *
     * @return      void
     */
    public function addMetaData(array $metaData) : void
    {
        $this->setMetaData(array_merge($this->metaData, $metaData));
    }





    /**
     * Nome do método a ser executado para resolver o processamento
     * da rota.
     *
     * @var         string
     */
    private $runMethodName = "run";
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
     * Permite definir o nome de um metodo alternativo para resolver o resultado do processamento
     * da rota.
     *
     * @param       string $runMethodName
     *              Nome do método a ser executado.
     *
     * @return      void
     */
    public function setRunMethodName(string $runMethodName) : void
    {
        $this->runMethodName = $runMethodName;
    }





    /**
     * Coleção de propriedades customizadas da rota.
     *
     * @var         ?array
     */
    private $customProperties = null;
    /**
     * Resgata um array associativo contendo propriedades customizadas para o processamento
     * da rota.
     *
     * @return      ?array
     */
    public function getCustomProperties() : ?array
    {
        return $this->customProperties;
    }
    /**
     * Define uma coleção de propriedades customizadas para o processamento da rota.
     *
     * @param       ?array $customProperties
     *              Array associativo contendo as informações customizadas.
     *
     * @return      void
     */
    public function setCustomProperties(?array $customProperties) : void
    {
        if ($this->isLockProperties === false) {
            $this->customProperties = $customProperties;
        }
    }










    /**
     * Inicia uma instância de configuração para a rota.
     *
     * @param       string|array $cfg
     *              Array associativo contendo as propriedades e respectivos valores a serem
     *              definidos para a rota atual.
     *              Também pode ser usado uma string estruturada de forma a receber os valores
     *              mínimos a serem usados para as definições de uma rota.
     *
     */
    function __construct($cfg = null)
    {
        if ($cfg !== null) {
            $this->setValues($cfg);
        }
    }










    /**
     * Armazena o locale que deve ser usado frente as configurações definidas para a rota.
     *
     * @var         ?string
     */
    private $useLocale = null;
    /**
     * Processa a negociação de conteúdo para identificar qual locale deve ser usado para
     * responder a esta rota.
     *
     * @param       ?array $requestLocales
     *              Coleção de Locales que o UA explicitou preferência.
     *
     * @param       ?array $requestLanguages
     *              Coleção de linguagens em que o UA explicitou preferência.
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
     * @return      ?string
     */
    public function negotiateLocale(
        ?array $requestLocales,
        ?array $requestLanguages,
        ?array $applicationLocales,
        ?string $defaultLocale,
        ?string $forceLocale
    ) : ?string
    {
        $useLocale = null;

        if ($this->useLocale === null) {
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
                    if (array_in_ci($headerLocale, $applicationLocales) === true) {
                        $useLocale = $headerLocale;
                        break;
                    }
                }


                // Se nenhum dos locales servidos pela aplicação corresponde
                // a algum que o UA queira, verifica se há linguas compatíveis
                if ($useLocale === null) {
                    // Linguagens que o UA passou como sendo aquelas que ele prefere.
                    if ($requestLanguages === null) { $requestLanguages = []; }

                    $appLanguages = [];
                    $appLan = [];
                    foreach ($requestLanguages as $i => $headerLanguage) {
                        if ($i === 0) {
                            foreach ($applicationLocales as $appLocale) {
                                $appLanguages[$appLocale] = substr($appLocale, 0, 2);
                            }
                            $appLan = array_values($appLanguages);
                        }

                        if (array_in_ci($headerLanguage, $appLan) === true) {
                            $useLocale = array_search($headerLanguage, $appLanguages);
                            break;
                        }
                    }
                }


                // Se nenhum locale foi identificado
                // usa o padrão
                if ($useLocale === null) { $useLocale = $defaultLocale; }
            }

            $this->useLocale = strtolower($useLocale);
        }

        return $this->useLocale;
    }





    /**
     * Armazena uma coleção de valores referentes ao mimetype que deve ser usado para responder
     * à requisição do UA.
     *
     * @var         ?array
     */
    private $useMimes = null;
    /**
     * Processa a negociação de conteúdo para identificar qual mimetype deve ser usado para
     * responder a esta rota.
     *
     * @param       ?array $requestMimes
     *              Coleção de mimeTypes que o UA explicitou preferência.
     *
     * @param       ?string $forceMime
     *              Mime que terá prioridade sobre os demais podendo inclusive ser um que a rota
     *              não esteja apta a utilizar.
     *
     * @return      ?array
     * ``` php
     *  $arr = [
     *      "valid"     bool    Indica se o mimetype encontrado é válido para ser usado em um response
     *      "mime"      string  Extenção que identifica o tipo de documento referente ao mimetype selecionado.
     *      "mimetype"  string  Nome canonico do mimetype selecionado.
     *  ];
     * ```
     */
    public function negotiateMimeType(
        ?array $requestMimes,
        ?string $forceMime
    ) : ?array {

        if ($this->useMimes === null) {
            $r = null;

            $useAny             = false;
            $useMime            = null;
            $useMimeType        = null;
            $routeAcceptMimes   = $this->getAcceptMimes();
            $isUseXhtml         = $this->getIsUseXHTML();
            $validMimeSelection = false;


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
                    if (isset($routeAcceptMimes[$rMime]) === true) {
                        $useMime = $rMime;
                        break;
                    }
                }
            }


            // Se não encontrou um mime compatível mas entre as regras
            // do UA é permitido usar qualquer um, seleciona o primeiro
            // que a rota disponibiliza
            if ($useMime === null && $useAny === true) {
                $useMime = key($routeAcceptMimes);
            }


            // Sendo para retornar um documento "html" e
            // a aplicação estando configurada para forçar uma
            // saida "xhtml", identifica esta situação e força-a.
            $forceValidXHTML = false;
            if ($useMime === "html" && $isUseXhtml === true) {
                $useMime = "xhtml";
                $forceValidXHTML = true;
            }


            // Tendo encontrado algum mime para ser usado,
            // preenche o mimetype
            if ($useMime !== null) {
                $useMimeType = (isset($this->responseMimeTypes[$useMime]) === true) ? $this->responseMimeTypes[$useMime] : null;
            }


            // Encontrando a extenção e o mimetype a serem usados.
            $this->useMimes = [
                "valid"     => (isset($routeAcceptMimes[$useMime]) === true || $forceValidXHTML === true),
                "mime"      => $useMime,
                "mimetype"  => $useMimeType
            ];
        }

        return $this->useMimes;
    }





    /**
     * Permite definir os valores para a configuração da rota.
     *
     * @param       string|array $cfg
     *              Array associativo contendo as propriedades e respectivos valores a serem
     *              definidos para a rota atual.
     *              Também pode ser usado uma string estruturada de forma a receber os valores
     *              mínimos a serem usados para as definições de uma rota.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setValues($cfg) : void
    {
        if ((is_string($cfg) === false && is_array($cfg) === false) || $cfg === null || $cfg === "") {
            $err = "Invalid configuration value. Expected a not empty string or array.";
            throw new \InvalidArgumentException($err);
        }



        if (is_string($cfg) === true) {
            // Se a regra das configurações é descrita em uma única string,
            // admite que pode haver entre 2 e 5 partes (separadas por um espaço) onde:
            //
            // Se houver 2 partes
            // [0] Rota
            // [1] Action (nome da função que será executada)
            //
            // Se houver 3 ou mais partes
            // [0] Método
            // [1] Rota
            // [2] Action (nome da função que será executada)
            // [3] Security
            //     "b", "block" :   explicitamente bloqueia a rota para usuários não identificados.
            //     "f", "free"  :   explicitamente libera a rota para qualquer usuário.
            //     "-"          :   mantém a política padrão para rotas da aplicação corrente.
            // [4] Cache
            //     "cache-int"  :   Indica que esta rota deve ter seu resultado cacheado.
            //                      o valor de "int" é um número inteiro que representa o tempo
            //                      total de validade de um documento cacheado.
            //     "no-cache"   :   Explicitamente nega à esta rota que ela possa ser cacheada.
            //

            $parts = explode(" ", $cfg);

            if (count($parts) === 1) {
                $msg = "Route configuration fail. Check documentation [ \"$cfg\" ].";
                throw new \InvalidArgumentException($msg);
            } else {
                $cfg = null;

                if (count($parts) === 2) {
                    $cfg["Method"] = "GET";
                    $cfg["Routes"] = [$parts[0]];
                    $cfg["Action"] = $parts[1];
                } else {
                    $cfg["Method"] = $parts[0];
                    $cfg["Routes"] = [$parts[1]];
                    $cfg["Action"] = $parts[2];

                    // Identifica configuração de segurança para a rota.
                    if (count($parts) >= 4) {
                        switch ($parts[3]) {
                            case "b":
                            case "block":
                            case "blockRoute":
                            case "private":
                            case "privateRoute":
                                $cfg["IsSecure"] = true;
                                break;

                            case "f":
                            case "free":
                            case "freeRoute":
                            case "public":
                            case "publicRoute":
                                $cfg["IsSecure"] = false;
                                break;
                        }
                    }

                    // Identifica configuração para o sistema de cache
                    if (count($parts) > 4) {
                        if ($parts[4] === "no-cache") {
                            $cfg["IsUseCache"] = false;
                            $cfg["CacheTimeout"] = 0;
                        } else {
                            $cacheTimeout = explode("-", $parts[4]);
                            if (count($cacheTimeout) !== 2 || is_numeric($cacheTimeout[1]) === false) {
                                $err = "Route configuration fail. Expected integer cache timeout. Check documentation.";
                                throw new \InvalidArgumentException($err);
                            } else {
                                $cfg["IsUseCache"] = true;
                                $cfg["CacheTimeout"] = (int)$cacheTimeout[1];
                            }
                        }
                    }
                }
            }
        }



        foreach ($cfg as $key => $value) {
            $k = strtolower($key);


            switch ($k) {
                case "application":
                    $this->setApplication($value);
                    break;

                case "namespace":
                    $this->setNamespace($value);
                    break;

                case "controller":
                    $this->setController($value);
                    break;

                case "action":
                    $this->setAction($value);
                    break;

                case "method":
                    $this->setMethod($value);
                    break;

                case "allowedmethods":
                    $this->setAllowedMethods($value);
                    break;

                case "routes":
                    $this->setRoutes($value);
                    break;

                case "acceptmimes":
                    $this->setAcceptMimes($value);
                    break;

                case "isusexhtml":
                    $this->setIsUseXHTML($value);
                    break;

                case "middlewares":
                    $this->setMiddlewares($value);
                    break;

                case "relationedroutes":
                    $this->setRelationedRoutes($value);
                    break;

                case "description":
                    $this->setDescription($value);
                    break;

                case "devdescription":
                    $this->setDevDescription($value);
                    break;

                case "issecure":
                    $this->setIsSecure($value);
                    break;

                case "isusecache":
                    $this->setIsUseCache($value);
                    break;

                case "cachetimeout":
                    $this->setCacheTimeout($value);
                    break;

                case "responseheaders":
                    $this->setResponseHeaders($value);
                    break;

                case "responsemime":
                    $this->setResponseMime($value);
                    break;

                case "responsemimetype":
                    $this->setResponseMimeType($value);
                    break;

                case "responselocale":
                    $this->setResponseLocale($value);
                    break;

                case "responseisprettyprint":
                    $this->setResponseIsPrettyPrint($value);
                    break;

                case "responseisdownload":
                    $this->setResponseIsDownload($value);
                    break;

                case "responsedownloadfilename":
                    $this->setResponseDownloadFileName($value);
                    break;

                case "masterpage":
                    $this->setMasterPage($value);
                    break;

                case "view":
                    $this->setView($value);
                    break;

                case "form":
                    $this->setForm($value);
                    break;

                case "stylesheets":
                    $this->setStyleSheets($value);
                    break;

                case "javascripts":
                    $this->setJavaScripts($value);
                    break;

                case "localedictionary":
                    $this->setLocaleDictionary($value);
                    break;

                case "metadata":
                    $this->setMetaData($value);
                    break;

                case "runmethodname":
                    $this->setRunMethodName($value);
                    break;

                case "customproperties":
                    $this->setCustomProperties($value);
                    break;

                default:
                    $err = "Invalid propertie. [ \"$key\" ].";
                    throw new \InvalidArgumentException($err);
            }
        }
    }





    /**
     * Converte as propriedades definidas neste objeto para um array associativo e retorna-o.
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
            "method"                    => $this->getMethod(),

            "allowedMethods"            => $this->getAllowedMethods(),
            "routes"                    => $this->getRoutes(),
            "acceptMimes"               => $this->getAcceptMimes(),
            "isUseXHTML"                => $this->getIsUseXHTML(),
            "middlewares"               => $this->getMiddlewares(),

            "relationedRoutes"          => $this->getRelationedRoutes(),
            "description"               => $this->getDescription(),
            "devDescription"            => $this->getDevDescription(),
            "isSecure"                  => $this->getIsSecure(),
            "isUseCache"                => $this->getIsUseCache(),

            "cacheTimeout"              => $this->getCacheTimeout(),
            "responseHeaders"           => $this->getResponseHeaders(),
            "responseMime"              => $this->getResponseMime(),
            "responseMimeType"          => $this->getResponseMimeType(),
            "responseLocale"            => $this->getResponseLocale(),

            "responseIsPrettyPrint"     => $this->getResponseIsPrettyPrint(),
            "responseIsDownload"        => $this->getResponseIsDownload(),
            "responseDownloadFileName"  => $this->getResponseDownloadFileName(),
            "masterPage"                => $this->getMasterPage(),
            "view"                      => $this->getView(),

            "form"                      => $this->getForm(),
            "styleSheets"               => $this->getStyleSheets(),
            "javaScripts"               => $this->getJavaScripts(),
            "localeDictionary"          => $this->getLocaleDictionary(),
            "metaData"                  => $this->getMetaData(),

            "runMethodName"             => $this->getRunMethodName(),
            "customProperties"          => $this->getCustomProperties()
        ];
    }




    /**
     * Retorna um array associativo contendo as propriedades que atuam diretamente na
     * configuração da construção da view.
     *
     * @return      array
     */
    public function getActionAttributes() : array
    {
        return [
            "responseHeaders"           => $this->responseHeaders,
            "responseMime"              => $this->responseMime,
            "responseMimeType"          => $this->responseMimeType,
            "responseLocale"            => $this->responseLocale,
            "responseIsPrettyPrint"     => $this->responseIsPrettyPrint,
            "responseIsDownload"        => $this->responseIsDownload,
            "responseDownloadFileName"  => $this->responseDownloadFileName,
            "masterPage"                => $this->masterPage,
            "view"                      => $this->view,
            "styleSheets"               => $this->styleSheets,
            "javaScripts"               => $this->javaScripts,
            "localeDictionary"          => $this->localeDictionary,
            "metaData"                  => $this->metaData
        ];
    }





    /**
     * A partir da execução deste método apenas as propriedades que podem ser alteradas
     * **DURANTE** a action é que poderão ser alteradas.
     *
     * Na implementação da classe não deve existir forma de retornar este estado. Ou seja, uma
     * vez que o bloqueio seja ativado nada pode removê-lo.
     *
     * @return      void
     */
    public function lockProperties() : void
    {
        $this->isLockProperties = true;
    }










    /**
     * Desabilita a função mágica "__set".
     *
     * @codeCoverageIgnore
     */
    public function __set($name, $value)
    {
        // Não produz efeito
    }
}
