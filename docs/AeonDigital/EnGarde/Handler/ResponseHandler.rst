.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseHandler
===============


.. php:namespace:: AeonDigital\EnGarde\Handler

.. php:class:: ResponseHandler


	.. rst-class:: phpdoc-description
	
		| Permite produzir uma view a partir das informações coletadas pelo processamento da rota alvo.
		
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Server\\iResponseHandler` 
	

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

		
	
	

.. rst-class:: public

	.. php:method:: public prepareResponse()
	
		.. rst-class:: phpdoc-description
		
			| Prepara o objeto ``iResponse`` com os ``headers`` e com o ``body`` que deve ser usado
			| para responder ao ``UA``.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iResponse ›|br|
			  
		
	
	

