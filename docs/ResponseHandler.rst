.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseHandler
===============


.. php:namespace:: AeonDigital\EnGarde

.. php:class:: ResponseHandler


	.. rst-class:: phpdoc-description
	
		| Permite produzir uma view a partir das informações coletadas pelo processamento da rota alvo.
		
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\iResponseHandler` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MimeTypeData` 
	

Properties
----------

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
			- ‹ ?\\AeonDigital\\EnGarde\\Config\\Interfaces\\iRouteConfig › **$routeConfig** |br|
			  Instância ``iRouteConfig``.
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iResponse › **$response** |br|
			  Instância ``iResponse``.

		
	
	

.. rst-class:: public

	.. php:method:: public prepareResponse()
	
		.. rst-class:: phpdoc-description
		
			| Prepara o objeto ``iResponse`` com os ``headers`` e com o ``body`` que deve ser usado
			| para responder ao ``UA``.
			
		
		
		:Returns: ‹ \\AeonDigital\\Http\\Message\\Interfaces\\iResponse ›|br|
			  
		
	
	

