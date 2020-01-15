.. rst-class:: phpdoctorst

.. role:: php(code)

	:language: php


.. _namespace-AeonDigital-EnGarde:

=======
EnGarde
=======

| **PHP-EnGarde**
| Micro framework para criar/gerenciar multiplas aplicações/APIs em um mesmo 
| domínio.  


_______________________________________________________________________________

Instalação
----------

Instale em seu projeto usando o composer:


**Via terminal**

.. code-block:: console

    composer require aeondigital/phpengarde


**Via composer.json**

.. code-block:: json

    "require": {
        "aeondigital/phpengarde": "dev-master"
    }


_______________________________________________________________________________

Guia de Uso
-----------

.. toctree::
	:maxdepth: 6
	
    Guia de uso <guia/Inicio>
	
	
Namespaces
----------

.. toctree::
	:maxdepth: 6
	
	Interfaces <Interfaces/index>
	MimeHandler <MimeHandler/index>


Classes
-------

.. toctree::
	:maxdepth: 6
	
	DomainApplication <DomainApplication>
	DomainController <DomainController>
	DomainManager <DomainManager>
	RequestHandler <RequestHandler>
	ResponseHandler <ResponseHandler>
	RouteResolver <RouteResolver>
