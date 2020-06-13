.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


RouteResolver
=============


.. php:namespace:: AeonDigital\EnGarde\Handler

.. php:class:: RouteResolver


	.. rst-class:: phpdoc-description
	
		| Manipulador padrão para resolução das rotas.
		
		| Trata-se de uma classe ``iRequestHandler`` que tem por função iniciar e executar o
		| ``controller`` e ``action`` alvo da requisição e, ao final, entregar o objeto ``iResponse``
		| resultante para ser usado por uma implementação de ``iResponseHandler``.
		| 
		| Deve ser executada após todos os ``Middlewares`` terem sido acionados.
		
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Server\\iRequestHandler` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $serverConfig)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma nova instância.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Interfaces\\Config\\iServer › **$serverConfig** |br|
			  Instância ``iServerConfig``.

		
	
	

.. rst-class:: public

	.. php:method:: public handle( $request)
	
		.. rst-class:: phpdoc-description
		
			| Processa a requisição e produz uma resposta.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\Interfaces\\Http\\Message\\iServerRequest › **$request** |br|
			  Requisição que está sendo executada.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iResponse ›|br|
			  
		
	
	

