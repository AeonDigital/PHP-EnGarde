.. rst-class:: phpdoctorst

.. role:: php(code)

	:language: php


NativeLocal
===========


.. php:namespace:: AeonDigital\EnGarde\SessionControl

.. php:class:: NativeLocal


	.. rst-class:: phpdoc-description

		| Implementa o controle de sessão para tipo &#34;NativeLocal&#34;.


	:Parent:
		:php:class:`AeonDigital\\EnGarde\\SessionControl\\MainSession`


Properties
----------

Methods
-------

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
			  Nome da aplicação que deve responder a requisição ``HTTP`` atual.

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





.. rst-class:: public

	.. php:method:: public executeLogin( $userName, $userPassword, $grantPermission=&#34;&#34;, $sessionHash=&#34;&#34;)

		.. rst-class:: phpdoc-description

			| Efetua o login do usuário.



		:Parameters:
			- ‹ string › **$userName** |br|
			  Nome do usuário.

			- ‹ string › **$userPassword** |br|
			  Senha de autenticação.

			- ‹ string › **$grantPermission** |br|
			  Permissão que será concedida a uma sessão autenticada

			- ‹ string › **$sessionHash** |br|
			  Sessão autenticada que receberá a permissão especial.


		:Returns: ‹ bool ›|br|
			  Retornará ``true`` quando o login for realizado com
			  sucesso e ``false`` quando falhar por qualquer motivo.




.. rst-class:: public

	.. php:method:: public checkUserAgentSession()

		.. rst-class:: phpdoc-description

			| Verifica se o UA possui uma sessão válida para ser usada.



		:Returns: ‹ bool ›|br|





.. rst-class:: public

	.. php:method:: public executeLogout()

		.. rst-class:: phpdoc-description

			| Efetua o logout do usuário na aplicação e encerra sua sessão.



		:Returns: ‹ bool ›|br|





.. rst-class:: public

	.. php:method:: public checkRoutePermission( $methodHTTP, $rawRoute)

		.. rst-class:: phpdoc-description

			| Verifica se o usuário atualmente identificado possui permissão de acesso
			| na rota identificada a partir do seu perfil em uso.



		:Parameters:
			- ‹ string › **$methodHTTP** |br|
			  Método HTTP sendo usado.

			- ‹ string › **$rawRoute** |br|
			  Rota evocada em seu estado bruto (contendo o nome da aplicação).


		:Returns: ‹ bool ›|br|





.. rst-class:: public

	.. php:method:: public changeUserProfile( $profile)

		.. rst-class:: phpdoc-description

			| Efetua a troca do perfil de segurança atualmente em uso por outro que deve estar
			| na coleção de perfis disponíveis para este mesmo usuário.



		:Returns: ‹ ?array ›|br|





.. rst-class:: public

	.. php:method:: public registerLogActivity( $methodHTTP, $fullURL, $postData, $controller, $action, $activity, $note)

		.. rst-class:: phpdoc-description

			| Gera um registro de atividade para a requisição atual.



		:Parameters:
			- ‹ string › **$methodHTTP** |br|
			  Método HTTP evocado.

			- ‹ string › **$fullURL** |br|
			  URL completa evocada pelo UA.

			- ‹ ?array › **$postData** |br|
			  Dados que foram postados na requisição.

			- ‹ string › **$controller** |br|
			  Controller que foi acionado.

			- ‹ string › **$action** |br|
			  Nome da action que foi executada.

			- ‹ string › **$activity** |br|
			  Atividade executada.

			- ‹ string › **$note** |br|
			  Observação.


		:Returns: ‹ bool ›|br|
