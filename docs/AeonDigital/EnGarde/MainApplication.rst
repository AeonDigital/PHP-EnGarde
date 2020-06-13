.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MainApplication
===============


.. php:namespace:: AeonDigital\EnGarde

.. rst-class::  abstract

.. php:class:: MainApplication


	.. rst-class:: phpdoc-description
	
		| Classe abstrata que deve ser herdada pelas classes concretas em cada Aplicações.
		
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\Engine\\iApplication` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $serverConfig)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma Aplicação.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Interfaces\\Config\\iServer › **$serverConfig** |br|
			  Instância ``iServerConfig``.

		
	
	

.. rst-class:: public

	.. php:method:: public run()
	
		.. rst-class:: phpdoc-description
		
			| Inicia o processamento da rota selecionada.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
	
	

