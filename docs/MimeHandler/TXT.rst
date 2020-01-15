.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TXT
===


.. php:namespace:: AeonDigital\EnGarde\MimeHandler

.. php:class:: TXT


	.. rst-class:: phpdoc-description
	
		| Manipulador para gerar documentos TXT.
		
	
	:Parent:
		:php:class:`AeonDigital\\EnGarde\\MimeHandler\\aMimeHandler`
	

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $serverConfig, $domainConfig, $applicationConfig, $serverRequest, $rawRouteConfig, $routeConfig, $response)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma nova instância.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Config\\Interfaces\\iServerConfig › **$serverConfig** |br|
			  Instância ``iServerConfig``.
			- ‹ AeonDigital\\EnGarde\\Config\\Interfaces\\iDomainConfig › **$domainConfig** |br|
			  Instância ``iDomainConfig``.
			- ‹ AeonDigital\\EnGarde\\Config\\Interfaces\\iApplicationConfig › **$applicationConfig** |br|
			  Instância ``iApplicationConfig``.
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iServerRequest › **$serverRequest** |br|
			  Instância ``iServerRequest``.
			- ‹ array › **$rawRouteConfig** |br|
			  Instância ``iServerConfig``.
			- ‹ AeonDigital\\EnGarde\\Config\\Interfaces\\iRouteConfig › **$routeConfig** |br|
			  Instância ``iRouteConfig``.
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iResponse › **$response** |br|
			  Instância ``iResponse``.

		
	
	

.. rst-class:: public

	.. php:method:: public createResponseBody()
	
		.. rst-class:: phpdoc-description
		
			| Gera uma string que representa a resposta a ser enviada para o ``UA``, compatível com o
			| mimetype que esta classe está apta a manipular.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

