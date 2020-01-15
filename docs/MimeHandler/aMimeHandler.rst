.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


aMimeHandler
============


.. php:namespace:: AeonDigital\EnGarde\MimeHandler

.. rst-class::  abstract

.. php:class:: aMimeHandler


	.. rst-class:: phpdoc-description
	
		| Classe abstrata a ser usada pelas classes concretas manipuladoras de mimetypes.
		
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\iMimeHandler` 
	

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

		
	
	

