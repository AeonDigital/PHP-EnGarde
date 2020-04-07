<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Http;

use AeonDigital\EnGarde\Interfaces\Http\iRouter as iRouter;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;







/**
 * Roteador para as requisições ``HTTP`` de uma Aplicação.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Router implements iRouter
{





    /**
     * Nome da aplicação onde as rotas estão sendo verificadas
     *
     * @var         string
     */
    private $applicationName = null;
    /**
     * Caminho relativo para o arquivo de rotas da aplicação.
     *
     * @var         string
     */
    private $pathToAppRoutes = null;
    /**
     * Caminho relativo até o diretório de controllers da aplicação
     *
     * @var         string
     */
    private $pathToControllers = null;
    /**
     * Namespaces usadas pelos controllers da aplicação.
     *
     * @var         string
     */
    private $controllersNamespace = null;
    /**
     * Preenchido com a execução do método ``selectTargetRawRoute``, trará um array associativo
     * contendo os parametros identificados na ``URL`` passada.
     *
     * @var         ?array
     */
    private $selectedRouteParans = null;





    /**
     * Inicia um Roteador.
     *
     * @param       string $applicationName
     *              Nome da aplicação.
     *
     * @param       string $pathToAppRoutes
     *              Caminho relativo até o arquivo de rotas.
     *
     * @param       string $pathToControllers
     *              Caminho relativo até o diretório de controllers.
     *
     * @param       string $controllersNamespace
     *              Namespaces dos controllers da aplicação alvo.
     *
     * @param       array $defaultRouteConfig
     *              Configurações padrões para as rotas da aplicação.
     */
    function __construct(
        string $applicationName,
        string $pathToAppRoutes,
        string $pathToControllers,
        string $controllersNamespace,
        array $defaultRouteConfig = []
    ) {
        $this->applicationName      = $applicationName;
        $this->pathToAppRoutes      = $pathToAppRoutes;
        $this->pathToControllers    = $pathToControllers;
        $this->controllersNamespace = $controllersNamespace;
        $this->defaultRouteConfig   = $defaultRouteConfig;
    }





    /**
     * Array associativo contendo os valores padrões para as rotas de toda a aplicação.
     *
     * @var         array
     */
    private $defaultRouteConfig = [];
    /**
     * Define o valores padrões para as configurações de rotas de uma aplicação.
     *
     * @param       array $defaultRouteConfig
     *              Configurações padrões para as rotas da aplicação.
     *
     * @return      void
     */
    public function setDefaultRouteConfig(array $defaultRouteConfig) : void
    {
        $this->defaultRouteConfig = $defaultRouteConfig;
    }






    /**
     * Indica se o roteador pode executar a atualização do arquivo de rotas.
     *
     * @var         string
     */
    private $isUpdateRoutes = false;
    /**
     * Indica se é permitido efetuar a atualização do arquivo de rotas da aplicação.
     *
     * @param       bool $isUpdateRoutes
     *              Quando ``true`` irá permitir a atualização do arquivo de rotas.
     *
     * @return      void
     */
    public function setIsUpdateRoutes(bool $isUpdateRoutes) : void
    {
        $this->isUpdateRoutes = $isUpdateRoutes;
    }





    /**
     * Quando executado este método irá excluir o atual arquivo de configuração de rotas da
     * aplicação, forçando assim que ele seja refeito.
     *
     * @return      void
     */
    public function forceUpdateRoutes() : void
    {
        if (file_exists($this->pathToAppRoutes) === true) {
            unlink($this->pathToAppRoutes);
        }
    }





    /**
     * Retornará ``true`` quando for identificado que é para redefinir o arquivo de configuração
     * de rotas da aplicação.
     *
     * Apenas retornará ``true`` quando:
     * - for  definido ``true`` em ``setIsUpdateRoutes``.
     * - há algum arquivo ``controller`` com data de alteração posterior a data de criação do
     *   arquivo de configuração de rotas da aplicação.
     *
     * Também retornará ``true`` quando não existir um arquivo de rotas no local indicado.
     *
     * @return      bool
     */
    public function checkForUpdateApplicationRoutes() : bool
    {
        $r = false;
        $appRoutes          = $this->pathToAppRoutes;
        $controllersPath    = $this->pathToControllers;


        if (file_exists($appRoutes) === false) {
            $r = true;
        } else {
            if ($this->isUpdateRoutes === true) {
                $appRoutesFileLastMod = filemtime($appRoutes);
                $controllersLastMod = 0;

                // Verifica os arquivos da pasta de controller
                $controllersFiles = scandir($controllersPath);
                foreach ($controllersFiles as $key => $fileName) {
                    if (in_array($fileName, [".", ".."]) === false && is_dir($fileName) === false && mb_str_ends_with($fileName, ".php") === true) {
                        $fileMod = filemtime($controllersPath . DS . $fileName);

                        // Mantém o maior valor
                        $controllersLastMod = ($fileMod > $controllersLastMod) ? $fileMod : $controllersLastMod;
                    }
                }

                if ($controllersLastMod > $appRoutesFileLastMod) {
                    $r = true;
                }
            }
        }


        return $r;
    }










    /**
     * Aloca o novo valor para o documento ``AppRouter``.
     *
     * @var     array
     */
    private $appRoutes = null;
    /**
     * Varre os arquivos de ``controllers`` da aplicação e remonta o arquivo de configuração de
     * rotas do mesmo.
     *
     * Este método apenas pode ser executado quando o resultado de
     * ``checkForUpdateApplicationRoutes`` for ``true``.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso algum parametro interno esteja com um valor inválido.
     *
     * @throws      \RuntimeException
     *              Caso algum erro ocorra no processo.
     */
    public function updateApplicationRoutes() : void
    {
        if ($this->checkForUpdateApplicationRoutes() === true) {
            $this->appRoutes = [];

            // Verifica os arquivos da pasta de controller
            $controllersFiles = scandir($this->pathToControllers);
            foreach ($controllersFiles as $key => $fileName) {
                if (in_array($fileName, [".", ".."]) === false && is_dir($fileName) === false && mb_str_ends_with($fileName, ".php") === true) {
                    $controllerName = str_replace(".php", "", $fileName);
                    $this->registerControllerRoutes($controllerName);
                }
            }

            file_put_contents($this->pathToAppRoutes, "<?php return " . var_export($this->appRoutes, true) . ";");
        }
    }
    /**
     * Cria uma instância de um objeto que implemente a interface ``iRoute``.
     *
     * @return      iRoute
     */
    private function createRouteConfig() : iRoute
    {
        return new \AeonDigital\EnGarde\Config\Route();
    }
    /**
     * Percorre todas as rotas definidas no controller indicado para efetuar o registro de
     * cada uma delas.
     *
     * @param       string $controllerName
     *              Nome do controller alvo.
     *              Deve ser o mesmo nome da classe em si.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso algum parametro interno esteja com um valor inválido.
     *
     * @throws      \RuntimeException
     *              Caso algum erro ocorra no processo.
     */
    private function registerControllerRoutes(string $controllerName) : void
    {
        $routesConfig = [];
        $appName            = $this->applicationName;
        $controllersNS      = $this->controllersNamespace;
        $appRouteConfig     = $this->defaultRouteConfig;
        $controllerFullName = $controllersNS . "\\" . $controllerName;


        $oCtrlReflection    = new \ReflectionClass($controllerFullName);
        $staticProperties   = $oCtrlReflection->getStaticProperties();

        $ctrlRouteConfig    = $oCtrlReflection->getConstant("defaultRouteConfig");
        $ctrlRouteConfig    = (($ctrlRouteConfig === false) ? [] : $ctrlRouteConfig);
        $envrRouteConfig    = $this->mergeRouteConfigs($appRouteConfig, $ctrlRouteConfig, true);



        // Apenas se houverem propriedades estáticas definidas...
        if (is_array($staticProperties) !== false && count($staticProperties) > 0) {
            foreach ($staticProperties as $propName => $value) {
                // sendo uma propriedade de registro de rotas.
                if (mb_strlen($propName) >= 13 && substr($propName, 0, 13) === "registerRoute") {

                    if (is_string($value) === true) {
                        $rConfig = $this->createRouteConfig();
                        $rConfig->setApplication($appName);
                        $rConfig->setNamespace($controllersNS);
                        $rConfig->setController($controllerName);

                        $rConfig->setValues($value);
                        $rConfig->setValues($envrRouteConfig);

                        $routesConfig[] = $rConfig;
                    } else {
                        $baseRouteConfig = $this->mergeRouteConfigs($envrRouteConfig, $value);
                        $useRouteConfig = [];
                        $allowedMethods = null;

                        if (isset($baseRouteConfig["method"]) === false) {
                            // @codeCoverageIgnoreStart
                            $err = "Invalid Route Register. Method HTTP is not defined.";
                            throw new \RuntimeException($err);
                            // @codeCoverageIgnoreEnd
                        } else {
                            if (is_string($baseRouteConfig["method"]) === true) {
                                $allowedMethods = [$baseRouteConfig["method"]];
                                $useRouteConfig[] = $baseRouteConfig;
                            } else {
                                $allowedMethods = $baseRouteConfig["method"];

                                foreach ($baseRouteConfig["method"] as $method) {
                                    $cloneRouteConfig = array_merge($baseRouteConfig, []);
                                    $cloneRouteConfig["method"] = $method;
                                    $useRouteConfig[] = $cloneRouteConfig;
                                }
                            }
                        }


                        foreach ($useRouteConfig as $rc) {
                            $rConfig = $this->createRouteConfig();
                            $rConfig->setApplication($appName);
                            $rConfig->setNamespace($controllersNS);
                            $rConfig->setController($controllerName);
                            $rConfig->setAllowedMethods($allowedMethods);
                            $rConfig->setValues($rc);

                            $routesConfig[] = $rConfig;
                        }
                    }

                }
            }
        }



        // Apenas se houverem rotas definidas
        if (count($routesConfig) > 0) {

            // Classifica as rotas
            foreach ($routesConfig as $cfg) {
                $method = $cfg->getMethod();
                $routes = $cfg->getRoutes();



                // Os métodos "HEAD", "OPTIONS", "TRACE" e "CONNECT" são
                // automaticamente resolvidos pelo framework e não pelos controllers.
                $invalidMethods = ["HEAD", "OPTIONS", "TRACE", "CONNECT"];
                if (array_in_ci($method, $invalidMethods) === true) {
                    // @codeCoverageIgnoreStart
                    $err = "The Method HTTP \"" . $method . "\" is implemented by the framework and can not be set in route configuration.";
                    throw new \InvalidArgumentException($err);
                    // @codeCoverageIgnoreEnd
                }



                // Para cada rota que executa esta mesma ação
                foreach ($routes as $route) {
                    $regexRoute = $this->normalizeRouteRegEx("/" . $appName . "/" . ltrim($route, "/"));
                    $routeType = ((mb_strpos($regexRoute, "<") === false) ? "simple" : "complex");

                    if (isset($this->appRoutes[$routeType][$regexRoute]) === false) {
                        $this->appRoutes[$routeType][$regexRoute] = [];
                    }

                    // Registra a rota com o método indicado
                    $this->appRoutes[$routeType][$regexRoute][$method] = $cfg->toArray();
                }
            }
        }
    }
    /**
     * Retorna a mescla de 2 arrays contendo as configurações brutas para rotas.
     *
     * @param       array $initialRouteConfig
     *              Configurações iniciais.
     *
     * @param       array $newRouteConfig
     *              Configurações que serão sobrepostas às iniciais.
     *
     * @param       bool $isController
     *              Quando ``true`` não permitirá a mesclagem de todas as propriedades e sim
     *              apenas as permitidas para os controllers.
     *
     * @return      array
     */
    private function mergeRouteConfigs(
        array $initialRouteConfig,
        array $newRouteConfig,
        bool $isController = false
    ) : array {

        $rConfig = $initialRouteConfig;

        if (count($newRouteConfig) > 0) {

            $allowedProperties = null;
            if ($isController === true) {
                // Coleção de propriedades que podem ser definidas pelos controllers
                $allowedProperties = [
                    "acceptmimes",
                    "isusexhtml",
                    "middlewares",
                    "description",
                    "issecure",
                    "isusecache",
                    "cachetimeout",
                    "masterpage",
                    "stylesheets",
                    "javascripts",
                    "metadata",
                    "responseheaders"
                ];
            }


            $mergeArrays = ["middlewares", "stylesheets", "javascripts", "metadata", "responseheaders"];


            foreach ($newRouteConfig as $key => $value) {
                $k = strtolower($key);

                if ($allowedProperties === null || (in_array($k, $allowedProperties) === true && $value !== null)) {
                    $v = $value;

                    if (isset($rConfig[$k]) === true && in_array($k, $mergeArrays) === true) {
                        $v = array_merge($rConfig[$k], $value);
                    }

                    $rConfig[$k] = $v;
                }
            }
        }

        return $rConfig;
    }
    /**
     * Corrige a sintaxe de uma Rota ``HTTP`` transformando-a em uma Regex válida.
     *
     * @param       string $route
     *              Rota contendo parametros nomeados.
     *
     * @example
     *      Passando a Rota  : /backstage/rec:[_a-zA-Z]+/id:[\d]+/
     *      Receberá a regex : /^\/backstage\/(?P<rec>[_a-zA-Z]+)\/(?P<id>[\d]+)/
     *
     * @return      string
     */
    private function normalizeRouteRegEx(string $route) : string
    {
        $str = "";
        if ($route !== "") {
            $route = rtrim($route, "/") . "/";

            $patternNamedKey = "/\/(\w+):([\w\{\}\(\)\[\]\-\_\+\\\]+)/";
            $replaceNamedKey = "/(?P<=\$1=>\$2)";

            $finalRegex = preg_replace($patternNamedKey, $replaceNamedKey, $route);
            $finalRegex = str_replace("/", "\/", $finalRegex);


            while (mb_strpos($finalRegex, "=") !== false) {
                $pos = mb_strpos($finalRegex, "=");
                $finalRegex[$pos] = "\0";
            }

            // Remove bytes nulos e retorna o resultado
            $str = str_replace("\0", "", "/^" . $finalRegex . "/");
        }

        return $str;
    }










    /**
     * Identifica se a rota passada correspondem a alguma rota que tenha sido previamente
     * registrada no ``AppRoutes``.
     * Uma vez identificada a rota alvo, retorna todas suas configurações.
     *
     * Em caso de falha na identificação da rota será retornado ``null``.
     *
     * @param       string $targetRoute
     *              Porção relativa da ``URI`` que está sendo executada.
     *              É necessário constar na rota, como sua primeira parte, o nome da aplicação
     *              que está sendo executada. Não deve constar quaisquer parametros ``querystring``
     *              ou ``fragment``.
     *
     * @return      ?array
     */
    public function selectTargetRawRoute(string $targetRoute) : ?array
    {
        $targetRoute    = "/" . trim($targetRoute, "/") . "/";
        $appRoutes  = include($this->pathToAppRoutes);
        $regexRoute = $this->normalizeRouteRegEx($targetRoute);
        $rawRoute   = null;
        $rawConfig  = null;
        $urlParans  = null;

        $this->selectedRouteParans = null;


        // Se nenhuma rota está definida...
        if (count($appRoutes) !== 0) {
            if ($rawRoute === null && isset($appRoutes["simple"]) === true) {
                // Verifica se há alguma rota com nome exato da atual URL
                foreach ($appRoutes["simple"] as $route => $config) {
                    if ($route === $regexRoute) {
                        $rawRoute   = $route;
                        $rawConfig  = $config;
                        break;
                    }
                }
            }


            // Se ainda não encontrou a rota certa pesquisa entre as rotas complexas
            if ($rawRoute === null && isset($appRoutes["complex"]) === true) {
                $matchRoutes = [];
                $matchIndex = 0;

                // Verifica apenas as rotas que ainda não foram conferidas
                foreach ($appRoutes["complex"] as $route => $config) {
                    // Verifica se a URL atual é compativel com a rota informada.
                    if (preg_match($route, $targetRoute, $urlParans) === 1) {
                        $matchRoutes[] = [
                            "rawRoute"  => $route,
                            "rawConfig" => $config,
                            "parans"    => $urlParans
                        ];
                    }
                }


                // Apenas se realmente encontrou alguma rota válida...
                if (count($matchRoutes) > 0) {

                    // Se encontrou mais de 1 match
                    if (count($matchRoutes) > 1) {
                        $countParts = 0;

                        // Verifica qual rota fechou mais partes
                        // significando assim que ela adequa-se mais idealmente ao
                        // definido.
                        foreach ($matchRoutes as $k => $matchs) {
                            $parts = substr_count($matchs["rawRoute"], "/");

                            if ($parts > $countParts) {
                                $matchIndex = $k;
                                $countParts = $parts;
                            }
                        }
                    }


                    // Recolhe as informações definidas
                    $rawRoute   = $matchRoutes[$matchIndex]["rawRoute"];
                    $rawConfig  = $matchRoutes[$matchIndex]["rawConfig"];
                    $urlParans  = $matchRoutes[$matchIndex]["parans"];


                    // Remove as chaves numéricas do array de parametros resultante
                    foreach ($urlParans as $key => $value) {
                        if ($key === 0 || intval($key)) {
                            unset($urlParans[$key]);
                        }
                    }


                    if (count($urlParans) > 0) {
                        $this->selectedRouteParans = $urlParans;
                    }
                }
            }



            // Se nenhuma rota for identificada como compatível.
            if ($rawRoute === null) {
                $rawConfig = null;
            }
        }


        return $rawConfig;
    }





    /**
     * Retorna a coleção de parametros identificados na ``URL`` passada por último no método
     * ``selectTargetRawRoute``.
     *
     * @return      ?array
     */
    public function getSelectedRouteParans() : ?array
    {
        return $this->selectedRouteParans;
    }
}
