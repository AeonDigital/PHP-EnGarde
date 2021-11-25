.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MainSession
===========


.. php:namespace:: AeonDigital\EnGarde\SessionControl

.. rst-class::  abstract

.. php:class:: MainSession


	.. rst-class:: phpdoc-description
	
		| Classe abstrata, base para uma implementação de um controle de sessão
		| do tipo &#34;Native&#34; para aplicações &#34;EnGarde&#34;.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\Engine\\iSession` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MainCheckArgumentException` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public retrieveSecurityCookie()
	
		.. rst-class:: phpdoc-description
		
			| Cookie de segurança que identifica a sessão atualmente setada.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Data\\iCookie ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public retrievePathToLocalData()
	
		.. rst-class:: phpdoc-description
		
			| Caminho completo até o diretório de dados da aplicação.
			
			| Usado em casos onde as informações de sessão estão armazenadas fisicamente
			| junto com a aplicação.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public retrieveSession()
	
		.. rst-class:: phpdoc-description
		
			| Retorna os dados da sessão autenticada que está atualmente reconhecida,
			| ativa e válida.
			
		
		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public retrieveUser()
	
		.. rst-class:: phpdoc-description
		
			| Retorna os dados de um usuário autenticado que esteja associado a sessão
			| que está reconhecida, ativa e válida.
			
		
		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public retrieveUserProfile()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o objeto completo do perfil de usuário atualmente em uso.
			
		
		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public retrieveUserProfileName()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o perfil de segurança do usuário atualmente em uso.
			
		
		
		:Returns: ‹ ?string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public retrieveUserProfiles( $applicationName=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de perfis de segurança que o usuário tem autorização de utilizar.
			
		
		
		:Parameters:
			- ‹ string › **$applicationName** |br|
			  Se definido, retornará apenas os profiles que correspondem ao nome da
			  aplicação indicada.

		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public retrieveSecurityStatus()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o status atual relativo a identificação e autenticação do UA
			| para a sessão atual.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public hasDataBase()
	
		.. rst-class:: phpdoc-description
		
			| Informará ``true`` caso a implementação esteja apta a utilizar um
			| banco de dados.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDAL()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto ``iDAL`` configurado com as credenciais correlacionadas
			| ao atual perfil de usuário sendo usado pelo UA.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\DAL\\iDAL ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $now, $environment, $applicationName, $userAgent, $userAgentIP, $securityConfig, $securityCookie, $pathToLocalData, $dbCredentials)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma nova instância de controle de sessão.
			
		
		
		:Parameters:
			- ‹ DateTime › **$now** |br|
			  Data e hora do momento em que a requisição que ativou a aplicação
			  chegou ao domínio.
			- ‹ string › **$environment** |br|
			  Tipo de ambiente que o domínio está rodando no momento.
			- ‹ string › **$applicationName** |br|
			  Nome da aplicação que deve responder a requisição ``Http`` atual.
			- ‹ string › **$userAgent** |br|
			  Identificação do user agent que efetuou a requisição.
			- ‹ string › **$userAgentIP** |br|
			  IP do user agent que efetuou a requisição.
			- ‹ AeonDigital\\EnGarde\\Interfaces\\Config\\iSecurity › **$securityConfig** |br|
			  Configurações de segurança para a aplicação corrente.
			- ‹ AeonDigital\\Interfaces\\Http\\Data\\iCookie › **$securityCookie** |br|
			  Cookie de segurança que armazena a identificação desta sessão.
			- ‹ string › **$pathToLocalData** |br|
			  Caminho completo até o diretório de dados da aplicação.
			- ‹ array › **$dbCredentials** |br|
			  Coleção de credenciais de acesso ao banco de dados.

		
	
	

