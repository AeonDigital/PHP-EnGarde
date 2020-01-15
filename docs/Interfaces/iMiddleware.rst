.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


iMiddleware
===========


.. php:namespace:: AeonDigital\EnGarde\Interfaces

.. php:interface:: iMiddleware


	.. rst-class:: phpdoc-description
	
		| Define uma camada de processo a ser executado para resolver requisições e assim produzir
		| uma resposta para o ``UA``.
		
	

Methods
-------

.. rst-class:: public

	.. php:method:: public process( $request, $handler)
	
		.. rst-class:: phpdoc-description
		
			| Efetua uma camada do processo de resolução da requisição submetida pelo ``UA``.
			
			| Se não for capaz de produzir um objeto response por si mesmo, deve delegar esta
			| responsabilidade para o manipulador padrão.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iServerRequest › **$request** |br|
			  Objeto da requisição HTTP.
			- ‹ AeonDigital\\EnGarde\\Interfaces\\iRequestHandler › **$handler** |br|
			  Manipulador padrão para as requisições.

		
		:Returns: ‹ \\AeonDigital\\Http\\Message\\Interfaces\\iResponse ›|br|
			  
		
	
	

