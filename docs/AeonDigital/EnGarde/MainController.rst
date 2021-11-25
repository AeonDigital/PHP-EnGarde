.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MainController
==============


.. php:namespace:: AeonDigital\EnGarde

.. rst-class::  abstract

.. php:class:: MainController


	.. rst-class:: phpdoc-description
	
		| Classe abstrata que deve ser herdada pelos controllers das aplicações.
		
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\Engine\\iController` 
	
	:Used traits:
		:php:trait:`AeonDigital\EnGarde\Traits\ActionTools` 
	

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

		
	
	

.. rst-class:: public

	.. php:method:: public getResponse()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a instância ``iResponse``.
			
			| Aplica no objeto ``iResponse`` as propriedades ``viewData``, ``viewConfig`` e
			| ``headers``. Todos manipuláveis durante a execução da action.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iResponse ›|br|
			  
		
	
	

