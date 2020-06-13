.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Server
======


.. php:namespace:: AeonDigital\EnGarde\Config

.. rst-class::  final

.. php:class:: Server


	.. rst-class:: phpdoc-description
	
		| Implementação de &#34;Config\iServer&#34;.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\EnGarde\\Interfaces\\Config\\iServer` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MainCheckArgumentException` :php:trait:`AeonDigital\Http\Traits\HTTPRawStatusCode` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getNow()
	
		.. rst-class:: phpdoc-description
		
			| Data e hora do momento em que a requisição que ativou a aplicação
			| chegou ao domínio.
			
		
		
		:Returns: ‹ \\DateTime ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getVersion()
	
		.. rst-class:: phpdoc-description
		
			| Resgata a versão atual do framework.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getServerVariables()
	
		.. rst-class:: phpdoc-description
		
			| Resgata um array associativo contendo todas as variáveis definidas para o servidor no
			| momento atual. Normalmente retorna o conteúdo de ``$_SERVER``.
			
		
		
		:Returns: ‹ array ›|br|
			  Será retornado ``[]`` caso nada tenha sido definido.
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestHeaders()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna uma coleção de headers ``HTTP`` definidos.
			
		
		
		:Returns: ‹ array ›|br|
			  Retornará ``[]`` caso nenhum seja encontrado.
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestHTTPVersion()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna a versão do protocolo ``HTTP``.
			
		
		
		:Returns: ‹ string ›|br|
			  Caso não seja possível identificar a versão deve ser retornado o valor ``1.1``.
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestUserAgent()
	
		.. rst-class:: phpdoc-description
		
			| Resgata a identificação do UA que está executando esta requisição.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestUserAgentIP()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o ``IP`` do UA que está executando esta requisição.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestIsUseHTTPS()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Indica se a requisição está exigindo o uso de ``HTTPS``.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestMethod()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna o método ``HTTP`` que está sendo usado.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestProtocol()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna ``http`` ou ``https`` conforme o protocolo que está sendo utilizado pela
			| requisição.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestDomainName()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna o nome do domínio onde o servidor está operando.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestPath()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna a parte ``path`` da ``URI`` que está sendo executada.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestPort()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna a porta ``HTTP`` que está sendo evocada.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestCookies()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna os cookies passados pelo ``UA`` em seu formato bruto.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestQueryStrings()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna os querystrings definidos na ``URI`` em seu formato bruto.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestFiles()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna um array de objetos que implementam ``AeonDigital\Interfaces\Stream\iFileStream``
			| representando os arquivos que foram submetidos durante a requisição.
			
		
		
		:Returns: ‹ array ›|br|
			  Os arquivos são resgatados de ``$_FILES``.
		
	
	

