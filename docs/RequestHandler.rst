.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


RequestHandler
==============


.. php:namespace:: AeonDigital\EnGarde

.. rst-class::  final

.. php:class:: RequestHandler


	.. rst-class:: phpdoc-description
	
		| Responsável por coordenar e executar uma lista de processos (Middlewares) a serem efetuados
		| para uma requisição e ao fim, executar o próprio manipulador da requisição realizada pelo ``UA``.
		
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\iRequestHandler` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $actionHandler)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um gerenciador de processos para requisições.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Interfaces\\iRequestHandler › **$actionHandler** |br|
			  Manipulador da action alvo.
			  Será executado sempre ao finalizar a lista de Middlewares programados para a
			  requisição.

		
	
	

.. rst-class:: public

	.. php:method:: public add( $middleware)
	
		.. rst-class:: phpdoc-description
		
			| Adiciona um novo Middleware na lista de processos da requisição.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Interfaces\\iMiddleware | \\Psr\\Http\\Server\\MiddlewareInterface › **$middleware** |br|
			  Objeto Middleware a ser adicionado na lista de tarefas.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public handle( $request)
	
		.. rst-class:: phpdoc-description
		
			| Processa a lista de Middlewares e após o próprio manipulador da requisição e produz uma
			| resposta.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\Http\\Message\\Interfaces\\iServerRequest › **$request** |br|
			  Requisição que está sendo executada.

		
		:Returns: ‹ \\AeonDigital\\Http\\Message\\Interfaces\\iResponse ›|br|
			  
		
	
	

