PHP-EnGarde : Configurando o Domínio
=====================================

> [Aeon Digital](http://aeondigital.com.br)
>
> rianna@aeondigital.com.br  

Este documento traz informações gerais dos preparos que o/s desenvolvedor/es deve/m ter para configurar um domínio antes que o mesmo comece a ser utilizado.  


&nbsp;  
&nbsp;  


## Constantes de Configuração
Uma vez que a requisição HTTP seja direcionada para o arquivo [index.php](index.php) será dado início ao procedimento de receber, processar e devolver o resultado daquela requisição. Porém, antes de efetivamente iniciar alguma aplicação, o próprio domínio precisa ser iniciado, e, para tanto, uma coleção de constantes precisam ser definidas no arquivo [domain-config.php](domain-config.php) que também deve ficar no diretório raiz da aplicação (junto com o *index.php*).  

Neste arquivo estão uma série de constantes que devem ser corretamente preenchidas para que o domínio funcione de acordo com o esperado portanto é importante conhecer tais constantes para ter uma compreenção maior dos comportamentos gerais que são possíveis de serem alterados por ali.  


&nbsp;  
&nbsp;  


### Manipulador de erros e exceções  
Por padrão o ambiente será configurado a tratar de maneira particular os erros/falhas que ocorram durante o processamento das requisições. A forma de tratamento dos erros pode ser alterada conforme as definições das constantes "ENVIRONMENT" e "DEBUG_MODE" 
além do próprio método HTTP que está sendo usado.  


#### Classe "ErrorListening"
Esta classe é a que controla o fluxo de acontecimentos quando um *error* ou *exception* for disparado. Abaixo segue uma breve descrição do que é esperado que ocorra conforme as configurações definidas para o domínio.  

<pre>
SE "ENVIRONMENT" == ("production" || "development" || "local")
  falhas podem ser amostradas de 2 formas.

  SE a requisição HTTP for um "GET"
    O gerenciador do domínio irá identificar se a Aplicação possui uma View preparada para ser amostrada em casos de erro.  
    Esta configuração é feita no módulo de cada aplicação com a definição da constante "ERROR_PAGE_VIEW".  
    Caso esta constante não esteja definida, o módulo que trata erros irá montar uma view padrão usando o seu método "createNonStyleErrorPage".  

  SE a requisição HTTP não for "GET"  
    As informações de erro serão mostradas em um objeto JSON.  

  Importante notar que o "tracelog" só será mostrado quando a constante "DEBUG_MODE" for "true".  

QUANDO "ENVIRONMENT" == "test"  
  O objeto "viewData" que seria usado para gerar a resposta para o UA é retornado integralmente.  
</pre>
