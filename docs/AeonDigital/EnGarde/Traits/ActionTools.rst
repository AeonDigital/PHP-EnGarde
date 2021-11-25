.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ActionTools
===========


.. php:namespace:: AeonDigital\EnGarde\Traits

.. php:trait:: ActionTools


	.. rst-class:: phpdoc-description
	
		| Coleção de métodos e propriedades que devem estar disponíveis tanto no escopo das actions
		| dentro dos controllers quanto nas views e demais includes chamados por estas.
		
	

Properties
----------

Methods
-------

.. rst-class:: public static

	.. php:method:: public static sttRetrieveFormFieldset( $serverConfig, $prefix, $onlyNotEmpty=false, $prepareForXSS=true)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array associativo referente a uma coleção de campos postados pelo UA
			| incluindo também aqueles passados via querystrings e os parametros identificados
			| na construção da rota.
			
			| A identificação dos campos que fazem parte desta coleção se dá pelo prefixo
			| em comum que eles tenham em seus &#34;name&#34;.
			| 
			| Há um tratamento especial para todo campo definido com o nome &#34;Id&#34;.
			| Para estes, sempre que seus valores forem vazios, tal chave será omitida no corpo
			| do array retornado.
			| 
			| Todos os valores retornados estarão também tratados com o método ``\htmlspecialchars``
			| visando assim inibir ataques usando injeção xss. Portanto, é necessário que, naqueles
			| campos que se planeja permitir que sejam usadas marcações HTML, o valor seja
			| retratado com o método ``\htmlspecialchars_decode``.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\EnGarde\\Interfaces\\Config\\iServer › **$serverConfig** |br|
			  Objeto &#34;serverConfig&#34; para uso.
			- ‹ string › **$prefix** |br|
			  Prefixo que identifica os campos que devem ser retornados.
			  Internamente adiciona um &#34;_&#34; ao final desta string caso ela seja
			  diferente de ``&#34;&#34;``
			- ‹ bool › **$onlyNotEmpty** |br|
			  Quando ``true`` irá retornar apenas os dados que não sejam ``&#34;&#34;``.
			- ‹ bool › **$prepareForXSS** |br|
			  Quando ``true`` irá fazer todos os valores passados serem submetidos
			  ao método ``htmlspecialchars``.

		
		:Returns: ‹ array ›|br|
			  
		
	
	

