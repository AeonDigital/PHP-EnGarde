.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


DomainManager
=============


.. php:namespace:: AeonDigital\EnGarde

.. php:class:: DomainManager


	.. rst-class:: phpdoc-description
	
		| Gerenciador principal do domínio.
		
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $serverConfig=null, $domainConfig=null)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um domínio.
			
		
		
		:Parameters:
			- ‹ ?\\AeonDigital\\EnGarde\\Config\\Interfaces\\iServerConfig › **$serverConfig** |br|
			  Instância ``iServerConfig`` para ser usada pelo domínio.
			  Se nenhuma for definida então uma nova será instanciada usando os valores
			  encontrados nas variáveis globais.
			- ‹ ?\\AeonDigital\\EnGarde\\Config\\Interfaces\\iDomainConfig › **$domainConfig** |br|
			  Instância ``iDomainConfig`` para ser usado pelo domínio.
			  Se nenhuma for definida então uma nova será instanciada usando os valores
			  encontrados nas constantes globais.

		
	
	

.. rst-class:: public

	.. php:method:: public run()
	
		.. rst-class:: phpdoc-description
		
			| Efetivamente inicia o processamento da requisição ``HTTP`` identificando qual aplicação
			| deve ser iniciada e então executada.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getTestViewDebug()
	
		.. rst-class:: phpdoc-description
		
			| Usado para testes em desenvolvimento.
			
			| Retorna um valor interno que poderá ser aferido em ambiente de testes.
			
		
		
		:Returns: ‹ mixed ›|br|
			  
		
	
	