.. rst-class:: public

	.. php:method:: public getCurrentURI()
	
		.. rst-class:: phpdoc-description
		
			| Baseado nos dados da requisição que está sendo executada.
			
			| Retorna uma string que representa toda a ``URI`` que está sendo acessada no momento.
			| 
			| O resultado será uma string com o seguinte formato:
			| 
			| \`\`\`
			|  [ scheme &#34;:&#34; ][ &#34;//&#34; authority ][ &#34;/&#34; path ][ &#34;?&#34; query ]
			| \`\`\`
			| 
			| Obs: A porção ``fragment``, iniciada pelo caractere ``#`` não é utilizada.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPostedData()
	
		.. rst-class:: phpdoc-description
		
			| Resgata toda a coleção de informações passadas na requisição.
			
			| Concatena neste resultado as informações submetidas pelo UA.
			| Em caso de colisão de chaves de valores a ordem de prioridade de prevalencia será:
			| 
			| - requestRouteParans
			|   Parametros nomeados na própria rota e identificados pelo processamento da mesma.
			| - $_POST
			|   Parametros passados por POST.
			| - $_GET
			|   Parametros passados por GET.
			| - &#34;php://input&#34;
			|   Dados obtidos do stream bruto.
			| 
			| Não inclui valores passados via cookies.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRootPath()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o endereço completo do diretório onde o domínio está sendo executado.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getForceHTTPS()
	
		.. rst-class:: phpdoc-description
		
			| Indica que as requisições feitas para o domínio devem ser realizadas sob o protocolo
			| HTTPS.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getEnvironmentType()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o tipo de ambiente que o domínio está rodando no momento.
			
			| Valores Esperados:
			| - ``PRD``   : Production
			| - ``HML``   : Homolog
			| - ``QA``    : Quality Assurance
			| - ``DEV``   : Development
			| - ``LCL``   : Local
			| - ``UTEST`` : Unit Test
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsDebugMode()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se o domínio está em modo de debug.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsUpdateRoutes()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se for para a aplicação alvo atualizar suas respectivas rotas.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getHostedApps()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a coleção de nomes de aplicações instaladas no domínio
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDefaultApp()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome da aplicação padrão do domínio.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDateTimeLocal()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o timezone do domínio.
			
			| [Lista de fusos horários suportados](http://php.net/manual/en/timezones.php)
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getTimeout()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o tempo máximo (em segundos) para a execução das requisições.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getMaxFileSize()
	
		.. rst-class:: phpdoc-description
		
			| Valor máximo (em Mb) para o upload de um arquivo.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getMaxPostSize()
	
		.. rst-class:: phpdoc-description
		
			| Valor máximo (em Mb) para a postagem de dados.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToErrorView( $fullPath=false)
	
		.. rst-class:: phpdoc-description
		
			| Resgata o caminho até a view que deve ser enviada ao ``UA`` em caso de
			| erros no domínio.
			
		
		
		:Parameters:
			- ‹ bool › **$fullPath** |br|
			  Se ``false`` retornará o caminho relativo.
			  Quando ``true`` deverá retornar o caminho completo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getApplicationClassName()
	
		.. rst-class:: phpdoc-description
		
			| Resgata o nome da classe responsável por iniciar a aplicação.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getApplicationName()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome da aplicação que deve responder a requisição ``HTTP`` atual.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getIsApplicationNameOmitted()
	
		.. rst-class:: phpdoc-description
		
			| Indica quando na ``URI`` atual o nome da aplicação a ser executada está omitida. Nestes
			| casos a aplicação padrão deve ser executada.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getApplicationNamespace()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome completo da classe da aplicação que deve ser instanciada para responder
			| a requisição atual.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getApplicationRequestUri()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a URI que está sendo requisitada em ``nível de aplicação``, ou seja, irá SEMPRE
			| adicionar o nome da aplicação que está sendo chamada na primeira partícula da URI caso
			| ela esteja omitida.
			
			| Não irá retornar usar qualquer querystring da requisição, apenas a parte ``path``.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getNewLocationPath()
	
		.. rst-class:: phpdoc-description
		
			| Pode retornar uma string para onde o UA deve ser redirecionado caso alguma das
			| configurações ou processamento dos presentes dados indique que tal redirecionamento
			| seja necessário.
			
			| Retorna ``''`` caso nenhum redirecionamento seja necessário.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDeveloperHTTPMethods()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a coleção de métodos HTTP que devem poder ser usados pelas actions.
			
			| Ou seja, aqueles que os desenvolvedores terão acesso de configurar.
			| 
			| Originalmente estes:
			| &#34;GET&#34;, &#34;POST&#34;, &#34;PUT&#34;, &#34;PATCH&#34;, &#34;DELETE&#34;
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getFrameworkHTTPMethods()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a coleção de métodos HTTP que devem poder ser controlados exclusivamente
			| pelo próprio framework.
			
			| Originalmente estes:
			| &#34;HEAD&#34;, &#34;OPTIONS&#34;, &#34;TRACE&#34;, &#34;DEV&#34;, &#34;CONNECT&#34;
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $serverVariables, $uploadedFiles, $engineVariables)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma instância com os dados de configuração atual para o servidor ``HTTP``.
			
		
		
		:Parameters:
			- ‹ array › **$serverVariables** |br|
			  Array associativo contendo todas as variáveis definidas para o servidor no
			  momento atual. Normalmente será o conteúdo de ``$_SERVER``.
			- ‹ array › **$uploadedFiles** |br|
			  Coleção de arquivos que estão sendo submetidos na requisição.
			  Deve ser um array compatível com a estrutura esperada do objeto $_FILES
			  padrão.
			- ‹ array › **$engineVariables** |br|
			  Array associativo contendo todas as variáveis de configuração para o
			  motor de aplicações que está sendo iniciado.
			  São esperados, obrigatoriamente os seguintes valores:
			  
			  - bool forceHTTPS
			  Indica se as requisições deste domínio devem ser feitos sob HTTPS.
			  
			  - string rootPath
			  Caminho completo até o diretório onde o domínio está sendo executado.
			  Se não for definido, irá pegar o valor existente em DOCUMENT_ROOT.
			  
			  - string environmentType
			  Tipo de ambiente que o domínio está rodando no momento.
			  
			  -bool isDebugMode
			  Indica se o domínio está em modo de debug.
			  
			  - bool isUpdateRoutes
			  Indica se a aplicação alvo da requisição deve atualizar suas respectivas rotas.
			  
			  - array hostedApps
			  Array contendo o nomes das aplicações que estão instaladas no domínio.
			  
			  - string defaultApp
			  Nome da aplicação padrão do domínio.
			  
			  - string dateTimeLocal
			  Define o timezone do domínio.
			  
			  - int timeout
			  Valor máximo (em segundos) para a execução das requisições.
			  
			  - int maxFileSize
			  Valor máximo (em Mb) para o upload de um arquivo.
			  
			  - int maxPostSize
			  Valor máximo (em Mb) para a postagem de dados.
			  
			  - string pathToErrorView
			  Caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros no domínio.
			  
			  - string applicationClassName
			  Nome da classe responsável por iniciar a aplicação.

		
	
	

.. rst-class:: public

	.. php:method:: public setErrorListening()
	
		.. rst-class:: phpdoc-description
		
			| Efetua as configurações necessárias para os manipuladores de exceptions e errors
			| para as aplicações do domínio.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setPHPConfiguration()
	
		.. rst-class:: phpdoc-description
		
			| Efetua configurações para o ``PHP`` conforme as propriedades definidas para esta classe.
			
			| Esta ação só tem efeito na primeira vez que é executada.
			
		
		
		:Throws: ‹ \RunTimeException ›|br|
			  Caso alguma propriedade obrigatória não tenha sido definida ou seja um valor
			  inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public getHttpFactory()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto ``iFactory``.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\iFactory ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getServerRequest()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a instância ``iServerRequest`` a ser usada.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iServerRequest ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getApplicationConfig( $config=[])
	
		.. rst-class:: phpdoc-description
		
			| Retorna a instância ``Config\iApplication``.
			
		
		
		:Parameters:
			- ‹ array › **$config** |br|
			  Array associativo contendo as configurações para esta instância.

		
		:Returns: ‹ \\AeonDigital\\EnGarde\\Interfaces\\Config\\iApplication ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getSecurityConfig( $config=[])
	
		.. rst-class:: phpdoc-description
		
			| Retorna a instância ``Config\iSecurity`` a ser usada.
			
		
		
		:Parameters:
			- ‹ array › **$config** |br|
			  Array associativo contendo as configurações para esta instância.

		
		:Returns: ‹ \\AeonDigital\\EnGarde\\Interfaces\\Config\\iSecurity ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getSecuritySession()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma instância ``iSession`` para efetuar o controle de sessão
			| de UA dentro da aplicação.
			
		
		
		:Returns: ‹ \\AeonDigital\\EnGarde\\Interfaces\\Engine\\iSession ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRouteConfig( $config=null, $isRaw=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna a instância ``Config\iRoute`` a ser usada.
			
		
		
		:Parameters:
			- ‹ array › **$config** |br|
			  Array associativo contendo as configurações para esta instância.
			- ‹ bool › **$isRaw** |br|
			  Quando ``true`` indica que o parametro passado em ``$config`` possui as
			  informações necessárias para a criação do objeto ``iRoute``, no entanto
			  este precisa de algum tratamento especial antes da criação da instância.

		
		:Returns: ‹ ?\\AeonDigital\\EnGarde\\Interfaces\\Config\\iRoute ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRawRouteConfig()
	
		.. rst-class:: phpdoc-description
		
			| Retorna os dados brutos referentes a rota que está sendo executada no momento.
			
		
		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public redirectTo( $url, $code=302, $message=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Redireciona o ``UA`` para a URL indicada.
			
			| Esta ação interrompe o script imediatamente após o redirecionamento.
			
		
		
		:Parameters:
			- ‹ string › **$url** |br|
			  URL para onde o ``UA`` será redirecionado.
			- ‹ int › **$code** |br|
			  Código HTTP.
			- ‹ string › **$message** |br|
			  Mensagem HTTP.
			  Se nenhuma for informada irá usar a mensagem padrão que corresponda
			  ao código HTTP indicado.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static fromArray( $config)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma nova instância ``Config\iServer``.
			
		
		
		:Parameters:
			- ‹ array › **$config** |br|
			  Array associativo contendo as configurações para esta instância.
			  Esperado um array com 3 posições sendo:
			  &#34;SERVER&#34; => Equivalente ao valor de $_SERVER
			  &#34;FILES&#34;  => Equivalente ao valor de $_FILES
			  &#34;ENGINE&#34; => Contendo todos os valores obrigatórios para a configuração
			              do motor da aplicação.

		
		:Returns: ‹ \\AeonDigital\\EnGarde\\Interfaces\\Config\\iServer ›|br|
			  
		
	
	

