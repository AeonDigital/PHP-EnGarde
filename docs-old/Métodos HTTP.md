PHP-AeonDigital\EnGarde : Métodos HTTP
=================================================

> [Aeon Digital](http://aeondigital.com.br)
>
> rianna@aeondigital.com.br  

O presente traz informações gerais sobre as formas de uso e caracteristicas que cada método HTTP tem e assim tentar tornar claro quando cada qual deve ser utilizado.  


&nbsp;  
&nbsp;  


## Caracteristicas gerais
As seguintes caracteristicas podem ser atribuidas aos métodos HTTP:

- `@safe`             São métodos que não causam nenhuma alteração no recurso que estão acessando.
- `@cacheable`        Métodos assim marcados podem utilizar um sistema de cache para armazenar seus resultados.
- `@idempotentes`     
  São métodos cuja URL pode até causar alguma alteração no recurso acessado mas se a mesma URL for executada novamente nada irá alterar.  
  EX : PUT www.app.com/user/31?name=Rianna  
  Se a URL acima for executada, o usuário de ID 31 terá seu atributo "name" alterado para "Rianna" e, se for executada novamente nada ocorrerá pois o atributo "name" já é "Rianna", portanto, o resultado é o mesmo.

&nbsp;  

## HEAD
`@safe`  
`@cacheable`  
`@idempotente`  

Efetua uma requisição explicita.  
Não altera estado algum no servidor.  
Retorna o mesmo cabeçalho que o método GET retornaria mas sem seu corpo.  


> @exemplo  
  HEAD www.app.com/news/12

&nbsp;  

## GET
`@safe`  
`@cacheable`  
`@idempotente`  

Efetua uma requisição explicita.  
Não altera estado algum no servidor.

> @exemplo
  GET www.app.com/news/12

&nbsp;  

## POST
Cria um novo recurso.

> @exemplo
  POST www.app.com/news  
  { "title" : "bla bla bla", "text" : "lorem ipsun...", "img" : null }

**Observação**  
Apesar da especificação HTTP dizer que é preciso reenviar TODOS os campos do recurso, mesmo os que forem vazios ou nulos, tal regra não será usada em 100% dos casos nesta implementação.

&nbsp;  

## PUT
`@idempotente`

Efetua o update de dados no recurso alvo que já existe.

> @exemplo  
  PUT www.app.com/news/12  
  { "title" : "ble ble ble", "text" : "lorem ipsun dolor...", "img" : "url" }

**Observação**  
01 - Apesar da especificação HTTP dizer que é preciso reenviar TODOS os campos do recurso, mesmo os que forem vazios ou nulos, tal regra não será usada em 100% dos casos nesta implementação.  

02 - Apesar da especificação HTTP dizer que, caso o recurso não exista ele possa vir a ser criado, nesta implementação REST esta regra não será utilizada, ou seja, apenas será usado para atualizar e jamais para criar.  

&nbsp;  

## PATCH
Efetua um set de instruções enviado pelo cliente.  
Cada instrução indica o que fazer com um campo ou recurso em epecial.

> @exemplo  
  PATCH www.app.com/news/12  
  [
    { "exec" : "update", "field1" : "title", "field2" : "bli bli bli" },  
    { "exec" : "remove", "field1" : "img" },  
    { "exec" : "changeCategory", "from" : "PHP", "to" : "REST" },  
    { "exec" : "changeState", "state" : "Public" }
  ]

&nbsp;  

## DELETE
`@idempotente`

Exclui definitivamente o recurso alvo.

> @example  
  DELETE www.app.com/news/12

&nbsp;  

## OPTIONS
`@safe`  
`@cacheable`  
`@idempotente`  

Método para desenvolvedores ou bots.  
Retorna as meta-informações sobre o uso da rota indicada.  
Pode retornar dados sobre COMO utilizar cada método em uma rota.  

> @exemplo  
  OPTIONS www.app.com/news/12

&nbsp;  

## TRACE
`@safe`  

Método para desenvolvedores.  
Retorna o mesmo conteúdo que foi enviado originalmente pelo UA.  
Ajuda na verificação do que está sendo enviado e do que o server está recebendo.  

&nbsp;  

## CONNECT
Converte a conexão HTTP para um tunel TCP/IP.

> @exemplo  
  CONNECT www.app.com/connect
