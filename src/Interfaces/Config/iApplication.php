<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;

use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;








/**
 * Nesta interface estão as configurações básicas para o funcionamento de uma Aplicação.
 *
 * Todas as propriedades aqui descritas não devem poder ser alteradas após serem definidas.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iApplication
{





    /**
     * Retorna o nome da aplicação.
     *
     * @return      string
     */
    function getName() : string;
    /**
     * Define o nome da aplicação.
     *
     * @param       string $name
     *              Nome da aplicação.
     *
     * @return      void
     */
    function setName(string $name) : void;





    /**
     * Retorna o caminho completo até o diretório raiz da aplicação.
     *
     * Todas as demais configurações que indicam diretórios ou arquivos usando caminhos
     * relativos iniciam a partir deste diretório.
     *
     * @return      string
     */
    function getAppRootPath() : string;
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
    function setAppRootPath(string $appRootPath) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de rotas da aplicação.
     *
     * @return      string
     */
    function getPathToAppRoutes() : string;
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
    function setPathToAppRoutes(string $pathToAppRoutes) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de controllers
     * da aplicação.
     *
     * @return      string
     */
    function getPathToControllers() : string;
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
    function setPathToControllers(string $pathToControllers) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório das views
     * da aplicação.
     *
     * @return      string
     */
    function getPathToViews() : string;
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
    function setPathToViews(string $pathToViews) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os recursos para as views (imagens, JS, CSS ...).
     *
     * @return      string
     */
    function getPathToViewsResources() : string;
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
    function setPathToViewsResources(string $pathToViewsResources) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
     * armazenados os documentos de configuração das legendas.
     *
     * @return      string
     */
    function getPathToLocales() : string;
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
    function setPathToLocales(string $pathToLocales) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de armazenamento
     * para os arquivos de cache.
     *
     * @return      string
     */
    function getPathToCacheFiles() : string;
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
    function setPathToCacheFiles(string $pathToCacheFiles) : void;










    /**
     * Retorna a rota inicial da aplicação.
     *
     * @return      string
     */
    function getStartRoute() : string;
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
    function setStartRoute(string $startRoute) : void;





    /**
     * Retorna a Namespace comum à todos os controllers da aplicação corrente.
     *
     * @return      string
     */
    function getControllersNamespace() : string;
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
    function setControllersNamespace(string $controllersNamespace) : void;





    /**
     * Retorna a coleção de locales suportada pela aplicação.
     *
     * @return      array
     */
    function getLocales() : array;
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
    function setLocales(array $locales) : void;





    /**
     * Retorna o locale padrão para a aplicação corrente.
     *
     * @return      string
     */
    function getDefaultLocale() : string;
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
    function setDefaultLocale(string $locale) : void;





    /**
     * Retorna ``true`` se a aplicação deve usar o sistema de legendas.
     *
     * @return      bool
     */
    function getIsUseLabels() : bool;
    /**
     * Define se a aplicação deve ou não utilizar o sistema de legendas.
     *
     * @param       bool $useLabels
     *              Indica se é para usar o sistema de legendas.
     *
     * @return      void
     */
    function setIsUseLabels(bool $useLabels) : void;





    /**
     * Retorna um array associativo contendo os valores padrões para as rotas de toda a
     * aplicação. Estes valores podem ser sobrescritos pelas definições padrões dos controllers
     * e das próprias rotas.
     *
     * @return      array
     */
    function getDefaultRouteConfig() : array;
    /**
     * Define um array associativo contendo os valores padrões para as rotas de toda a
     * aplicação. Estes valores podem ser sobrescritos pelas definições padrões dos controllers
     * e das próprias rotas.
     *
     * Neste momento da configuração apenas as seguintes propriedades podem ser definidas:
     *
     * - setApplication     | - setAcceptMimes
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
    function setDefaultRouteConfig(array $defaultRouteConfig) : void;





    /**
     * Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros
     * na aplicação.
     *
     * @return      ?string
     */
    function getPathToErrorView() : ?string;
    /**
     * Resgata o caminho completo até a view que deve ser enviada ao ``UA`` em caso de erros
     * na aplicação.
     *
     * @return      ?string
     */
    function getFullPathToErrorView() : ?string;
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
    function setPathToErrorView(?string $pathToErrorView) : void;





    /**
     * Retorna as configurações de segurança da aplicação.
     *
     * @return      ?iSecurity
     */
    function getSecuritySettings() : ?iSecurity;
    /**
     * Define as configurações de segurança para a aplicação.
     *
     * @param       iSecurity $securitySettings
     *              Instância das configurações de segurança que será definida para a aplicação.
     *
     * @return      void
     */
    function setSecuritySettings(iSecurity $securitySettings) : void;










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
    function autoSetProperties(string $appName, string $rootPath) : void;
}
