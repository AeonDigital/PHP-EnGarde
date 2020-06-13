.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ErrorListening
==============


.. php:namespace:: AeonDigital\EnGarde\Handler

.. php:class:: ErrorListening


	.. rst-class:: phpdoc-description
	
		| Classe a ser usada para permitir configurar o tratamento de erros ocorridos em runtime.
		
	
	:Used traits:
		:php:trait:`AeonDigital\Http\Traits\HTTPRawStatusCode` 
	

Properties
----------

Methods
-------

.. rst-class:: public static

	.. php:method:: public static setContext( $rootPath, $environmentType, $isDebugMode, $protocol, $method, $pathToErrorView=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Define o contexto do ambiente carregando as propriedades básicas da instância.
			
		
		
		:Parameters:
			- ‹ string › **$rootPath** |br|
			  Caminho até o diretório raiz do domínio.
			- ‹ string › **$environmentType** |br|
			  Tipo de ambiente que o domínio está rodando no momento.
			- ‹ bool › **$isDebugMode** |br|
			  Indica se o domínio está em modo de debug.
			- ‹ string › **$protocol** |br|
			  Protocolo HTTP/HTTPS.
			- ‹ string › **$method** |br|
			  Método HTTP usado.
			- ‹ string › **$pathToErrorView** |br|
			  Caminho completo até a view de erros

		
	
	

.. rst-class:: public static

	.. php:method:: public static getContext()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array associativo contendo o valor das variáveis do contexto atual.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static clearContext()
	
		.. rst-class:: phpdoc-description
		
			| Elimina totalmente todos os valores das propriedades de contexto.
			
			| Este método apenas surte efeito se o ambiente onde está rodando estiver definido como ``test``.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static setPathToErrorView( $pathToErrorView=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Define o caminho completo até a view que deve ser enviada ao ``UA`` em caso de erros no
			| domínio.
			
		
		
		:Parameters:
			- ‹ string › **$pathToErrorView** |br|
			  Caminho até a view de erro padrão.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static onException( $ex)
	
		.. rst-class:: phpdoc-description
		
			| Manipulador padrão para as exceptions ocorridas.
			
		
		
		:Parameters:
			- ‹ Exception › **$ex** |br|
			  Exception capturada.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static onError( $errorCode, $errorMessage, $errorFile, $errorLine)
	
		.. rst-class:: phpdoc-description
		
			| Manipulador padrão para os erros ocorridos.
			
		
		
		:Parameters:
			- ‹ int › **$errorCode** |br|
			  Código do erro que aconteceu.
			- ‹ string › **$errorMessage** |br|
			  Mensagem de erro.
			- ‹ string › **$errorFile** |br|
			  Arquivo onde o erro ocorreu.
			- ‹ int › **$errorLine** |br|
			  Número da linha onde ocorreu a falha.

		
		:Returns: ‹ \\AeonDigital\\EnGarde\\Handler\\stdClass | void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static throwHTTPError( $code, $reasonPhrase=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Lança um erro ``HTTP`` de forma explicita.
			
			| Este tipo de erro não apresenta informações além do código ``HTTP`` e da ``reason phrase``
			| definidos e não tem como função ajudar a debugar a aplicação.
			| 
			| Deve ser usado quando o desenvolvedor deseja lançar uma falha explicita para o ``UA``.
			
		
		
		:Parameters:
			- ‹ int › **$code** |br|
			  Código ``HTTP``.
			- ‹ string › **$reasonPhrase** |br|
			  Frase razão para o erro.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

