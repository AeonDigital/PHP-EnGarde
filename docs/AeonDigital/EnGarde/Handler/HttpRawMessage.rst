.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HttpRawMessage
==============


.. php:namespace:: AeonDigital\EnGarde\Handler

.. php:class:: HttpRawMessage


	.. rst-class:: phpdoc-description
	
		| Classe que implementa métodos que servem a função de envio de mensagens ``Http``
		| para o UA de forma simplificada.
		
	
	:Used traits:
		:php:trait:`AeonDigital\Http\Traits\HttpRawStatusCode` 
	

Properties
----------

Methods
-------

.. rst-class:: public static

	.. php:method:: public static setContext( $rootPath, $environmentType, $isDebugMode, $protocol, $method, $pathToErrorView=&#34;&#34;, $pathToHttpMessageView=&#34;&#34;)
	
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
			  Protocolo ``Http/Https``.
			- ‹ string › **$method** |br|
			  Método ``Http`` usado.
			- ‹ string › **$pathToErrorView** |br|
			  Caminho completo até a view de erros
			- ‹ string › **$pathToHttpMessageView** |br|
			  Caminho completo até a view de mensagem.

		
	
	

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
		
			| Define o caminho completo até a view que deve ser enviada ao
			| UA em caso de erros.
			
		
		
		:Parameters:
			- ‹ string › **$pathToErrorView** |br|
			  Caminho completo até a view.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static setPathToHttpMessageView( $pathToHttpMessageView=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Define o caminho completo até a view que deve ser enviada ao
			| UA em caso de mensagens ``Http`` simples.
			
		
		
		:Parameters:
			
			
		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static onException( $ex)
	
		.. rst-class:: phpdoc-description
		
			| Manipulador padrão para as exceptions.
			
		
		
		:Parameters:
			- ‹ Exception › **$ex** |br|
			  Exception capturada.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static onError( $errorCode, $errorMessage, $errorFile, $errorLine)
	
		.. rst-class:: phpdoc-description
		
			| Manipulador padrão para os erros.
			
		
		
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

	.. php:method:: public static throwHttpError( $code, $reasonPhrase=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Lança um erro ``Http`` de forma explicita.
			
			| Este tipo de erro não apresenta informações além do código ``Http`` e da ``reason phrase``
			| definidos e não tem como função ajudar a debugar a aplicação.
			| 
			| Deve ser usado quando o desenvolvedor deseja lançar uma falha explicita para o ``UA``.
			
		
		
		:Parameters:
			- ‹ int › **$code** |br|
			  Código ``Http``.
			- ‹ string › **$reasonPhrase** |br|
			  Frase razão para o erro.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static throwHttpMessage( $code, $reasonPhrase=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Envia para o UA uma mensagem Http básica (código ``Http`` e ``reason phrase``).
			
		
		
		:Parameters:
			- ‹ int › **$code** |br|
			  Código ``Http``.
			- ‹ string › **$reasonPhrase** |br|
			  Frase razão para o erro.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

