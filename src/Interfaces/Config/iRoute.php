<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;










/**
 * Interface usada para representar a configuração de uma determinada rota em execução de uma
 * aplicação.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iRoute
{





    /**
     * Retorna o nome da aplicação que está sendo executada.
     *
     * @return      string
     */
    function getApplication() : string;
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
    function setApplication(string $application) : void;





    /**
     * Retorna a namespace completa do controller que está respondendo a requisição.
     *
     * @return      string
     */
    function getNamespace() : string;
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
    function setNamespace(string $namespace) : void;





    /**
     * Retorna o nome do controller que possui a action que deve resolver a rota.
     *
     * @return      string
     */
    function getController() : string;
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
    function setController(string $controller) : void;





    /**
     * Retorna o nome da action que resolve a rota.
     *
     * @return      string
     */
    function getAction() : string;
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
    function setAction(string $action) : void;





    /**
     * Retorna o método ``HTTP`` que deve ser usado para evocar esta rota.
     *
     * @return      string
     */
    function getMethod() : string;
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
    function setMethod(string $method) : void;





    /**
     * Retorna os métodos ``HTTP`` que podem ser usados para esta mesma rota.
     *
     * @return      array
     */
    function getAllowedMethods() : array;
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
    function setAllowedMethods(array $methods) : void;





    /**
     * Retorna a rota que está sendo resolvida e seus respectivos aliases.
     *
     * @return      array
     */
    function getRoutes() : array;
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
    function setRoutes(array $routes) : void;





    /**
     * Retorna um array associativo contendo a coleção de mimetypes que esta rota é capaz de
     * devolver como resposta.
     *
     * @return      array
     */
    function getAcceptMimes() : array;
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
    function setAcceptMimes(array $acceptMimes) : void;





    /**
     * Retorna ``true`` caso aplicação deve priorizar o uso do mime ``xhtml``.
     *
     * @return      bool
     */
    function getIsUseXHTML() : bool;
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
    function setIsUseXHTML(bool $isUseXHTML) : void;










    /**
     * Retorna a coleção de nomes de Middlewares que devem ser executados durante o
     * processamento da rota alvo.
     *
     * @return      array
     */
    function getMiddlewares() : array;
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
    function setMiddlewares(array $middlewares) : void;
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
    function addMiddlewares(array $middlewares) : void;










    /**
     * Retorna uma coleção de rotas e/ou URLs que tem relação com esta.
     *
     * @return      array
     */
    function getRelationedRoutes() : array;
    /**
     * Define uma coleção de rotas e/ou URLs que tem relação com esta.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       array $relationedRoutes
     *              Coleção de rotas.
     *
     * @return      void
     */
    function setRelationedRoutes(array $relationedRoutes) : void;





    /**
     * Retorna uma descrição sobre a ação executada por esta rota.
     *
     * @return      string
     */
    function getDescription() : string;
    /**
     * Define uma descrição sobre a ação executada por esta rota.
     * Esta descrição deve ter um teor mais abrangente e não técnico.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $description
     *              Descrição para a rota.
     *
     * @return      void
     */
    function setDescription(string $description) : void;





    /**
     * Retorna uma descrição técnica para a rota.
     * O formato MarkDown pode ser utilizado.
     *
     * @return      string
     */
    function getDevDescription() : string;
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
    function setDevDescription(string $devDescription) : void;





    /**
     * Retorna ``true`` se a rota é protegida pelo sistema de segurança do aplicação.
     *
     * @return      bool
     */
    function getIsSecure() : bool;
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
    function setIsSecure(bool $isSecure) : void;





    /**
     * Retorna ``true`` se a rota possui um conteúdo cacheável.
     *
     * Uma rota definida como segura terá seu sistema de cache desabilitado para toda rota protegida.
     *
     * @return      bool
     */
    function getIsUseCache() : bool;
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
    function setIsUseCache(bool $isUseCache) : void;





    /**
     * Retorna o tempo (em segundos) pelo qual o documento em cache deve ser armazenado até
     * expirar.
     *
     * @return      int
     */
    function getCacheTimeout() : int;
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
    function setCacheTimeout(int $cacheTimeout) : void;





    /**
     * Retorna a coleção de headers a serem enviados na resposta para o ``UA``.
     *
     * @return      array
     */
    function getResponseHeaders() : array;
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
    function setResponseHeaders(array $responseHeaders) : void;
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
    function addResponseHeaders(array $responseHeaders) : void;





    /**
     * Retorna o Mime (extenção) a ser usado para resolver esta rota.
     *
     * @return      string
     */
    function getResponseMime() : string;
    /**
     * Define o Mime (extenção) a ser usado para resolver esta rota.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $mime
     *              Mime (extenção) que será usado.
     *
     * @return      void
     */
    function setResponseMime(string $mime) : void;





    /**
     * Retorna o MimeType (canônico) a ser usado para resolver esta rota.
     *
     * @return      string
     */
    function getResponseMimeType() : string;
    /**
     * Define o MimeType (canônico) a ser usado para resolver esta rota.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $mimeType
     *              MimeType (canônico) que será usado.
     *
     * @return      void
     */
    function setResponseMimeType(string $mimeType) : void;





    /**
     * Retorna o Locale a ser usado para resolver esta rota.
     *
     * @return      string
     */
    function getResponseLocale() : string;
    /**
     * Define o Locale a ser usado para resolver esta rota.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $locale
     *              Locale que será usado.
     *
     * @return      void
     */
    function setResponseLocale(string $locale) : void;





    /**
     * Quando ``true`` indica que o código de retorno deve passar por algum tratamento que
     * facilite a leitura do mesmo por humanos.
     *
     * @return      bool
     */
    function getResponseIsPrettyPrint() : bool;
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
    function setResponseIsPrettyPrint(bool $isPrettyPrint) : void;





    /**
     * Retorna ``true`` se o resultado da execução da rota deve ser uma resposta em formato de
     * download.
     *
     * @return      bool
     */
    function getResponseIsDownload() : bool;
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
    function setResponseIsDownload(bool $isDownload) : void;





    /**
     * Retorna o nome do documento que deve ser devolvido ao efetuar o download da rota.
     * Se nenhum nome for definido de forma explicita, este valor será criado a partir do nome da
     * rota principal.
     *
     * @return      string
     */
    function getResponseDownloadFileName() : string;
    /**
     * Define o nome do documento que deve ser devolvido ao efetuar o download da rota.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       string $downloadFileName
     *              Nome do arquivo que será enviado ao UA como um download.
     *
     * @return      void
     */
    function setResponseDownloadFileName(string $downloadFileName) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até a master page que será
     * utilizada.
     *
     * @return      string
     */
    function getMasterPage() : string;
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até a master page que será
     * utilizada.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       string $masterPage
     *              Caminho relativo até a master page.
     *
     * @return      void
     */
    function setMasterPage(string $masterPage) : void;





    /**
     * Retorna o caminho relativo (a partir do diretório definido para as views) até a view
     * que será utilizada.
     *
     * @return      string
     */
    function getView() : string;
    /**
     * Define o caminho relativo (a partir do diretório definido para as views) até a view
     * que será utilizada.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       string $view
     *              Caminho relativo até a view.
     *
     * @return      void
     */
    function setView(string $view) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até um arquivo de formulário
     * que esteja sendo utilizado pela rota.
     *
     * @return      string
     */
    function getForm() : string;
    /**
     * Define o caminho relativo (a partir de ``appRootPath``) até um arquivo de formulário
     * que esteja sendo utilizado pela rota.
     *
     * Deve ser definido **ANTES** de iniciar o processamento da rota.
     *
     * @param       string $form
     *              Caminho relativo até o arquivo que define o formulário alvo.
     *
     * @return      void
     */
    function setForm(string $form) : void;



    /**
     * Retorna uma coleção de caminhos até as folhas de estilos que devem ser incorporadas no
     * documento final (caso trate-se de um formato que aceita este tipo de recurso).
     *
     * @return      array
     */
    function getStyleSheets() : array;
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
    function setStyleSheets(array $styleSheets) : void;
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
    function addStyleSheets(array $styleSheets) : void;





    /**
     * Retorna uma coleção de caminhos até as scripts que devem ser incorporadas no documento
     * final (caso trate-se de um formato que aceita este tipo de recurso).
     *
     * @return      array
     */
    function getJavaScripts() : array;
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
    function setJavaScripts(array $javaScripts) : void;
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
    function addJavaScripts(array $javaScripts) : void;





    /**
     * Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
     * que será usado para responder a requisição.
     *
     * @return      string
     */
    function getLocaleDictionary() : string;
    /*
     * Define o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do
     * locale que será usado para responder a requisição.
     *
     * Pode ser redefinido durante o processamento da rota.
     *
     * @param       string $localeDictionary
     *              Caminho relativo até o arquivo de legendas.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function setLocaleDictionary(string $localeDictionary) : void;





    /**
     * Retorna a coleção de metadados a serem incorporados nas views ``X/HTML``.
     *
     * @return      array
     */
    function getMetaData() : array;
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
    function setMetaData(array $metaData) : void;
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
    function addMetaData(array $metaData) : void;





    /**
     * Retorna o nome do método que deve ser executado na classe da Aplicação para resolver a rota.
     * Se não for definido deve retornar ``run`` como valor padrão.
     *
     * @return      string
     */
    function getRunMethodName() : string;
    /*
     * Permite definir o nome de um metodo alternativo para resolver o resultado do processamento
     * da rota.
     *
     * @param       string $runMethodName
     *              Nome do método a ser executado.
     *
     * @return      void
     */
    function setRunMethodName(string $runMethodName) : void;





    /**
     * Resgata um array associativo contendo propriedades customizadas para o processamento
     * da rota.
     *
     * @return      array
     */
    function getCustomProperties() : array;
    /**
     * Define uma coleção de propriedades customizadas para o processamento da rota.
     *
     * @param       array $customProperties
     *              Array associativo contendo as informações customizadas.
     *
     * @return      void
     */
    function setCustomProperties(array $customProperties) : void;










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
     * @return      string
     */
    function negotiateLocale(
        ?array $requestLocales,
        ?array $requestLanguages,
        ?array $applicationLocales,
        ?string $defaultLocale,
        ?string $forceLocale
    ) : string;



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
     * @return      array
     * ``` php
     *  $arr = [
     *      "valid"     bool    Indica se o mimetype encontrado é válido para ser usado em um response
     *      "mime"      string  Extenção que identifica o tipo de documento referente ao mimetype selecionado.
     *      "mimetype"  string  Nome canonico do mimetype selecionado.
     *  ];
     * ```
     */
    function negotiateMimeType(
        ?array $requestMimes,
        ?string $forceMime
    ) : array;





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
    function setValues($cfg) : void;





    /**
     * Converte as propriedades definidas neste objeto para um array associativo e retorna-o.
     *
     * @return      array
     */
    function toArray() : array;





    /**
     * Retorna um array associativo contendo as propriedades que atuam diretamente na
     * configuração da construção da view.
     *
     * @return      array
     */
    function getActionAttributes() : array;





    /**
     * A partir da execução deste método apenas as propriedades que podem ser alteradas
     * **DURANTE** a action é que poderão ser alteradas.
     *
     * Na implementação da classe não deve existir forma de retornar este estado. Ou seja, uma
     * vez que o bloqueio seja ativado nada pode removê-lo.
     *
     * @return      void
     */
    function lockProperties() : void;
}
