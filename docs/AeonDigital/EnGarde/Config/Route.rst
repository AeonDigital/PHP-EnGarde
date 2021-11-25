.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Route
=====


.. php:namespace:: AeonDigital\EnGarde\Config

.. rst-class::  final

.. php:class:: Route


	.. rst-class:: phpdoc-description
	
		| Implementação de ``Config\iRoute``.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\Config\\iRoute` 
	
	:Used traits:
		:php:trait:`AeonDigital\Http\Traits\MimeTypeData` :php:trait:`AeonDigital\Traits\MainCheckArgumentException` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getApplication()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome da aplicação que está sendo executada.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getNamespace()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a namespace completa do controller que está respondendo a requisição.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getController()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome do controller que possui a action que deve resolver a rota.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getControllerNamespace()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a namespace completa do controller que deve responder a esta
			| requisição.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getResourceId()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o Id do recurso que esta rota representa.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAction()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome da action que resolve a rota.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAllowedMethods()
	
		.. rst-class:: phpdoc-description
		
			| Retorna os métodos ``Http`` que podem ser usados para esta mesma rota.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAllowedMimeTypes()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array associativo contendo a coleção de mimetypes que esta rota é capaz de
			| devolver como resposta.
			
			| Esperado array associativo onde as chaves devem ser os valores abreviados (mime) e os
			| valores correspondem ao nome completo do (mimetype).
			| 
			| Ex:
			| \`\`\`
			|  [ &#34;txt&#34; => &#34;text/plain&#34;, &#34;xhtml&#34; => &#34;application/xhtml+xml&#34; ]
			| \`\`\`
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getMethod()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o método ``Http`` que está sendo usado para evocar esta rota.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRoutes()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array contendo todas as rotas que respondem a esta mesma configuração.
			
			| As rotas devem sempre ser definidas de forma relativa à raiz (começando com &#34;/&#34;).
			| Nesta coleção, o nome da aplicação não deverá estar presente pois deve replicar o padrão
			| definido nos controllers.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getActiveRoute( $withApplicationName=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna a rota base que está sendo utilizada.
			
		
		
		:Parameters:
			- ‹ bool › **$withApplicationName** |br|
			  Quando ``true`` irá adicionar o nome da aplicação atual na primeira
			  partícula da rota em si.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsUseXHTML()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` caso aplicação deve priorizar o uso do mime ``xhtml`` sobre o ``html``.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRunMethodName()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome do método que deve ser executado na classe da Aplicação para resolver a rota.
			
			| Se não for definido deve retornar ``run`` como valor padrão.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getCustomProperties()
	
		.. rst-class:: phpdoc-description
		
			| Resgata um array associativo contendo propriedades customizadas para o processamento
			| da rota.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsAutoLog()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` caso a atividade desta rota deva ser registrada no log do sistema.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDescription()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma descrição sobre a ação executada por esta rota.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDevDescription()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma descrição técnica para a rota.
			
			| O formato MarkDown pode ser utilizado.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRelationedRoutes()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de rotas e/ou URLs que tem relação com esta.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getMiddlewares()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a coleção de nomes de Middlewares que devem ser executados durante o
			| processamento da rota alvo.
			
			| Cada item do array refere-se a um método existente na classe da aplicação que retorna uma
			| instância do Middleware alvo.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsSecure()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se a rota deve ser protegida pelo sistema de segurança da aplicação.
			
			| Uma rota definida como segura DEVE ter o sistema de cache desabilitado.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsUseCache()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se a rota possui um conteúdo cacheável.
			
			| Apenas retornará ``true`` se, alem de definido assim a propriedade ``cacheTimeout`` for
			| maior que zero, ``isSecure`` for ``false`` e o método que está sendo usado para responder
			| ao ``UA`` for ``HEAD`` ou ``GET``.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getCacheTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o tempo (em minutos) pelo qual o documento em cache deve ser armazenado até
			| expirar.
			
			| Um valor igual a ``0`` indica que o armazenamento não deve ser feito (tal qual se o sistema
			| de cache estivesse desativado).
			| 
			| Não deve existir uma forma de cache infinito.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseLocale()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o Locale a ser usado para resolver esta rota.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseMime()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o Mime (extenção) a ser usado para resolver esta rota.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseMimeType()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o MimeType (canônico) a ser usado para resolver esta rota.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseIsPrettyPrint()
	
		.. rst-class:: phpdoc-description
		
			| Quando ``true`` indica que o código de retorno deve passar por algum tratamento que
			| facilite a leitura do mesmo por humanos.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseIsDownload()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se o resultado da execução da rota deve ser uma resposta em formato de
			| download.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setResponseIsDownload( $responseIsDownload)
	
		.. rst-class:: phpdoc-description
		
			| Define se o resultado da execução da rota deve ser uma resposta em formato de download.
			
		
		
		:Parameters:
			- ‹ bool › **$responseIsDownload** |br|
			  Use ``true`` para definir que o resultado a ser submetido ao UA é um download.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public negotiateLocale( $requestLocales, $requestLanguages, $applicationLocales, $defaultLocale, $forceLocale)
	
		.. rst-class:: phpdoc-description
		
			| Processa a negociação de conteúdo para identificar qual locale deve ser usado para
			| responder a esta rota.
			
			| Esta ação deve ser executada ANTES do processamento da rota para que tal resultado
			| seja conhecido durante sua execução.
			| 
			| Irá preencher o valor que deve ser retornado em ``$this->getResponseLocale()``.
			
		
		
		:Parameters:
			- ‹ ?array › **$requestLocales** |br|
			  Coleção de Locales que o ``UA`` explicitou preferência.
			- ‹ ?array › **$requestLanguages** |br|
			  Coleção de linguagens em que o ``UA`` explicitou preferência.
			- ‹ ?array › **$applicationLocales** |br|
			  Coleção de locales usados pela Aplicação.
			- ‹ ?string › **$defaultLocale** |br|
			  Locale padrão da Aplicação.
			- ‹ ?string › **$forceLocale** |br|
			  Locale que terá prioridade sobre os demais podendo inclusive ser um que a
			  aplicação não esteja apta a servir.

		
		:Returns: ‹ bool ›|br|
			  Retorna ``true`` caso tenha sido possível identificar o locale a ser usado.
		
	
	

.. rst-class:: public

	.. php:method:: public negotiateMimeType( $requestMimes, $forceMime)
	
		.. rst-class:: phpdoc-description
		
			| Processa a negociação de conteúdo para identificar qual mimetype deve ser usado para
			| responder a esta rota.
			
			| Esta ação deve ser executada ANTES do processamento da rota para que tal resultado
			| seja conhecido durante sua execução.
			| 
			| Irá preencher os valores que devem ser retornados nos métodos ``$this->getResponseMime()``
			| e ``$this->getResponseMimeType()``.
			
		
		
		:Parameters:
			- ‹ ?array › **$requestMimes** |br|
			  Coleção de mimeTypes que o ``UA`` explicitou preferência.
			- ‹ ?string › **$forceMime** |br|
			  Mime que terá prioridade sobre os demais podendo inclusive ser um que a rota
			  não esteja apta a utilizar.

		
		:Returns: ‹ bool ›|br|
			  Retorna ``true`` caso tenha sido possível identificar o mimetype a ser usado.
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseDownloadFileName()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome do documento que deve ser devolvido ao efetuar o download da rota.
			
			| Se nenhum nome for definido de forma explicita, este valor será criado a partir do nome da
			| rota principal.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setResponseDownloadFileName( $responseDownloadFileName)
	
		.. rst-class:: phpdoc-description
		
			| Define o nome do documento que deve ser devolvido ao efetuar o download da rota.
			
		
		
		:Parameters:
			- ‹ string › **$responseDownloadFileName** |br|
			  Nome do arquivo que será enviado ao UA como um download.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseHeaders()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a coleção de headers a serem enviados na resposta para o ``UA``.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setResponseHeaders( $responseHeaders)
	
		.. rst-class:: phpdoc-description
		
			| Define uma coleção de headers a serem enviados na resposta para o ``UA``.
			
			| As chaves de valores informadas devem ser tratadas em ``case-insensitive``.
			
		
		
		:Parameters:
			- ‹ array › **$responseHeaders** |br|
			  Array associativo [key => value] contendo a coleção de headers a serem
			  enviados ao ``UA``.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public addResponseHeaders( $responseHeaders)
	
		.. rst-class:: phpdoc-description
		
			| Adiciona novos itens na coleção de headers.
			
		
		
		:Parameters:
			- ‹ array › **$responseHeaders** |br|
			  Array associativo [key => value] contendo a coleção de headers a serem
			  enviados ao ``UA``.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getMasterPage()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até a master page que será
			| utilizada.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setMasterPage( $masterPage)
	
		.. rst-class:: phpdoc-description
		
			| Define o caminho relativo (a partir de ``appRootPath``) até a master page que será
			| utilizada.
			
		
		
		:Parameters:
			- ‹ string › **$masterPage** |br|
			  Caminho relativo até a master page.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getView()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir do diretório definido para as views) até a view
			| que será utilizada.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setView( $view)
	
		.. rst-class:: phpdoc-description
		
			| Define o caminho relativo (a partir do diretório definido para as views) até a view
			| que será utilizada.
			
		
		
		:Parameters:
			- ‹ string › **$view** |br|
			  Caminho relativo até a view.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getStyleSheets()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de caminhos até as folhas de estilos que devem ser incorporadas no
			| documento final (caso trate-se de um formato que aceita este tipo de recurso).
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setStyleSheets( $styleSheets)
	
		.. rst-class:: phpdoc-description
		
			| Redefine toda coleção de caminhos até as folhas de estilos que devem ser incorporadas no
			| documento final (caso trate-se de um formato que aceita este tipo de recurso.)
			
			| Os caminhos dos CSSs devem ser relativos e iniciando a partir do diretório destinado
			| aos recursos HTML definidos em ``iApplicationConfig->getPathToViewsResources();``.
			
		
		
		:Parameters:
			- ‹ array › **$styleSheets** |br|
			  Coleção de folhas de estilos.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public addStyleSheets( $styleSheets)
	
		.. rst-class:: phpdoc-description
		
			| Adiciona novas folhas de estilo na coleção existente.
			
			| Os caminhos dos CSSs devem ser relativos e iniciando a partir do diretório destinado aos
			| recursos HTML definidos em ``iApplicationConfig->getPathToViewsResources();``.
			
		
		
		:Parameters:
			- ‹ array › **$styleSheets** |br|
			  Coleção de folhas de estilo a serem adicionadas na lista atual.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getJavaScripts()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de caminhos até as scripts que devem ser incorporadas no documento
			| final (caso trate-se de um formato que aceita este tipo de recurso).
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setJavaScripts( $javaScripts)
	
		.. rst-class:: phpdoc-description
		
			| Redefine toda coleção de caminhos até as scripts que devem ser incorporadas no documento
			| final (caso trate-se de um formato que aceita este tipo de recurso.)
			
			| Os caminhos dos scripts devem ser relativos e iniciando a partir do diretório destinado aos
			| recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
			
		
		
		:Parameters:
			- ‹ array › **$javaScripts** |br|
			  Coleção de scripts.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public addJavaScripts( $javaScripts)
	
		.. rst-class:: phpdoc-description
		
			| Adiciona novos scripts na coleção existente.
			
			| Os caminhos dos scripts devem ser relativos e iniciando a partir do diretório destinado aos
			| recursos HTML definidos em ``iApplicationConfig->setPathToViewsResources();``.
			
		
		
		:Parameters:
			- ‹ array › **$javaScripts** |br|
			  Coleção de scripts a serem adicionadas na lista atual.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getMetaData()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a coleção de metadados a serem incorporados nas views ``X/HTML``.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setMetaData( $metaData)
	
		.. rst-class:: phpdoc-description
		
			| Redefinr a coleção de metadados a serem incorporados nas views ``X/HTML``.
			
			| As chaves de valores informadas devem ser tratadas em ``case-insensitive``.
			
		
		
		:Parameters:
			- ‹ array › **$metaData** |br|
			  Array associativo [key => value] contendo a coleção de itens a serem adicionados
			  na tag <head> em formato <meta name=&#34;key&#34; content=&#34;value&#34; />

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public addMetaData( $metaData)
	
		.. rst-class:: phpdoc-description
		
			| Adiciona novos itens na coleção existente.
			
		
		
		:Parameters:
			- ‹ array › **$metaData** |br|
			  Array associativo [key => value] contendo a coleção de itens a serem adicionados
			  na tag <head> em formato <meta name=&#34;key&#34; content=&#34;value&#34; />

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAppStage()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a etapa em que a aplicação se encontra.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setAppStage( $appStage)
	
		.. rst-class:: phpdoc-description
		
			| Define a etapa em que a aplicação se encontra.
			
			| Esta propriedade permite configurar elementos X/HTML para apresentar ou não na tela
			| apenas aqueles que pertencem a etapa definida para esta rota.
			
		
		
		:Parameters:
			- ‹ string › **$appStage** |br|
			  etapa atual da aplicação.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getLocaleDictionary()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
			| que será usado para responder a requisição.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setLocaleDictionary( $localeDictionary)
	
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $application, $namespace, $controller, $resourceId, $action, $allowedMethods, $allowedMimeTypes, $method, $routes, $activeRoute, $isUseXHTML, $runMethodName, $customProperties, $isAutoLog, $description, $devDescription, $relationedRoutes, $middlewares, $isSecure, $isUseCache, $cacheTimeout, $responseIsPrettyPrint=false, $responseIsDownload=false, $responseDownloadFileName=&#34;&#34;, $responseHeaders=[], $masterPage=&#34;&#34;, $view=&#34;&#34;, $styleSheets=[], $javaScripts=[], $metaData=[], $appStage, $localeDictionary=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma instância de configuração para a rota.
			
		
		
		:Parameters:
			- ‹ string › **$application** |br|
			  Obrigatório. Nome da aplicação que está sendo executada.
			- ‹ string › **$namespace** |br|
			  Obrigatório. Namespace completa do controller que está respondendo a requisição.
			- ‹ string › **$controller** |br|
			  Obrigatório. Nome do controller que possui a action que deve resolver a rota.
			- ‹ string › **$resourceId** |br|
			  Obrigatório. Id do recurso que a rota representa.
			- ‹ string › **$action** |br|
			  Obrigatório. Nome da action que resolve a rota.
			- ‹ array › **$allowedMethods** |br|
			  Obrigatório. Métodos ``Http`` que podem ser usados para esta mesma rota.
			- ‹ array › **$allowedMimeTypes** |br|
			  Obrigatório. Array contendo a coleção de mimetypes que esta rota é capaz de
			  devolver como resposta.
			- ‹ string › **$method** |br|
			  Obrigatório. Método ``Http`` que está sendo usado para evocar esta rota.
			- ‹ array › **$routes** |br|
			  Obrigatório. Coleção de rotas que correspondem a esta mesma configuração.
			- ‹ string › **$activeRoute** |br|
			  Obrigatório. Rota base que está sendo resolvida.
			- ‹ bool › **$isUseXHTML** |br|
			  Indica se a aplicação deve priorizar o uso do mime ``xhtml`` sobre o ``html``.
			- ‹ string › **$runMethodName** |br|
			  Nome do método que deve ser executado na classe da Aplicação para resolver a rota.
			- ‹ array › **$customProperties** |br|
			  Coleção de propriedades customizadas da rota.
			- ‹ bool › **$isAutoLog** |br|
			  Indica se esta rota deve ter suas atividades registradas pelo sistema nativo de log.
			- ‹ string › **$description** |br|
			  Descrição sobre a ação executada por esta rota.
			- ‹ string › **$devDescription** |br|
			  Descrição técnica para a rota.
			- ‹ array › **$relationedRoutes** |br|
			  Coleção de rotas e/ou URLs que tem relação com esta.
			- ‹ array › **$middlewares** |br|
			  Coleção de nomes de Middlewares que devem ser executados durante o
			  processamento da rota alvo.
			- ‹ bool › **$isSecure** |br|
			  Indica se a rota deve ser protegida pelo sistema de segurança da aplicação.
			- ‹ bool › **$isUseCache** |br|
			  Indica se a rota possui um conteúdo cacheável.
			- ‹ int › **$cacheTimeout** |br|
			  Tempo (em minutos) pelo qual o documento em cache deve ser armazenado até
			  expirar.
			- ‹ bool › **$responseIsPrettyPrint** |br|
			  Indica quando o código de retorno deve ser tratado para facilitar a leitura por humanos.
			- ‹ bool › **$responseIsDownload** |br|
			  Indica se o resultado da execução da rota deve ser um download.
			- ‹ string › **$responseDownloadFileName** |br|
			  Nome do documento enviado por download.
			- ‹ array › **$responseHeaders** |br|
			  Coleção de headers a serem enviados para o ``UA``.
			- ‹ string › **$masterPage** |br|
			  Caminho relativo (a partir de ``appRootPath``) até a master page que será utilizada.
			- ‹ string › **$view** |br|
			  Caminho relativo (a partir do diretório definido para as views) até a view que será utilizada.
			- ‹ array › **$styleSheets** |br|
			  Coleção de folhas de estilo que devem ser vinculados na view.
			- ‹ array › **$javaScripts** |br|
			  Coleção de scripts que devem ser vinculados na view.
			- ‹ array › **$metaData** |br|
			  Coleção de metadados a serem incorporados na view X/HTML.
			- ‹ string › **$appStage** |br|
			  Nome da etapa em que a aplicação se encontra no momento.
			- ‹ string › **$localeDictionary** |br|
			  Caminho relativo (a partir de ``appRootPath``) até o arquivo de legendas do locale
			  que será usado para responder a requisição.

		
	
	

.. rst-class:: public static

	.. php:method:: public static fromArray( $config)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma instância configurada a partir de um array que contenha
			| as chaves correlacionadas a cada propriedade aqui definida.
			
		
		
		:Parameters:
			- ‹ array › **$config** |br|
			  Array associativo contendo os valores a serem definidos para a instância.

		
		:Returns: ‹ \\AeonDigital\\EnGarde\\Interfaces\\Config\\iRoute ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public toArray()
	
		.. rst-class:: phpdoc-description
		
			| Converte as propriedades definidas neste objeto para um ``array associativo``.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

