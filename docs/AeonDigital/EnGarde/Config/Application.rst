.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Application
===========


.. php:namespace:: AeonDigital\EnGarde\Config

.. rst-class::  final

.. php:class:: Application


	.. rst-class:: phpdoc-description
	
		| Implementação de ``Config\iApplication``.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\Config\\iApplication` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MainCheckArgumentException` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getAppName()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome da aplicação.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAppRootPath()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho completo até o diretório raiz da aplicação.
			
			| Todas as demais configurações que indicam diretórios ou arquivos usando caminhos
			| relativos iniciam a partir deste diretório.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToAppRoutes( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até o arquivo de rotas da aplicação.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToControllers( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de controllers
			| da aplicação.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToViews( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório das views
			| da aplicação.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToViewsResources( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
			| armazenados os recursos para as views (imagens, JS, CSS ...).
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToLocales( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório que estarão
			| armazenados os documentos de configuração das legendas.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToCacheFiles( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de armazenamento
			| para os arquivos de cache.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToLocalData( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho relativo (a partir de ``appRootPath``) até o diretório de armazenamento
			| para os arquivos de dados que constituem uma *base de dados local*.
			
			| O formato e conteúdo destes arquivos varia conforme a implementação realizada.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getStartRoute()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a rota inicial da aplicação.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getControllersNamespace()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a Namespace comum à todos os controllers da aplicação corrente.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getLocales()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a coleção de locales suportada pela aplicação.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDefaultLocale()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o locale padrão para a aplicação corrente.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsUseLabels()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se a aplicação deve usar o sistema de legendas.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDefaultRouteConfig()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array associativo contendo os valores padrões para as rotas de toda a
			| aplicação. Estes valores podem ser sobrescritos pelas definições padrões dos controllers
			| e das próprias rotas.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getCheckRouteOrder()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array de strings contendo em cada posição um dos diferentes métodos de obter
			| a rota a ser executada segundo a requisição atual.
			
			| Ao iniciar a aplicação, a ordem dos métodos aqui definidos será usado para identificar qual
			| processo deve ser realizado a cada requisição.
			| 
			| Nesta implementação, são esperados os valores :
			| - &#34;native&#34;   : Verificação baseada na lista de rotas definidas nos controllers.
			| - &#34;catch-all&#34;: Regra especial &#34;catchAll&#34; que pode ser definida pelo desenvolvedor de cada aplicação.
			| - &#34;redirect&#34; : Regras de redirecionamentos.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToErrorView( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros
			| na aplicação.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToHttpMessageView( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de necessidade
			| de envio de uma simples mensagem ``Http``.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getHttpSubSystemNamespaces()
	
		.. rst-class:: phpdoc-description
		
			| Resgata um array associativo contendo a correlação entre os métodos ``Http``
			| e suas respectivas classes de resolução.
			
			| Tais classes serão usadas exclusivamente para resolver os métodos ``Http`` que
			| originalmente devem ser processados pelo framework.
			| 
			| Originalmente estes:
			| &#34;HEAD&#34;, &#34;OPTIONS&#34;, &#34;TRACE&#34;, &#34;DEV&#34;, &#34;CONNECT&#34;
			| 
			| \`\`\`
			| // ex:
			| $arr = [
			|  &#34;HEAD&#34;  => &#34;full\\qualified\\namespace\\classnameHead&#34;,
			|  &#34;DEV&#34;   => &#34;full\\qualified\\namespace\\classnameDEV&#34;
			| ]
			| \`\`\`
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $appName, $appRootPath, $pathToAppRoutes, $pathToControllers, $pathToViews, $pathToViewsResources, $pathToLocales, $pathToCacheFiles, $pathToLocalData, $startRoute, $controllersNamespace, $locales, $defaultLocale, $isUseLabels, $defaultRouteConfig, $checkRouteOrder, $pathToErrorView, $pathToHttpMessageView, $httpSubSystemNamespaces)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma nova instância de configurações para a aplicação.
			
		
		
		:Parameters:
			- ‹ string › **$appName** |br|
			  Nome da aplicação.
			- ‹ string › **$appRootPath** |br|
			  Caminho completo até o diretório raiz da aplicação.
			- ‹ string › **$pathToAppRoutes** |br|
			  Caminho relativo (a partir de &#34;appRootPath&#34;) até o arquivo de rotas da
			  aplicação.
			- ‹ string › **$pathToControllers** |br|
			  Caminho relativo (a partir de &#34;appRootPath&#34;) até o diretório de controllers
			  da aplicação.
			- ‹ string › **$pathToViews** |br|
			  Caminho relativo (a partir de &#34;appRootPath&#34;) até o diretório das views da
			  aplicação.
			- ‹ string › **$pathToViewsResources** |br|
			  Caminho relativo (a partir de ``appRootPath``) até o diretório de recursos
			  para as views (imagens, JS, CSS ...).
			- ‹ string › **$pathToLocales** |br|
			  Caminho relativo (a partir de &#34;appRootPath&#34;) até o diretório que estarão
			  armazenados os documentos de configuração das legendas.
			- ‹ string › **$pathToCacheFiles** |br|
			  Caminho relativo (a partir de &#34;appRootPath&#34;) até o diretório de armazenamento
			  para os arquivos de cache.
			- ‹ string › **$pathToLocalData** |br|
			  Caminho relativo (a partir de ``appRootPath``) até o diretório de armazenamento
			  para os arquivos de dados locais.
			- ‹ string › **$startRoute** |br|
			  Rota inicial da aplicação.
			- ‹ string › **$controllersNamespace** |br|
			  Namespace para os controllers da aplicação.
			- ‹ array › **$locales** |br|
			  Coleção de locales suportada pela aplicação.
			- ‹ string › **$defaultLocale** |br|
			  Locale padrão para a aplicação corrente.
			- ‹ bool › **$isUseLabels** |br|
			  Indica se deve ser usado o sistema de legendas.
			- ‹ array › **$defaultRouteConfig** |br|
			  Array associativo contendo os valores padrões para as rotas da aplicação.
			- ‹ array › **$checkRouteOrder** |br|
			  Array de métodos de identificação de processamento de rotas.
			- ‹ string › **$pathToErrorView** |br|
			  Caminho relativo até a view que deve ser enviada ao UA em caso de erros
			  na aplicação.
			- ‹ string › **$pathToHttpMessageView** |br|
			  Caminho relativo até a view que deve ser enviada ao ``UA`` em caso de necessidade
			  de envio de uma simples mensagem ``Http``.
			- ‹ array › **$httpSubSystemNamespaces** |br|
			  Coleção de métodos ``Http`` que devem ser resolvidos pelo framework e as
			  respectivas classes que devem resolver cada qual.

		
		:Returns: ‹ void ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido.
		
	
	

.. rst-class:: public static

	.. php:method:: public static fromArray( $config)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma nova instância ``Config\iApplication``.
			
		
		
		:Parameters:
			- ‹ array › **$config** |br|
			  Array associativo contendo as configurações para esta instância.

		
		:Returns: ‹ \\AeonDigital\\EnGarde\\Interfaces\\Config\\iApplication ›|br|
			  
		
	
	

