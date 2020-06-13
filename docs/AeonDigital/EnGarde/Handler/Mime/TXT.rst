.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


TXT
===


.. php:namespace:: AeonDigital\EnGarde\Handler\Mime

.. rst-class::  final

.. php:class:: TXT


	.. rst-class:: phpdoc-description
	
		| Manipulador para gerar documentos TXT.
		
	
	:Parent:
		:php:class:`AeonDigital\\EnGarde\\Handler\\Mime\\aMime`
	

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

	.. php:method:: public createResponseBody()
	
		.. rst-class:: phpdoc-description
		
			| Gera uma string que representa a resposta a ser enviada para o ``UA``, compatível com o
			| mimetype que esta classe está apta a manipular.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

