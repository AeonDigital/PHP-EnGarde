.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


iRequestHandler
===============


.. php:namespace:: AeonDigital\EnGarde\Interfaces

.. php:interface:: iRequestHandler


	.. rst-class:: phpdoc-description
	
		| Responsável por manipular uma requisição e processar a action alvo.
		
	

Methods
-------

.. rst-class:: public

	.. php:method:: public handle( $request)
	
		.. rst-class:: phpdoc-description
		
			| Processa a requisição e produz uma resposta.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iServerRequest › **$request** |br|
			  Requisição que está sendo executada.

		
		:Returns: ‹ \\AeonDigital\\Http\\Message\\Interfaces\\iResponse ›|br|
			  
		
	
	

