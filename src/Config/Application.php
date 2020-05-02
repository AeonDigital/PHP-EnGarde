<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplication;







/**
 * Implementação de ``Config\iApplication``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Application extends BObject implements iApplication
{
    use \AeonDigital\Traits\MainCheckArgumentException;




    /**
     * Nome da aplicação.
     *
     * @var         string
     */
    private string $appName = "";
    /**
     * Retorna o nome da aplicação.
     *
     * @return      string
     */
    public function getAppName() : string
    {
        return $this->appName;
    }
    /**
     * Define o nome da aplicação.
     *
     * @param       string $appName
     *              Nome da aplicação.
     *
     * @return      void
     */
    private function setAppName(string $appName) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "appName", $appName, [
                [
                    "validate"          => "is string not empty"
                ]
            ]
        );
        $this->appName = $appName;
    }



    /**
     * Caminho completo até o diretório raiz da aplicação.
     *
     * @var         string
     */
    private string $appRootPath = "";
    /**
     * Retorna o caminho completo até o diretório raiz da aplicação.
     *
     * Todas as demais configurações que indicam diretórios ou arquivos usando caminhos
     * relativos iniciam a partir deste diretório.
     *
     * @return      string
     */
    public function getAppRootPath() : string
    {
        return $this->appRootPath;
    }
    /**
     * Define o caminho completo até o diretório raiz da aplicação.
     *
     * Todas as demais configurações que indicam diretórios ou arquivos usando caminhos
     * relativos iniciam a partir deste diretório.
     *
     * @param       string $appRootPath
     *              Caminho completo até a raiz da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setAppRootPath(string $appRootPath) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "appRootPath", $appRootPath, [
                ["validate"          => "is string not empty"],
                ["validate"          => "is dir exists"]
            ]
        );
        $this->appRootPath = \to_system_path($appRootPath);
    }



    /**
     * Caminho relativo (a partir de "appRootPath") até o
     * arquivo de rotas da aplicação.
     *
     * @var         string
     */
    private string $pathToAppRoutes = "";
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de rotas da aplicação.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    public function getPathToAppRoutes(bool $fullPath = false) : string
    {
        return (
            ($fullPath === false) ?
            $this->pathToAppRoutes :
            $this->appRootPath . $this->pathToAppRoutes
        );
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até o arquivo de rotas da aplicação.
     *
     * @param       string $pathToAppRoutes
     *              Caminho relativo até o arquivo de rotas da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setPathToAppRoutes(string $pathToAppRoutes) : void
    {
        $path = (
            ($pathToAppRoutes !== "") ?
            $this->appRootPath . $pathToAppRoutes :
            $pathToAppRoutes
        );
        $this->mainCheckForInvalidArgumentException(
            "pathToAppRoutes", $path, [
                ["validate"         => "is string not empty"],
                [
                    "executeBeforeValidate" => function($args) {
                        return \dirname($args["argValue"]);
                    },
                    "validate"      => "is dir exists"
                ]
            ]
        );
        $this->pathToAppRoutes = \to_system_path($pathToAppRoutes);
    }



    /**
     * Caminho relativo (a partir de "appRootPath") até o
     * diretório de controllers da aplicação.
     *
     * @var         string
     */
    private string $pathToControllers = "";
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de controllers
     * da aplicação.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    public function getPathToControllers(bool $fullPath = false) : string
    {
        return (
            ($fullPath === false) ?
            $this->pathToControllers :
            $this->appRootPath . $this->pathToControllers
        );
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até o diretório de controllers
     * da aplicação.
     *
     * @param       string $pathToControllers
     *              Caminho relativo até o diretório dos controllers da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setPathToControllers(string $pathToControllers) : void
    {
        $path = (
            ($pathToControllers !== "") ?
            $this->appRootPath . $pathToControllers :
            $pathToControllers
        );
        $this->mainCheckForInvalidArgumentException(
            "pathToControllers", $path, [
                ["validate"         => "is string not empty"],
                ["validate"         => "is dir exists"]
            ]
        );
        $this->pathToControllers = \to_system_path($pathToControllers);
    }



    /**
     * Caminho relativo (a partir de "appRootPath") até o
     * diretório das views da aplicação.
     *
     * @var         string
     */
    private string $pathToViews = "";
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório das views
     * da aplicação.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    public function getPathToViews(bool $fullPath = false) : string
    {
        return (
            ($fullPath === false) ?
            $this->pathToViews :
            $this->appRootPath . $this->pathToViews
        );
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até o diretório das views
     * da aplicação.
     *
     * @param       string $pathToViews
     *              Caminho relativo até o diretório das views da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setPathToViews(string $pathToViews) : void
    {
        $path = (
            ($pathToViews !== "") ?
            $this->appRootPath . $pathToViews :
            $pathToViews
        );
        $this->mainCheckForInvalidArgumentException(
            "pathToViews", $path, [
                ["validate"         => "is string not empty"],
                ["validate"         => "is dir exists"]
            ]
        );
        $this->pathToViews = \to_system_path($pathToViews);
    }



    /**
     * Caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os recursos para as views (imagens, JS, CSS ...).
     *
     * @var         string
     */
    private string $pathToViewsResources = "";
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os recursos para as views (imagens, JS, CSS ...).
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    public function getPathToViewsResources(bool $fullPath = false) : string
    {
        return (
            ($fullPath === false) ?
            $this->pathToViewsResources :
            $this->appRootPath . $this->pathToViewsResources
        );
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os recursos para as views (imagens, JS, CSS ...).
     *
     * @param       string $pathToViewsResources
     *              Caminho relativo até o diretório dos recursos das views.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setPathToViewsResources(string $pathToViewsResources) : void
    {
        $path = (
            ($pathToViewsResources !== "") ?
            $this->appRootPath . $pathToViewsResources :
            $pathToViewsResources
        );
        $this->mainCheckForInvalidArgumentException(
            "pathToViewsResources", $path, [
                ["validate"         => "is string not empty"],
                ["validate"         => "is dir exists"]
            ]
        );
        $this->pathToViewsResources = \to_system_path($pathToViewsResources);
    }



    /**
     * Caminho relativo (a partir de "appRootPath") até o diretório
     * que estarão armazenados os documentos de configuração das legendas.
     *
     * @var         string
     */
    private string $pathToLocales = "";
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os documentos de configuração das legendas.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    public function getPathToLocales(bool $fullPath = false) : string
    {
        return (
            ($fullPath === false) ?
            $this->pathToLocales :
            $this->appRootPath . $this->pathToLocales
        );
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os documentos de configuração das legendas.
     *
     * @param       string $pathToLocales
     *              Caminho relativo até o diretório das legendas da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setPathToLocales(string $pathToLocales) : void
    {
        $path = (
            ($pathToLocales !== "") ?
            $this->appRootPath . $pathToLocales :
            $pathToLocales
        );
        $this->mainCheckForInvalidArgumentException(
            "pathToLocales", $path, [
                [
                    "conditions"       => "is string not empty",
                    "validate"         => "is dir exists"
                ]
            ]
        );
        $this->pathToLocales = \to_system_path($pathToLocales);
    }



    /**
     * Caminho relativo (a partir de "appRootPath") até o
     * diretório de armazenamento para os arquivos de cache.
     *
     * @var         string
     */
    private string $pathToCacheFiles = "";
    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de armazenamento
     * para os arquivos de cache.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    public function getPathToCacheFiles(bool $fullPath = false) : string
    {
        return (
            ($fullPath === false) ?
            $this->pathToCacheFiles :
            $this->appRootPath . $this->pathToCacheFiles
        );
    }
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até o diretório de armazenamento
     * para os arquivos de cache.
     *
     * @param       string $pathToCacheFiles
     *              Caminho relativo até o diretório dos arquivos de cache.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setPathToCacheFiles(string $pathToCacheFiles) : void
    {
        $path = (
            ($pathToCacheFiles !== "") ?
            $this->appRootPath . $pathToCacheFiles :
            $pathToCacheFiles
        );
        $this->mainCheckForInvalidArgumentException(
            "pathToCacheFiles", $path, [
                [
                    "conditions"       => "is string not empty",
                    "validate"         => "is dir exists"
                ]
            ]
        );
        $this->pathToCacheFiles = \to_system_path($pathToCacheFiles);
    }










    /**
     * Rota inicial da aplicação.
     *
     * @var         string
     */
    private string $startRoute = "";
    /**
     * Retorna a rota inicial da aplicação.
     *
     * @return      string
     */
    public function getStartRoute() : string
    {
        return $this->startRoute;
    }
    /**
     * Define a rota inicial da aplicação.
     *
     * @param       string $startRoute
     *              Rota inicial da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setStartRoute(string $startRoute) : void
    {
        $this->startRoute = $startRoute;
    }



    /**
     * Namespace para os controllers da aplicação.
     *
     * @var         string
     */
    private string $controllersNamespace = "";
    /**
     * Retorna a Namespace comum à todos os controllers da aplicação corrente.
     *
     * @return      string
     */
    public function getControllersNamespace() : string
    {
        return $this->controllersNamespace;
    }
    /**
     * Define a Namespace comum à todos os controllers da aplicação corrente.
     *
     * @param       string $controllersNamespace
     *              Namespace para os controllers da aplicação.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setControllersNamespace(string $controllersNamespace) : void
    {
        $this->controllersNamespace = "\\" . \trim($controllersNamespace, "\\");
    }



    /**
     * Coleção de locales suportada pela aplicação.
     *
     * @var         array
     */
    private array $locales = [];
    /**
     * Retorna a coleção de locales suportada pela aplicação.
     *
     * @return      array
     */
    public function getLocales() : array
    {
        return $this->locales;
    }
    /**
     * Define a coleção de locales suportada pela aplicação.
     *
     * @param       array $locales
     *              Coleção de locales.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso a coleção indicada seja inválida.
     */
    private function setLocales(array $locales) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "locales", $locales, [
                ["validate"      => "is array not empty"],
                [
                    "validate"   => "foreach array child",
                    "foreachChild" => [
                        [
                            "validate" => "is string not empty"
                        ],
                        [
                            "validate" => "closure",
                            "closure" => function($arg) {
                                return (\strlen($arg) === 5 && \strpos($arg, "-") === 2);
                            }
                        ]
                    ]
                ]
            ]
        );
        $this->locales = \array_map("mb_strtolower", $locales);
        $this->defaultLocale = $this->locales[0];
    }



    /**
     * Locale padrão para a aplicação corrente.
     *
     * @var         string
     */
    private string $defaultLocale = "";
    /**
     * Retorna o locale padrão para a aplicação corrente.
     *
     * @return      string
     */
    public function getDefaultLocale() : string
    {
        return $this->defaultLocale;
    }
    /**
     * Define o locale padrão para a aplicação corrente.
     *
     * @param       string $locale
     *              Locale padrão.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o locale indicado seja inválido.
     */
    private function setDefaultLocale(string $locale) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "locale", $locale, [
                ["validate"      => "is string not empty"],
                [
                    "validate"          => "is allowed_value",
                    "allowedValues"     => $this->locales,
                    "caseInsensitive"   => true
                ]
            ]
        );
        $this->defaultLocale = \strtolower($locale);
    }



    /**
     * Indica se deve ser usado o sistema de legendas.
     *
     * @var         bool
     */
    private bool $isUseLabels = false;
    /**
     * Retorna ``true`` se a aplicação deve usar o sistema de legendas.
     *
     * @return      bool
     */
    public function getIsUseLabels() : bool
    {
        return $this->isUseLabels;
    }
    /**
     * Define se a aplicação deve ou não utilizar o sistema de legendas.
     *
     * @param       bool $useLabels
     *              Indica se é para usar o sistema de legendas.
     *
     * @return      void
     */
    private function setIsUseLabels(bool $isUseLabels) : void
    {
        $this->isUseLabels = $isUseLabels;
    }



    /**
     * Array associativo contendo os valores padrões para as rotas da aplicação.
     *
     * @var         array
     */
    private array $defaultRouteConfig = [];
    /**
     * Retorna um array associativo contendo os valores padrões para as rotas de toda a
     * aplicação. Estes valores podem ser sobrescritos pelas definições padrões dos controllers
     * e das próprias rotas.
     *
     * @return      array
     */
    public function getDefaultRouteConfig() : array
    {
        return $this->defaultRouteConfig;
    }
    /**
     * Define um array associativo contendo os valores padrões para as rotas de toda a
     * aplicação. Estes valores podem ser sobrescritos pelas definições padrões dos controllers
     * e das próprias rotas.
     *
     * Neste momento da configuração apenas as seguintes propriedades podem ser definidas:
     *
     * allowedMethods, allowedMimeTypes, isUseXHTML, runMethodName, customProperties,
     * description, devDescription, middlewares, isSecure, isUseCache, cacheTimeout,
     * responseHeaders, masterPage, view, styleSheets, javaScripts, metaData, localeDirectory
     *
     * @param       array $defaultRouteConfig
     *              Array associativo.
     *
     * @return      void
     */
    private function setDefaultRouteConfig(array $defaultRouteConfig) : void
    {
        $baseRouteConfig = [
            "application"       => $this->getAppName(),
            "namespace"         => $this->getControllersNamespace(),
            "controller"        => "",
            "action"            => "",
            "allowedMethods"    => [],
            "allowedMimeTypes"  => [],
            "method"            => "",
            "isUseXHTML"        => false,
            "routes"            => [],
            "runMethodName"     => "",
            "customProperties"  => [],
            "description"       => "",
            "devDescription"    => "",
            "relationedRoutes"  => [],
            "middlewares"       => [],
            "isSecure"          => false,
            "isUseCache"        => false,
            "cacheTimeout"      => 0,
            "responseHeaders"   => [],
            "masterPage"        => "",
            "view"              => "",
            "styleSheets"       => [],
            "javaScripts"       => [],
            "metaData"          => [],
            "localeDirectory"   => ""
        ];


        // Coleção de propriedades que podem ser definidas
        $allowedProperties = [
            "allowedMethods", "allowedMimeTypes", "isUseXHTML", "runMethodName", "customProperties",
            "description", "devDescription", "middlewares", "isSecure", "isUseCache",
            "cacheTimeout", "responseHeaders", "masterPage", "view", "styleSheets",
            "javaScripts", "metaData", "localeDirectory",
        ];


        foreach ($defaultRouteConfig as $key => $value) {
            if (\in_array($key, $allowedProperties) === true) {
                $baseRouteConfig[$key] = $value;
            }
        }

        $this->defaultRouteConfig = $baseRouteConfig;
    }










    /**
     * Caminho relativo até a view que deve ser enviada ao
     * UA em caso de erros na aplicação.
     *
     * @var         string
     */
    private string $pathToErrorView = "";
    /**
     * Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros
     * na aplicação.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    public function getPathToErrorView(bool $fullPath = false) : string
    {
        return (
            ($fullPath === false) ?
            $this->pathToErrorView :
            $this->appRootPath . $this->pathToErrorView
        );
    }
    /**
     * Define o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros
     * no domínio.
     *
     * O caminho deve ser definido a partir do diretório raiz da aplicação.
     *
     * @param       ?string $pathToErrorView
     *              Caminho até a view de erro padrão.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o arquivo alvo seja inexistente.
     */
    private function setPathToErrorView(string $pathToErrorView) : void
    {
        $this->pathToErrorView = \to_system_path($pathToErrorView);
        $fullPathToErrorView = $this->getPathToErrorView(true);

        $this->mainCheckForInvalidArgumentException(
            "pathToErrorView", $fullPathToErrorView, [
                [
                    "conditions" => "is string not empty",
                    "validate" => "is file exists",
                ]
            ]
        );
        \AeonDigital\EnGarde\Handler\ErrorListening::setPathToErrorView(
            $fullPathToErrorView
        );
    }





    /**
     * Array associativo contendo a correlação entre os métodos HTTP
     * e suas respectivas classes de resolução.
     *
     * @var         array
     */
    private array $httpSubSystemNamespaces = [];
    /**
     * Resgata um array associativo contendo a correlação entre os métodos HTTP
     * e suas respectivas classes de resolução.
     *
     * Tais classes serão usadas exclusivamente para resolver os métodos HTTP que
     * originalmente devem ser processados pelo framework.
     *
     * Originalmente estes:
     * "HEAD", "OPTIONS", "TRACE", "DEV", "CONNECT"
     *
     * ```
     * // ex:
     * $arr = [
     *  "HEAD"  => "full\\qualified\\namespace\\classnameHead",
     *  "DEV"   => "full\\qualified\\namespace\\classnameDEV"
     * ]
     * ```
     *
     * @return      array
     */
    public function getHTTPSubSystemNamespaces() : array
    {
        return $this->httpSubSystemNamespaces;
    }
    /**
     * Define um array associativo contendo a correlação entre os métodos HTTP
     * e suas respectivas classes de resolução.
     *
     * @param       array $httpSubSystemNamespaces
     *              Array contendo a correlação entre os métodos e as classes
     *              que devem ser usadas para resolver tais requisições.
     *
     * @return      void
     */
    private function setHTTPSubSystemNamespaces(array $httpSubSystemNamespaces) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "httpSubSystemNamespaces", $httpSubSystemNamespaces, [
                [
                    "condition" => "is array not empty",
                    "validate"  => "is array assoc",
                ],
                [
                    "validate"  => "is allowed key",
                    "allowedValues" => ["HEAD", "OPTIONS", "TRACE", "DEV", "CONNECT"],
                ],
                [
                    "validate"  => "foreach array child",
                    "foreachChild" => ["is string not empty"]
                ]
            ]
        );
        $this->httpSubSystemNamespaces = $httpSubSystemNamespaces;
    }










    /**
     * Inicia uma nova instância de configurações para a aplicação.
     *
     * @param       string $appName
     *              Nome da aplicação.
     *
     * @param       string $appRootPath
     *              Caminho completo até o diretório raiz da aplicação.
     *
     * @param       string $pathToAppRoutes
     *              Caminho relativo (a partir de "appRootPath") até o arquivo de rotas da
     *              aplicação.
     *
     * @param       string $pathToControllers
     *              Caminho relativo (a partir de "appRootPath") até o diretório de controllers
     *              da aplicação.
     *
     * @param       string $pathToViews
     *              Caminho relativo (a partir de "appRootPath") até o diretório das views da
     *              aplicação.
     *
     * @param       string $pathToViewsResources
     *              Caminho relativo (a partir de ``appRootPath``) até o diretório de recursos
     *              para as views (imagens, JS, CSS ...).
     *
     * @param       string $pathToLocales
     *              Caminho relativo (a partir de "appRootPath") até o diretório que estarão
     *              armazenados os documentos de configuração das legendas.
     *
     * @param       string $pathToCacheFiles
     *              Caminho relativo (a partir de "appRootPath") até o diretório de armazenamento
     *              para os arquivos de cache.
     *
     * @param       string $startRoute
     *              Rota inicial da aplicação.
     *
     * @param       string $controllersNamespace
     *              Namespace para os controllers da aplicação.
     *
     * @param       array $locales
     *              Coleção de locales suportada pela aplicação.
     *
     * @param       string $defaultLocale
     *              Locale padrão para a aplicação corrente.
     *
     * @param       bool $isUseLabels
     *              Indica se deve ser usado o sistema de legendas.
     *
     * @param       array $defaultRouteConfig
     *              Array associativo contendo os valores padrões para as rotas da aplicação.
     *
     * @param       string $pathToErrorView
     *              Caminho relativo até a view que deve ser enviada ao UA em caso de erros
     *              na aplicação.
     *
     * @param       array $httpSubSystemNamespaces
     *              Coleção de métodos HTTP que devem ser resolvidos pelo framework e as
     *              respectivas classes que devem resolver cada qual.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function __construct(
        string $appName,
        string $appRootPath,
        string $pathToAppRoutes,
        string $pathToControllers,
        string $pathToViews,
        string $pathToViewsResources,
        string $pathToLocales,
        string $pathToCacheFiles,
        string $startRoute,
        string $controllersNamespace,
        array $locales,
        string $defaultLocale,
        bool $isUseLabels,
        array $defaultRouteConfig,
        string $pathToErrorView,
        array $httpSubSystemNamespaces
    ) {
        $this->setAppName($appName);
        $this->setAppRootPath($appRootPath);
        $this->setPathToAppRoutes($pathToAppRoutes);
        $this->setPathToControllers($pathToControllers);
        $this->setPathToViews($pathToViews);
        $this->setPathToViewsResources($pathToViewsResources);
        $this->setPathToLocales($pathToLocales);
        $this->setPathToCacheFiles($pathToCacheFiles);
        $this->setStartRoute($startRoute);
        $this->setControllersNamespace($controllersNamespace);
        $this->setLocales($locales);
        $this->setDefaultLocale($defaultLocale);
        $this->setIsUseLabels($isUseLabels);
        $this->setDefaultRouteConfig($defaultRouteConfig);
        $this->setPathToErrorView($pathToErrorView);
        $this->setHTTPSubSystemNamespaces($httpSubSystemNamespaces);
    }










    /**
     * Inicia uma nova instância ``Config\iApplication``.
     *
     * @codeCoverageIgnore
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @return      iApplication
     */
    public static function fromArray(array $config) : iApplication
    {
        $useAppRootPath = (
            (\key_exists("appRootPath", $config) === true) ?
            \to_system_path($config["appRootPath"]) :
            ""
        );



        // Define os valores padrões para a instância e
        // sobrescreve-os com os valores informados em $config
        $appName    = ((\key_exists("appName", $config) === true) ? $config["appName"] : "");
        $useValues  = \array_merge(
            [
                "appName"                   => "",
                "appRootPath"               => $useAppRootPath,
                "pathToAppRoutes"           => DS . "AppRoutes.php",
                "pathToControllers"         => DS . "controllers",
                "pathToViews"               => DS . "views",
                "pathToViewsResources"      => DS . "resources",
                "pathToLocales"             => DS . "locales",
                "pathToCacheFiles"          => DS . "cache",
                "startRoute"                => "/",
                "controllersNamespace"      => "\\$appName\\controllers",
                "locales"                   => [],
                "defaultLocale"             => "",
                "isUseLabels"               => false,
                "defaultRouteConfig"        => [],
                "pathToErrorView"           => "",
                "httpSubSystemNamespaces"   => []
            ],
            $config
        );



        // Inicia o novo objeto com as configurações definidas.
        return new Application(
            $useValues["appName"],
            $useValues["appRootPath"],
            $useValues["pathToAppRoutes"],
            $useValues["pathToControllers"],
            $useValues["pathToViews"],
            $useValues["pathToViewsResources"],
            $useValues["pathToLocales"],
            $useValues["pathToCacheFiles"],
            $useValues["startRoute"],
            $useValues["controllersNamespace"],
            $useValues["locales"],
            $useValues["defaultLocale"],
            $useValues["isUseLabels"],
            $useValues["defaultRouteConfig"],
            $useValues["pathToErrorView"],
            $useValues["httpSubSystemNamespaces"]
        );
    }
}
