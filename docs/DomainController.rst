.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


DomainController
================


.. php:namespace:: AeonDigital\EnGarde

.. rst-class::  abstract

.. php:class:: DomainController


	.. rst-class:: phpdoc-description
	
		| Classe abstrata que deve ser herdada pelos controllers das aplicações.
		
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\iController` 
	

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
			- ‹ AeonDigital\\EnGarde\\Config\\Interfaces\\iRouteConfig › **$routeConfig** |br|
			  Instância ``iRouteConfig``.
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iResponse › **$response** |br|
			  Instância ``iResponse``.

		
	
	

.. rst-class:: public

	.. php:method:: public getResponse()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a instância ``iResponse``.
			
			| Aplica no objeto ``iResponse`` as propriedades ``viewData`` (obtido do resultado da
			| execução da action);
			| ``viewConfig`` (obtido com a manipulação das propriedades variáveis do objeto
			| **routeConfig**);
			| ``headers`` (padrões + os definidos pela action)
			
		
		
		:Returns: ‹ \\AeonDigital\\Http\\Message\\Interfaces\\iResponse ›|br|
			  
		
	
	

