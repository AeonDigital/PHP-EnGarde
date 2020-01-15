.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


iResponseHandler
================


.. php:namespace:: AeonDigital\EnGarde\Interfaces

.. php:interface:: iResponseHandler


	.. rst-class:: phpdoc-description
	
		| Interface para classes que tem como função produzir uma view que pode ser enviada para o ``UA``.
		
	

Methods
-------

.. rst-class:: public

	.. php:method:: public prepareResponse()
	
		.. rst-class:: phpdoc-description
		
			| Prepara o objeto ``iResponse`` com os ``headers`` e com o ``body`` que deve ser usado
			| para responder ao ``UA``.
			
		
		
		:Returns: ‹ \\AeonDigital\\Http\\Message\\Interfaces\\iResponse ›|br|
			  
		
	
	

