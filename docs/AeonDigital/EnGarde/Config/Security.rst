.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Security
========


.. php:namespace:: AeonDigital\EnGarde\Config

.. rst-class::  final

.. php:class:: Security


	.. rst-class:: phpdoc-description
	
		| Implementação de ``Config\iSecurity``.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\Config\\iSecurity` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MainCheckArgumentException` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getIsActive()
	
		.. rst-class:: phpdoc-description
		
			| Retornará ``true`` se a aplicação estiver configurada para usar as definições de segurança.
			
			| Quando ``false`` indica que a aplicação é pública.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDataCookieName()
	
		.. rst-class:: phpdoc-description
		
			| Retornará o nome do cookie que carrega informações da sessão atual do usuário.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getSecurityCookieName()
	
		.. rst-class:: phpdoc-description
		
			| Retornará o nome do cookie de autenticação.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRouteToLogin()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a rota para o local onde o usuário faz login.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRouteToStart()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a rota para o local onde o usuário deve ser direcionado quando efetua o login.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRouteToResetPassword()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a rota para o local onde o usuário pode ir para efetuar o reset de sua senha.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getLoginKeyNames()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de nomes de campos que servem como chaves identificadoras
			| para os usuários do sistema.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAnonymousId()
	
		.. rst-class:: phpdoc-description
		
			| Retornará o Id do usuário anonimo da aplicação.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getSessionNamespace()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome de uma classe que implemente a interface
			| ``AeonDigital\EnGarde\Interfaces\Engine\iSession`` e que será responsável pelo
			| controle das sessões de UA na aplicação.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsSessionRenew()
	
		.. rst-class:: phpdoc-description
		
			| Indica se as sessões devem ser renovar a cada iteração do usuário.
			
			| O padrão é ``true``.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getSessionTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Retornará o tempo (em minutos) que cada sessão deve suportar de inatividade.
			
			| O padrão são 40 minutos.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAllowedFaultByIP()
	
		.. rst-class:: phpdoc-description
		
			| Retornará o limite de falhas de login permitidas para um mesmo ``IP`` em um determinado
			| periodo. O padrão são 50 tentativas.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIPBlockTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Retornará o tempo de bloqueio para um ``IP`` [em minutos].
			
			| O padrão são 50 minutos.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAllowedFaultByLogin()
	
		.. rst-class:: phpdoc-description
		
			| Retornará o limite de falhas permitidas para erros sucessivos de senha para um mesmo login.
			
			| O padrão são 5 tentativas.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getLoginBlockTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Retornará o tempo de bloqueio para um Login [em minutos].
			
			| O padrão são 20 minutos.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAllowedIPRanges()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de intervalos de IPs que tem permissão de acessar a aplicação.
			
			| Isto implica em dizer que a regra de segurança excluirá de acesso toda requisição que
			| venha de um IP que não esteja na lista previamente definida.
			| [tudo é proibido até que seja liberado]
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDeniedIPRanges()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de intervalos de IPs que estão bloqueados de acessar a aplicação.
			
			| Isto implica em dizer que a regra de segurança permitirá o acesso de toda requisição que
			| venha de um IP que não esteja na lista previamente definida.
			| [tudo é permitido até que seja bloqueado]
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public isAllowedIP( $ip)
	
		.. rst-class:: phpdoc-description
		
			| Identifia se o IP informado está dentro dos ranges definidos como válidos para o
			| acesso a esta aplicação.
			
			| As regras ``AllowedIPRanges`` e ``DeniedIPRanges`` são auto-excludentes, ou seja, apenas
			| uma delas pode estar valendo e, na presença de ambos conjuntos existirem, a regra
			| ``AllowedIPRanges`` (que é mais restritiva) é que prevalecerá para este teste.
			| 
			| Se nenhuma das regras estiver definido, todas as requisições serão aceitas.
			
		
		
		:Parameters:
			- ‹ string › **$ip** |br|
			  IP que será testado em seu formato ``human readable``.

		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $isActive, $dataCookieName, $securityCookieName, $routeToLogin, $routeToStart, $routeToResetPassword, $loginKeyNames, $anonymousId, $sessionNamespace, $isSessionRenew, $sessionTimeout, $allowedFaultByIP, $ipBlockTimeout, $allowedFaultByLogin, $loginBlockTimeout, $allowedIPRanges, $deniedIPRanges)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma instância que armazena as configurações de segurança para uma aplicação.
			
		
		
		:Parameters:
			- ‹ bool › **$isActive** |br|
			  Indica quando as configurações de segurança devem ou não serem usadas para
			  a aplicação.
			- ‹ string › **$dataCookieName** |br|
			  Nome do cookie que carrega informações da sessão atual do usuário.
			- ‹ string › **$securityCookieName** |br|
			  Nome do cookie de autenticação.
			- ‹ string › **$routeToLogin** |br|
			  Rota para o local onde o usuário faz login.
			- ‹ string › **$routeToStart** |br|
			  Rota para o local onde o usuário deve ser direcionado quando efetua o login.
			- ‹ string › **$routeToResetPassword** |br|
			  Rota para o local onde o usuário pode ir para efetuar o reset de sua senha.
			- ‹ array › **$loginKeyNames** |br|
			  Coleção de nomes de campos que servem como chaves identificadoras
			  para os usuários do sistema.
			- ‹ int › **$anonymousId** |br|
			  Id do usuário anonimo da aplicação.
			- ‹ string › **$sessionNamespace** |br|
			  Namespace da classe de controle de sessão.
			- ‹ bool › **$isSessionRenew** |br|
			  Define se as sessões devem ser renovadas a cada iteração do usuário.
			- ‹ int › **$sessionTimeout** |br|
			  Tempo (em minutos) que cada sessão deve suportar de inatividade.
			- ‹ int › **$allowedFaultByIP** |br|
			  Limite de falhas de login permitidas para um mesmo IP em um determinado periodo.
			- ‹ int › **$ipBlockTimeout** |br|
			  Tempo de bloqueio para um IP [em minutos].
			- ‹ int › **$allowedFaultByLogin** |br|
			  Limite de falhas permitidas para erros sucessivos de senha para um mesmo login.
			- ‹ int › **$loginBlockTimeout** |br|
			  Tempo de bloqueio para um Login [em minutos].
			- ‹ array › **$allowedIPRanges** |br|
			  Coleção de intervalos de Ips que tem acesso a aplicação.
			- ‹ array › **$deniedIPRanges** |br|
			  Coleção de intervalos de Ips que devem ser bloqueados de acesso.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido.
		
	
	

.. rst-class:: public static

	.. php:method:: public static fromArray( $config)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma instância configurada a partir de um array que contenha
			| as chaves correlacionadas a cada propriedade aqui definida.
			
		
		
		:Parameters:
			- ‹ array › **$config** |br|
			  Array associativo contendo os valores a serem definidos para a instância.

		
		:Returns: ‹ \\AeonDigital\\EnGarde\\Interfaces\\Config\\iSecurity ›|br|
			  
		
	
	

