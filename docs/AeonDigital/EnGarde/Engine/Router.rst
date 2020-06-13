.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Router
======


.. php:namespace:: AeonDigital\EnGarde\Engine

.. php:class:: Router


	.. rst-class:: phpdoc-description
	
		| Roteador para as requisições ``HTTP`` de uma Aplicação.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\Engine\\iRouter` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $serverConfig)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um Roteador.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Interfaces\\Config\\iServer › **$serverConfig** |br|
			  Objeto de configuração do servidor.

		
	
	

.. rst-class:: public

	.. php:method:: public isToProcessApplicationRoutes()
	
		.. rst-class:: phpdoc-description
		
			| Deve verificar quando a aplicação possui alterações que envolvam a necessidade de efetuar
			| uma atualização nos dados das rotas.
			
			| Idealmente verificará se os controllers da aplicação possuem alguma alteração posterior
			| a data do último processamento, e, estando o sistema configurado para atualizar
			| automaticamente as rotas, deverá retornar ``true``.
			| 
			| Também deve retornar ``true`` quando, por qualquer motivo definido na implementação, o
			| processamento anterior não existir ou for considerado como desatualizado.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public processApplicationRoutes()
	
		.. rst-class:: phpdoc-description
		
			| Varre os arquivos de ``controllers`` da aplicação e efetua o processamento das mesmas.
			
			| Idealmente o resultado deve ser um arquivo de configuração contendo todos os dados necessários
			| para a execução de cada rota de forma individual.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
		:Throws: ‹ \RuntimeException ›|br|
			  Caso algum erro ocorra no processo.
		
	
	

.. rst-class:: public

	.. php:method:: public selectTargetRawRoute( $targetRoute)
	
		.. rst-class:: phpdoc-description
		
			| Identifica se a rota passada corresponde a alguma das rotas configuradas para a
			| aplicação e retorna um array associativo contendo todos os dados correspondentes a mesma.
			
			| Em caso de falha na identificação da rota será retornado ``null``.
			
		
		
		:Parameters:
			- ‹ string › **$targetRoute** |br|
			  Porção relativa da ``URI`` que está sendo executada.
			  É necessário constar na rota, como sua primeira parte, o nome da aplicação
			  que está sendo executada.
			  Não deve constar quaisquer parametros ``querystring`` ou ``fragment``.

		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

