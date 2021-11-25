.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


aMime
=====


.. php:namespace:: AeonDigital\EnGarde\Handler\Mime

.. rst-class::  abstract

.. php:class:: aMime


	.. rst-class:: phpdoc-description
	
		| Classe abstrata a ser usada pelas classes concretas manipuladoras de mimetypes.
		
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Server\\iMimeHandler` 
	
	:Used traits:
		:php:trait:`AeonDigital\EnGarde\Traits\ActionTools` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $serverConfig, $response)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma nova instância.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Interfaces\\Config\\iServer › **$serverConfig** |br|
			  Instância ``iServerConfig``.
			- ‹ AeonDigital\\Interfaces\\Http\\Message\\iResponse › **$response** |br|
			  Instância ``iResponse``.

		
	
	

