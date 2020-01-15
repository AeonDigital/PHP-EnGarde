.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


RouteResolver
=============


.. php:namespace:: AeonDigital\EnGarde

.. php:class:: RouteResolver


	.. rst-class:: phpdoc-description
	
		| Manipulador padrão para resolução das rotas.
		
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\iRequestHandler` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $serverConfig, $domainConfig, $applicationConfig, $serverRequest, $rawRouteConfig, $routeConfig)
	
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
			- ‹ ?\\AeonDigital\\EnGarde\\Config\\Interfaces\\iRouteConfig › **$routeConfig** |br|
			  Instância ``iRouteConfig``.

		
	
	

.. rst-class:: public

	.. php:method:: public handle( $request)
	
		.. rst-class:: phpdoc-description
		
			| Processa a requisição e produz uma resposta.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iServerRequest › **$request** |br|
			  Requisição que está sendo executada.

		
		:Returns: ‹ \\AeonDigital\\Http\\Message\\Interfaces\\iResponse ›|br|
			  
		
	
	

