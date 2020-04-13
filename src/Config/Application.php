<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;
use AeonDigital\EnGarde\Interfaces\Engine\iRouter as iRouter;





/**
 * Implementação de ``iApplication``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Application extends BObject implements iApplication
{





    /**
     * Nome da aplicação.
     *
     * @var         string
     */
    private string $name = "";
    /**
     * Retorna o nome da aplicação.
     *
     * @return      string
     */
    public function getName() : string
    {
        return $this->name;
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
    public function setAppRootPath(string $appRootPath) : void
    {
        if ($this->appRootPath === "") {
            $err = null;

            // Se nenhum caminho foi definido para o caminho da raiz da aplicação
            if ($appRootPath === "") {
                $err = "The path to the root directory is invalid. Empty string received.";
            } else {
                // Verifica o diretório raiz da aplicação
                $appRootPath = \to_system_path($appRootPath) . DS;
                if (\file_exists($appRootPath) === false) {
                    $err = "The path to the root directory of the application does not exist [ \"" . $appRootPath . "\" ].";
                }
            }


            if ($err === null) {
                $this->appRootPath = $appRootPath;
            } else {
                throw new \InvalidArgumentException($err);
            }
        }
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
     * @return      string
     */
    public function getPathToAppRoutes() : string
    {
        return $this->pathToAppRoutes;
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
    public function setPathToAppRoutes(string $pathToAppRoutes) : void
    {
        if ($this->pathToAppRoutes === "") {
            $this->pathToAppRoutes = \to_system_path($pathToAppRoutes);
            $dir = \dirname($this->pathToAppRoutes);

            if (\file_exists($dir) === false) {
                $err = "The path to AppRoutes file does not exist [ \"" . $dir . "\" ].";
                throw new \InvalidArgumentException($err);
            }
        }
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
     * @return      string
     */
    public function getPathToControllers() : string
    {
        return $this->pathToControllers;
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
    public function setPathToControllers(string $pathToControllers) : void
    {
        if ($this->pathToControllers === "") {
            $this->pathToControllers = \to_system_path($pathToControllers) . DS;

            if (\file_exists($this->pathToControllers) === false) {
                $err = "The path to controllers does not exist [ \"" . $this->pathToControllers . "\" ].";
                throw new \InvalidArgumentException($err);
            }
        }
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
     * @return      string
     */
    public function getPathToViews() : string
    {
        return $this->pathToViews;
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
    public function setPathToViews(string $pathToViews) : void
    {
        if ($this->pathToViews === "") {
            $this->pathToViews = \to_system_path($pathToViews) . DS;

            if (\file_exists($this->pathToViews) === false) {
                $err = "The path to views does not exist [ \"" . $this->pathToViews . "\" ].";
                throw new \InvalidArgumentException($err);
            }
        }
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
     * @return      string
     */
    public function getPathToViewsResources() : string
    {
        return $this->pathToViewsResources;
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
    public function setPathToViewsResources(string $pathToViewsResources) : void
    {
        if ($this->pathToViewsResources === "") {
            $this->pathToViewsResources = \to_system_path($pathToViewsResources) . DS;

            if (\file_exists($this->pathToViewsResources) === false) {
                $err = "The path to views resources does not exist [ \"" . $this->pathToViewsResources . "\" ].";
                throw new \InvalidArgumentException($err);
            }
        }
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
     * @return      string
     */
    public function getPathToLocales() : string
    {
        return $this->pathToLocales;
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
    public function setPathToLocales(string $pathToLocales) : void
    {
        if ($this->pathToLocales === "") {
            $this->pathToLocales = \to_system_path($pathToLocales) . DS;

            if (\file_exists($this->pathToLocales) === false) {
                $err = "The path to locales does not exist [ \"" . $this->pathToLocales . "\" ].";
                throw new \InvalidArgumentException($err);
            }
        }
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
     * @return      string
     */
    public function getPathToCacheFiles() : string
    {
        return $this->pathToCacheFiles;
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
    public function setPathToCacheFiles(string $pathToCacheFiles) : void
    {
        if ($this->pathToCacheFiles === "") {
            $this->pathToCacheFiles = \to_system_path($pathToCacheFiles) . DS;

            if (\file_exists($this->pathToCacheFiles) === false) {
                $err = "The path to cache files does not exist [ \"" . $this->pathToCacheFiles . "\" ].";
                throw new \InvalidArgumentException($err);
            }
        }
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
    public function setStartRoute(string $startRoute) : void
    {
        if ($this->startRoute === "") {
            $this->startRoute = $startRoute;
        }
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
        return "\\" . $this->getName() . "\\" . $this->controllersNamespace;
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
    public function setControllersNamespace(string $controllersNamespace) : void
    {
        if ($this->controllersNamespace === "") {
            $this->controllersNamespace = \trim($controllersNamespace, "\\");
        }
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
    public function setLocales(array $locales) : void
    {
        if (\count($this->locales) === 0) {
            if (\count($locales) === 0) {
                $err = "It is not allowed to define an empty collection of locales.";
                throw new \InvalidArgumentException($err);
            } else {
                foreach ($locales as $value) {
                    if (\is_string($value) === false || \strlen($value) !== 5 || \strpos($value, "-") !== 2) {
                        $err = "The value \"$value\" is not a valid locale.";
                        throw new \InvalidArgumentException($err);
                    } else {
                        $this->locales[] = \strtolower($value);
                    }
                }

                if ($this->defaultLocale === null) {
                    $this->defaultLocale = $this->locales[0];
                }
            }
        }
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
    public function setDefaultLocale(string $locale) : void
    {
        if ($this->defaultLocale === "") {
            if (\array_in_ci($locale, $this->locales) === false) {
                $err = "The given locale is not defined in the application locale collection.";
                throw new \InvalidArgumentException($err);
            }
            $this->defaultLocale = \strtolower($locale);
        }
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
    public function setIsUseLabels(bool $isUseLabels) : void
    {
        $this->isUseLabels = $isUseLabels;
    }





    /**
     * Indica se deve ser usado o sistema de legendas.
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
     * - setApplication     | - setAcceptMimes      | - setResponseHeaders
     * - setIsUseXHTML      | - setMiddlewares
     * - setDescription     | - setIsSecure
     * - setIsUseCache      | - setCacheTimeout
     * - setMasterPage      | - setStyleSheets
     * - setJavaScripts     | - setMetaData
     *
     * @param       array $defaultRouteConfig
     *              Array associativo.
     *
     * @return      void
     */
    public function setDefaultRouteConfig(array $defaultRouteConfig) : void
    {
        if (\count($this->defaultRouteConfig) === 0) {


            // Coleção de propriedades que podem ser definidas
            $allowedProperties = [
                "application",
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


            foreach ($defaultRouteConfig as $key => $value) {
                if (\array_in_ci($key, $allowedProperties) === true && $value !== null) {
                    $this->defaultRouteConfig[\strtolower($key)] = $value;
                }
            }
        }
    }





    /**
     * caminho relativo até a view que deve ser enviada ao
     * UA em caso de erros na aplicação.
     *
     * @var         string
     */
    private string $pathToErrorView = "";
    /**
     * Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros
     * na aplicação.
     *
     * @return      string
     */
    public function getPathToErrorView() : string
    {
        return $this->pathToErrorView;
    }
    /**
     * Resgata o caminho completo até a view que deve ser enviada ao ``UA`` em caso de erros
     * na aplicação.
     *
     * @return      string
     */
    public function getFullPathToErrorView() : string
    {
        return (($this->pathToErrorView === "") ? "" : $this->appRootPath . $this->pathToErrorView);
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
     */
    public function setPathToErrorView(string $pathToErrorView) : void
    {
        if ($this->pathToErrorView === "") {
            $this->pathToErrorView = \to_system_path(\trim($pathToErrorView, "/\\"));
        }
    }










    /**
     * Instância ``Config\iSecurity`` a ser usada.
     *
     * @var         ?iSecurity
     */
    private ?iSecurity $securityConfig = null;
    /**
     * Instância ``iRouter`` a ser usada.
     *
     * @var         iRouter
     */
    private iRouter $router;





    /**
     * Retorna as configurações de segurança da aplicação se estas forem definidas.
     *
     * @codeCoverageIgnore
     *
     * @return      iSecurity
     */
    public function getSecurityConfig() : ?iSecurity
    {
        if ($this->securityConfig === null &&
            defined("ENVIRONMENT_SETTINGS") === true &&
            isset(ENVIRONMENT_SETTINGS[$this->getName()]) === true &&
            isset(ENVIRONMENT_SETTINGS[$this->getName()]["securityConfig"]) === true)
        {
            $this->securityConfig = \AeonDigital\EnGarde\Config\Security::fromArray(
                ENVIRONMENT_SETTINGS[$this->getName()]["securityConfig"]
            );
        }
        return $this->securityConfig;
    }
    /**
     * Retorna a instância ``iRouter`` a ser usada.
     *
     * @codeCoverageIgnore
     *
     * @return      iRouter
     */
    public function getRouter() : iRouter
    {
        if (isset($this->router) === false) {
            $this->router = new \AeonDigital\EnGarde\Engine\Router(
                $this->getName(),
                $this->getPathToAppRoutes(),
                $this->getPathToControllers(),
                $this->getControllersNamespace(),
                $this->getDefaultRouteConfig()
            );
        }
        return $this->router;
    }









    /**
     * Inicia uma nova instância de configurações para a aplicação.
     *
     * Se ambos os parametros forem definidos o método ``autoSetProperties`` será executado.
     *
     * @param       string $appName
     *              Nome da aplicação.
     *
     * @param       string $rootPath
     *              Caminho completo até o diretório raiz do domínio.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function __construct(
        string $appName = "",
        string $rootPath = ""
    ) {
        if ($appName !== "" && $rootPath !== "") {
            $this->autoSetProperties($appName, $rootPath);
        }
        else {
            $this->name = $appName;
            $this->appRootPath = $rootPath;
        }
    }










    /**
     * Define as propriedades da aplicação que podem ser inferidas a partir do seu nome e
     * caminho até a raiz do domínio.
     *
     * @param       string $appName
     *              Nome da aplicação.
     *
     * @param       string $rootPath
     *              Caminho completo até o diretório raiz do domínio.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function autoSetProperties(string $appName, string $rootPath) : void
    {
        if ($this->name === "" && $this->appRootPath === "") {
            $this->name = $appName;
            $this->setAppRootPath($rootPath . DS . $appName . DS);


            $appRootPath = $this->getAppRootPath();
            $this->setPathToAppRoutes(      $appRootPath . "AppRoutes.php");
            $this->setPathToControllers(    $appRootPath . "controllers" . DS);
            $this->setPathToViews(          $appRootPath . "views" . DS);
            $this->setPathToViewsResources( $appRootPath . "resources" . DS);
            $this->setPathToLocales(        $appRootPath . "locales" . DS);
            $this->setPathToCacheFiles(     $appRootPath . "cache" . DS);


            $this->setStartRoute("/");
            $this->setControllersNamespace("controllers");
        }
    }
}
