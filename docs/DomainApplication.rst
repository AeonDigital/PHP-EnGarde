.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


DomainApplication
=================


.. php:namespace:: AeonDigital\EnGarde

.. rst-class::  abstract

.. php:class:: DomainApplication


	.. rst-class:: phpdoc-description
	
		| Classe abstrata que deve ser herdada pelas classes concretas em cada Aplicações ``EnGarde``.
		
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\iApplication` 
	

Properties
----------

Methods
-------

.. rst-class:: public abstract

	.. php:method:: public abstract configureApplication()
	
		.. rst-class:: phpdoc-description
		
			| Permite configurar ou redefinir o objeto de configuração da aplicação na classe
			| concreta da mesma.
			
		
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $serverConfig, $domainConfig, $serverRequest)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma Aplicação.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Config\\Interfaces\\iServerConfig › **$serverConfig** |br|
			  Instância ``iServerConfig``.
			- ‹ AeonDigital\\EnGarde\\Config\\Interfaces\\iDomainConfig › **$domainConfig** |br|
			  Instância ``iDomainConfig``.
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iServerRequest › **$serverRequest** |br|
			  Instância ``iServerRequest``.

		
	
	

.. rst-class:: public

	.. php:method:: public run()
	
		.. rst-class:: phpdoc-description
		
			| Inicia o processamento da rota selecionada.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getTestViewDebug()
	
		.. rst-class:: phpdoc-description
		
			| Usado para testes em desenvolvimento.
			
			| Retorna um valor interno que poderá ser aferido em ambiente de testes.
			
		
		
		:Returns: ‹ mixed ›|br|
			  
		
	
	

