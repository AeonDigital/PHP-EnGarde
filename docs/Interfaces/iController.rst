.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


iController
===========


.. php:namespace:: AeonDigital\EnGarde\Interfaces

.. php:interface:: iController


	.. rst-class:: phpdoc-description
	
		| Interface a ser usada em todas as classes que serão controllers das aplicações.
		
	

Methods
-------

.. rst-class:: public

	.. php:method:: public getResponse()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a instância ``iResponse``.
			
			| Aplica no objeto ``iResponse`` as propriedades ``viewData`` e ``routeConfig`` com os
			| valores resultantes do processamento da ``Action``.
			
		
		
		:Returns: ‹ \\AeonDigital\\Http\\Message\\Interfaces\\iResponse ›|br|
			  
		
	
	

