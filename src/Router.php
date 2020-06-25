<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Engine;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Engine\iRouter as iRouter;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServer;





/**
 * Roteador para as requisições ``HTTP`` de uma Aplicação.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
class Router extends BObject implements iRouter
{





    /**
     * Configurações do servidor.
     *
     * @var         iServer
     */
    protected iServer $serverConfig;






    /**
     * Inicia um Roteador.
     *
     * @param       iServer $serverConfig
     *              Objeto de configuração do servidor.
     */
    function __construct(iServer $serverConfig)
    {
        $this->serverConfig = $serverConfig;
    }










    /**
     * Deve verificar quando a aplicação possui alterações que envolvam a necessidade de efetuar
     * uma atualização nos dados das rotas.
     *
     * Idealmente verificará se os controllers da aplicação possuem alguma alteração posterior
     * a data do último processamento, e, estando o sistema configurado para atualizar
     * automaticamente as rotas, deverá retornar ``true``.
     *
     * Também deve retornar ``true`` quando, por qualquer motivo definido na implementação, o
     * processamento anterior não existir ou for considerado como desatualizado.
     *
     * @return      bool
     */
    public function isToProcessApplicationRoutes() : bool
    {
        $r = false;
        $appConfig          = $this->serverConfig->getApplicationConfig();
        $appRoutes          = $appConfig->getPathToAppRoutes(true);
        $appControllersPath = $appConfig->getPathToControllers(true);


        // SE,
        // O domínio está configurado para atualização automática
        // do arquivo de rotas das aplicações
        // E
        // O modo de Debug está ligado
        // E
        // Estando em um ambiente definido como LCL ou DEV
        // Irá SEMPRE forçar a atualização do arquivo de rotas
        if ($this->serverConfig->getIsUpdateRoutes() === true &&
            $this->serverConfig->getIsDebugMode() === true &&
            \in_array($this->serverConfig->getEnvironmentType(), ["LCL", "DEV"]))
        {
            $r = true;
        }
        else {
            // Caso o arquivo de pré-processamento não exista.
            if (\file_exists($appRoutes) === false) {
                $r = true;
            }
            else {

                // Se o arquivo de pre-processamento existe,
                // E, SE
                // O motor da aplicação está configurado para efetuar atualizações
                // de forma automática.
                if ($this->serverConfig->getIsUpdateRoutes() === true) {
                    // Identifica o timestamp da criação do arquivo de rotas atual
                    $appRoutesFileLastMod = \filemtime($appRoutes);
                    $controllersLastMod = 0;

                    // Verifica cada um dos arquivos da pasta de controller
                    // para identificar seus timestamps e selecionar aquele que foi
                    // mais recentemente alterado/criado.
                    $controllersFiles = \scandir($appControllersPath);

                    foreach ($controllersFiles as $key => $fileName) {
                        if (\in_array($fileName, [".", ".."]) === false &&
                            \is_dir($fileName) === false &&
                            \mb_str_ends_with($fileName, ".php") === true)
                        {
                            $fileMod = \filemtime($appControllersPath . DS . $fileName);

                            // Mantém o maior valor
                            $controllersLastMod = ($fileMod > $controllersLastMod) ? $fileMod : $controllersLastMod;
                        }
                    }

                    // Se há algum controller adicionado/alterado após a data de criação
                    // do arquivo de pré-processamento das rotas, então deverá ser feito um
                    // novo reprocessamento.
                    if ($controllersLastMod > $appRoutesFileLastMod) {
                        $r = true;
                    }
                }
            }
        }


        return $r;
    }





    /**
     * Aloca o novo valor para o documento ``AppRoutes``.
     *
     * @var     array
     */
    protected array $appRoutes = [];
    /**
     * Varre os arquivos de ``controllers`` da aplicação e efetua o processamento das mesmas.
     * Idealmente o resultado deve ser um arquivo de configuração contendo todos os dados necessários
     * para a execução de cada rota de forma individual.
     *
     * @return      void
     *
     * @throws      \RuntimeException
     *              Caso algum erro ocorra no processo.
     */
    public function processApplicationRoutes() : void
    {
        $appConfig          = $this->serverConfig->getApplicationConfig();
        $appControllersPath = $appConfig->getPathToControllers(true);
        $pathToAppRoutes    = $appConfig->getPathToAppRoutes(true);
        $this->appRoutes    = [];


        // Verifica os arquivos da pasta de controller
        $controllersFiles = \scandir($appControllersPath);
        foreach ($controllersFiles as $key => $fileName) {
            if (\in_array($fileName, [".", ".."]) === false &&
                \is_dir($fileName) === false &&
                \mb_str_ends_with($fileName, ".php") === true)
            {
                $controllerName = \str_replace(".php", "", $fileName);
                $this->registerControllerRoutes($controllerName);
            }
        }

        \file_put_contents(
            $pathToAppRoutes,
            "<?php return " . \var_export($this->appRoutes, true) . ";"
        );
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
     * @throws      \RuntimeException
     *              Caso algum erro ocorra no processo.
     */
    protected function registerControllerRoutes(string $controllerName) : void
    {
        $appConfig              = $this->serverConfig->getApplicationConfig();
        $appName                = $appConfig->getAppName();
        $controllerFullName     = $appConfig->getControllersNamespace() . "\\" . $controllerName;
        $controllerRoutes       = [];

        // Efetua o merge das configurações de rotas que está vindo da
        // aplicação com as definições básicas do próprio controller (caso esteja definido)
        $applicationRouteConfig = $appConfig->getDefaultRouteConfig();
        $applicationRouteConfig["controller"] = $controllerName;

        $controllerReflection   = new \ReflectionClass($controllerFullName);
        $controllerRouteConfig  = $controllerReflection->getConstant("defaultRouteConfig");
        $controllerRouteConfig  = (($controllerRouteConfig === false) ? [] : $controllerRouteConfig);
        $controllerRouteConfig  = $this->mergeRouteConfigs($applicationRouteConfig, $controllerRouteConfig, true);



        // Apenas se houverem propriedades estáticas definidas...
        $staticProperties   = $controllerReflection->getStaticProperties();
        if (\is_array($staticProperties) === true && \count($staticProperties) > 0) {
            foreach ($staticProperties as $propName => $value) {
                // sendo uma propriedade de registro de rotas.
                if (\mb_str_starts_with($propName, "registerRoute") === true)  {
                    // Extrai a configuração da rota individualmente
                    if (\is_string($value) === true) {
                        $actionRouteConfig = $this->mergeRouteConfigs(
                            $controllerRouteConfig,
                            $this->parseStringRouteConfiguration($value)
                        );
                    }
                    else {
                        $actionRouteConfig = $this->mergeRouteConfigs(
                            $controllerRouteConfig,
                            $value
                        );

                        if (\is_string($actionRouteConfig["allowedMethods"]) === true) {
                            $actionRouteConfig["allowedMethods"] = [$actionRouteConfig["allowedMethods"]];
                        }
                    }


                    // Se não foram definidos os métodos HTTP com os quais
                    // esta rota está apta a trabalhar...
                    if ($actionRouteConfig["allowedMethods"] === []) {
                        $err = "Invalid Route Register. ``allowedMethods`` is not defined.";
                        throw new \RuntimeException($err);
                    }
                    else {
                        foreach ($actionRouteConfig["allowedMethods"] as $method) {
                            $cloneRouteConfig   = \array_merge([], $actionRouteConfig);
                            $cloneRouteConfig["method"] = $method;
                            $controllerRoutes[] = \AeonDigital\EnGarde\Config\Route::fromArray($cloneRouteConfig);
                        }
                    }
                }
            }
        }



        // Apenas se houverem rotas definidas
        if (\count($controllerRoutes) > 0) {

            // Classifica as rotas
            foreach ($controllerRoutes as $cfg) {
                $method = $cfg->getMethod();
                $routes = $cfg->getRoutes();


                // SE
                // o método HTTP que está sendo evocado deve ser executado pelo framework...
                if (\array_in_ci($method, $this->serverConfig->getFrameworkHTTPMethods()) === true) {
                    $err = "The Method HTTP \"" . $method . "\" is implemented by the framework and can not be set in route configuration.";
                    throw new \InvalidArgumentException($err);
                }


                // Para cada rota que executa esta mesma ação
                foreach ($routes as $route) {
                    $regexRoute = $this->normalizeRouteRegEx("/" . $appName . "/" . \ltrim($route, "/"));
                    $routeType = ((\mb_strpos($regexRoute, "<") === false) ? "simple" : "complex");

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
     * Retorna a mescla de 2 arrays associativos contendo as configurações de rotas.
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
    protected function mergeRouteConfigs(
        array $initialRouteConfig,
        array $newRouteConfig,
        bool $isController = false
    ) : array {
        $config = $initialRouteConfig;

        if (\count($newRouteConfig) > 0) {
            // Coleção de propriedades que PODEM ser sobrescritas
            // em nível de action.
            $allowedProperties = [
                "action",
                "allowedMethods",
                "allowedMimeTypes",
                "isUseXHTML",
                "routes",
                "runMethodName",
                "customProperties",
                "isAutoLog",
                "description",
                "devDescription",
                "relationedRoutes",
                "middlewares",
                "isSecure",
                "isUseCache",
                "cacheTimeout",
                "responseIsDownload",
                "responseDownloadFileName",
                "responseHeaders",
                "masterPage",
                "view",
                "styleSheets",
                "javaScripts",
                "metaData",
                "localeDictionary"
            ];


            // Remove das propriedades os itens que NÃO podem ser definidos pelas
            // regras gerais dos controllers.
            if ($isController === true) {
                unset($allowedProperties[\array_search("action", $allowedProperties)]);
                unset($allowedProperties[\array_search("routes", $allowedProperties)]);
            }


            // As seguintes propriedades devem ser SOMADAS
            // aos valores pré-existentes.
            $mergeArrays = [
                "relationedRoutes", "middlewares", "responseHeaders", "styleSheets", "javaScripts", "metaData"
            ];


            // Para cada item na coleção que deve sobrescrever a inicial...
            foreach ($newRouteConfig as $key => $value) {
                if (\in_array($key, $allowedProperties) === true) {
                    if (\in_array($key, $mergeArrays) === true && isset($initialRouteConfig[$key]) === true) {
                        $value = \array_merge($config[$key], $value);
                    }
                    $config[$key] = $value;
                }
            }
        }

        return $config;
    }





    /**
     * Efetua a analise da configuração de uma rota feita em formato de string.
     *
     * @param       string $config
     *              String que será analisada.
     *              Cada porção (separada por espaço) será verificada.
     *              O formato esperado deve seguir o seguinte padrão:
     *              [method] route action [secure|public|- [cache|no-cache [timeout]]]
     *
     *              **method**  equivale a propriedade ``allowedMethods``.
     *              apenas pode ser omitido se for definido apenas os itens **route** e **action**.
     *              Em caso de omissão será retornado o valor ``["GET"]``.
     *
     *              **secure|public|-** equivale a propriedade ``isSecure``.
     *                  Para definir como ``true``, use **secure**.
     *                  Para definir como ``false``, use **public**.
     *                  Para herdar das definições hierarquicamente superiores use **-**.
     *
     *              **cache|no-cache** permite definir os valores de ``isUseCache``
     *                  Para definir como ``true``, use **cache**
     *                  Para definir como ``false``, use **no-cache**
     *
     *              **timeout** permite definir ``cacheTimeout``.
     *                  Deve ser um valor inteiro maior que zero.
     *                  É obrigatório quando a definição de cache existe.
     *
     * @return      array
     *              Array associativo contendo os valores:
     *              - ``allowedMethods``, ``route``, ``action``
     *              As propriedades ``isSecure``, ``isUseCache``, ``cacheTimeout`` são
     *              opcionais
     *
     * @throws      RuntimeException
     *              Caso qualquer das partes da configuração seja inválida.
     */
    protected function parseStringRouteConfiguration(string $config) : array
    {
        $configParts = \array_map("trim", \explode(" ", $config));
        if (\count($configParts) <= 1) {
            $err = "Route configuration fail. Check documentation [ \"$config\" ].";
            throw new \RuntimeException($err);
        }
        else {
            $rConfig = [
                "allowedMethods"    => ["GET"],
                "routes"            => [""],
                "action"            => ""
            ];
            $cParts = \count($configParts);

            if ($cParts === 2) {
                $rConfig["routes"]  = [$configParts[0]];
                $rConfig["action"]  = $configParts[1];
            }
            else {
                $rConfig["allowedMethods"]  = [$configParts[0]];
                $rConfig["routes"]          = [$configParts[1]];
                $rConfig["action"]          = $configParts[2];

                if ($cParts >= 4) {
                    if ($configParts[3] === "secure") {
                        $rConfig["isSecure"] = true;
                    }
                    elseif($configParts[3] === "public") {
                        $rConfig["isSecure"] = false;
                    }
                }


                if ($cParts >= 5) {
                    if ($configParts[4] === "cache") {
                        $rConfig["isUseCache"] = true;
                        $rConfig["cacheTimeout"] = 0;
                        $err = null;
                        if ($cParts === 5) {
                            $err = "Route configuration fail. Cache timeout must be a integer greather than zero. Given: [ \"$config\" ].";
                        }
                        else {
                            $rConfig["cacheTimeout"] = (int)$configParts[5];
                            if ($rConfig["cacheTimeout"] <= 0) {
                                $err = "Route configuration fail. Cache timeout must be a integer greather than zero. Given: [ \"$config\" ].";
                            }
                        }

                        if ($err !== null) {
                            throw new \RuntimeException($err);
                        }
                    }
                    elseif($configParts[4] === "no-cache") {
                        $rConfig["isUseCache"] = false;
                    }
                }
            }

            return $rConfig;
        }
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
    protected function normalizeRouteRegEx(string $route) : string
    {
        $str = "";
        if ($route !== "") {
            $route = \rtrim($route, "/") . "/";

            $patternNamedKey = "/\/(\w+):([\w\{\}\(\)\[\]\-\_\+\\\]+)/";
            $replaceNamedKey = "/(?P<=\$1=>\$2)";

            $finalRegex = \preg_replace($patternNamedKey, $replaceNamedKey, $route);
            $finalRegex = \str_replace("/", "\/", $finalRegex);


            while (\mb_strpos($finalRegex, "=") !== false) {
                $pos = \mb_strpos($finalRegex, "=");
                $finalRegex[$pos] = "\0";
            }

            // Remove bytes nulos e retorna o resultado
            $str = \str_replace("\0", "", "/^" . $finalRegex . "/");
        }

        return $str;
    }





    /**
     * Identifica se a rota passada corresponde a alguma das rotas configuradas para a
     * aplicação e retorna um array associativo contendo todos os dados correspondentes a mesma.
     *
     * Em caso de falha na identificação da rota será retornado ``null``.
     *
     * @param       string $targetRoute
     *              Porção relativa da ``URI`` que está sendo executada.
     *              É necessário constar na rota, como sua primeira parte, o nome da aplicação
     *              que está sendo executada.
     *              Não deve constar quaisquer parametros ``querystring`` ou ``fragment``.
     *
     * @return      ?array
     */
    public function selectTargetRawRoute(string $targetRoute) : ?array
    {
        $matchRoute     = null;
        $targetRoute    = "/" . \trim($targetRoute, "/") . "/";
        $regexRoute     = $this->normalizeRouteRegEx($targetRoute);
        $appRoutes      = include(
            $this->serverConfig->
                getApplicationConfig()->
                getPathToAppRoutes(true)
        );


        // Se há rotas definidas no arquivo de configuração
        if (\count($appRoutes) !== 0) {
            $matchRoute = [
                "route"     => null,
                "config"    => null,
                "parans"    => null
            ];


            // Havendo rotas simples, verifica entre elas em primeiro lugar
            if (isset($appRoutes["simple"]) === true) {
                // Verifica se há alguma rota com nome exato da atual URL
                foreach ($appRoutes["simple"] as $route => $config) {
                    if ($regexRoute === $route) {
                        $matchRoute["route"]    = $route;
                        $matchRoute["config"]   = $config;
                        break;
                    }
                }
            }


            // Se ainda não encontrou a rota certa pesquisa entre as rotas complexas
            if ($matchRoute["route"] === null && isset($appRoutes["complex"]) === true) {
                $matchIndex = 0;
                $matchRoutes = [];

                // Verifica apenas as rotas que ainda não foram conferidas
                foreach ($appRoutes["complex"] as $route => $config) {
                    // Verifica se a URL atual é compativel com a rota informada.
                    if (\preg_match($route, $targetRoute, $urlParans) === 1) {
                        $matchRoutes[] = [
                            "route"     => $route,
                            "config"    => $config,
                            "parans"    => $urlParans
                        ];
                    }
                }


                // Apenas se realmente encontrou alguma rota válida...
                if (\count($matchRoutes) > 0) {

                    // Se encontrou mais de 1 match
                    if (\count($matchRoutes) > 1) {
                        $countParts = 0;

                        // Verifica qual rota fechou mais partes
                        // significando assim que ela adequa-se mais idealmente ao
                        // definido.
                        foreach ($matchRoutes as $i => $matchs) {
                            $parts = \substr_count($matchs["route"], "/");

                            if ($parts > $countParts) {
                                $matchIndex = $i;
                                $countParts = $parts;
                            }
                        }
                    }


                    // Recolhe as informações definidas
                    $matchRoute = $matchRoutes[$matchIndex];


                    // Remove as chaves numéricas do array de parametros resultante
                    foreach ($matchRoute["parans"] as $key => $value) {
                        if ($key === 0 || \intval($key)) {
                            unset($matchRoute["parans"][$key]);
                        }
                    }
                }
            }



            // Se nenhuma rota for identificada como compatível.
            if ($matchRoute["route"] === null) {
                $matchRoute = null;
            }
        }


        return $matchRoute;
    }
}
