.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


SecurityStatus
==============


.. php:namespace:: AeonDigital\EnGarde\SessionControl\Enum

.. php:class:: SecurityStatus


	.. rst-class:: phpdoc-description
	
		| Status relativo as verificações de segurança.
		
	

Constants
---------

.. php:const:: UserAgentUndefined = &#34;UserAgentUndefined&#34;

	.. rst-class:: phpdoc-description
	
		| Verificações de segurança não foram feitos para o UA.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAgentIPHasBeenBlocked = &#34;UserAgentIPHasBeenBlocked&#34;

	.. rst-class:: phpdoc-description
	
		| IP desabilitado por excesso de falhas ao tentar login.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAgentIPBlocked = &#34;UserAgentIPBlocked&#34;

	.. rst-class:: phpdoc-description
	
		| O UA está usando um IP que está bloqueado.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAgentIPValid = &#34;UserAgentIPValid&#34;

	.. rst-class:: phpdoc-description
	
		| O UA está usando um IP válido.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: SessionUndefined = &#34;SessionUndefined&#34;

	.. rst-class:: phpdoc-description
	
		| Sessão indefinida.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: SessionUnchecked = &#34;SessionUnchecked&#34;

	.. rst-class:: phpdoc-description
	
		| Sessão definida mas não verificada.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: SessionInvalid = &#34;SessionInvalid&#34;

	.. rst-class:: phpdoc-description
	
		| A sessão informada é inválida ou não pode ser encontrada.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: SessionUnespectedUserAgentIP = &#34;SessionUnespectedUserAgentIP&#34;

	.. rst-class:: phpdoc-description
	
		| IP do UA não é compativel com o valor armazenado em sua sessão.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: SessionUnespectedUserAgent = &#34;SessionUnespectedUserAgent&#34;

	.. rst-class:: phpdoc-description
	
		| Identificação do UA não é compativel com o valor armazenado em sua sessão.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: SessionExpired = &#34;SessionExpired&#34;

	.. rst-class:: phpdoc-description
	
		| Sessão do UA expirou.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: SessionValid = &#34;SessionValid&#34;

	.. rst-class:: phpdoc-description
	
		| Sessão válida.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountDoesNotExist = &#34;UserAccountDoesNotExist&#34;

	.. rst-class:: phpdoc-description
	
		| Conta de usuário não existe.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountUnchecked = &#34;UserAccountUnchecked&#34;

	.. rst-class:: phpdoc-description
	
		| Conta de usuário existe mas não pode ser verificada.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountDisabledForDomain = &#34;UserAccountDisabledForDomain&#34;

	.. rst-class:: phpdoc-description
	
		| Conta do usuário está desabilitada dentro deste domínio.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountDisabledForApplication = &#34;UserAccountDisabledForApplication&#34;

	.. rst-class:: phpdoc-description
	
		| Conta do usuário está desabilitada dentro da aplicação alvo.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountRecognizedAndActive = &#34;UserAccountRecognizedAndActive&#34;

	.. rst-class:: phpdoc-description
	
		| Conta do usuário foi reconhecida e está ativa.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountWaitingNewSession = &#34;UserAccountWaitingNewSession&#34;

	.. rst-class:: phpdoc-description
	
		| Conta de usuário existe, autenticada e aguardando uma sessão de autorização.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountUnexpectedPassword = &#34;UserAccountUnexpectedPassword&#34;

	.. rst-class:: phpdoc-description
	
		| Conta do usuário existe mas a senha não está correta.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountIsBlocked = &#34;UserAccountIsBlocked&#34;

	.. rst-class:: phpdoc-description
	
		| Conta do usuário está bloqueada.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserAccountHasBeenBlocked = &#34;UserAccountHasBeenBlocked&#34;

	.. rst-class:: phpdoc-description
	
		| Conta bloqueada por excesso de falhas ao tentar login.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserSessionUnchecked = &#34;UserSessionUnchecked&#34;

	.. rst-class:: phpdoc-description
	
		| Conta de usuário não teve sua sessão verificada.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserSessionUnespected = &#34;UserSessionUnespected&#34;

	.. rst-class:: phpdoc-description
	
		| Conta de usuário está vinculada a uma sessão diferente da sessão apresentada
		| por seu cookie de segurança.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserSessionAccepted = &#34;UserSessionAccepted&#34;

	.. rst-class:: phpdoc-description
	
		| Conta de usuário não teve sua sessão verificada.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserSessionLoginFail = &#34;UserSessionLoginFail&#34;

	.. rst-class:: phpdoc-description
	
		| Ocorreu uma falha no sistema durante a tentativa de login.
		
	
	:Type: ‹ string ›|br|
		  
	


.. php:const:: UserSessionAuthenticated = &#34;UserSessionAuthenticated&#34;

	.. rst-class:: phpdoc-description
	
		| Sessão do usuário está autenticada.
		
	
	:Type: ‹ string ›|br|
		  
	


