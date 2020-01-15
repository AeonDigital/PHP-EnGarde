PHP-EnGarde : Sequestrando Requisições HTTP
============================================

> [Aeon Digital](http://aeondigital.com.br)
>
> rianna@aeondigital.com.br  

O objetivo deste documento é fornecer de maneira explicita o que ocorre quando uma requisição é feita para um domínio comandado pelo Framework EnGarde.  
Cada etapa é recheada de informações que explicam o que está ocorrendo em cada fase desde o preparo do próprio ambiente até a resposta que será servida.  


# Preparos preliminares

Antes de iniciar uma requisição é preciso que o ambiente esteja devidamente instalado. Como regra fundamental é necessário que TODAS as requisições sejam direcionadas por meio de regras de servidor (definidas no [.htaccess](.htaccess), [web.config](web.config) ou equivalente) para o arquivo [index.php](index.php) que deve estar na raiz do domínio.  


&nbsp;  
&nbsp;  


# index.php
Neste ponto é feito o registro do *autoloader* do Composer e carregado o arquivo de configuração de Domínio [domain-config.php](domain-config.php). Após, uma instância do Gerenciador do Domínio *AeonDigital\DomainManager* será iniciada.  


&nbsp;  
&nbsp;  


## Gerenciador do Domínio
Ao iniciar, internamente os seguintes objetos serão configurados:

- 1. `AeonDigital/Http/Tools/Interfaces/iServerConfig`  
     Usando informações do próprio servidor onde o software está rodando.
- 2. `AeonDigital/EnGarde/Interfaces/iDomainConfig`  
     Usando informações constantes em [domain-config.php](domain-config.php)
- 3. `AeonDigital/EnGarde/ErrorListening`  
     Usando informações do servidor e do domínio.
- 4. `AeonDigital/EnGarde/Interfaces/iApplicationConfig`  
     Usando informações da configuração do domínio, identificará a aplicação a ser executada.
- 5. `AeonDigital/EnGarde/iApplicationRouter`  
     Usando informações básicas da instância de configuração da aplicação alvo.

&nbsp;  


### Configurando uma Aplicação
Todo o código de cada Aplicação deve estar contido em um diretório na raiz do Domínio. Este diretório deve ter o mesmo nome da própria Aplicação (case-sensitive) e este também será a particula da primeira parte de uma URL que visa atinjí-la (as aplicações configuradas como sendo padrão do domínio permitem URLs onde tal partícula seja omitida).  

&nbsp;  

No diretório raiz de cada Aplicação deverá constar uma classe de nome igual ao informado na constante **APPLICATION_CLASSNAME** do arquivo [domain-config.php](domain-config.php). Sua namespace deverá ser SEMPRE o próprio nome da Aplicação (case-sensitive) e esta classe DEVE herdar a classe abstrata *AeonDigital/EnGarde/Application*.

&nbsp;  

#### Iníciando o processamento de uma Requisição
Até o momento apenas ocorreu a configuração do Domínio e foi identificada qual Aplicação deveria responder a requisição.  
Uma vez que o método *iApplication->run()* for acionado é que a Aplicação alvo irá efetivamente iniciar o trabalho e para isso ela irá inicialmente 
Ao executar seu método *run*, a instância da Aplicação irá iniciar um objeto de configuração de aplicações (*iApplicationConfig*) e tentará se autoconfigurar usando o método abstrato *configureApplication* que deve ser implementado nas respectivas classes de cada uma das aplicações existentes e registradas. Neste momento todas personalizações devem ser resolvidas para que entrem logo em vigor.  

Uma instância de Aplicação pode ser configurada em parte pelas configurações resultantes de inferências feitas para 















## Inicia uma instância da classe \AeonDigital\EnGarde
Aqui é iniciada uma instância da classe "\AeonDigital\EnGarde" que será a responsável por resolver totalmente a requisição 
realizada.


--


## Exemplo
Para fins desta ludica explanação vamos considerar que o conteúdo do script "index.php" no momento é o seguinte:


~~~~ php
declare (strict_types = 1);

use AeonDigital\CodeCraft\AeonDigital\EnGarde\AeonDigital\EnGarde as AeonDigital\EnGarde;

const ENVIRONMENT   = "local";
const DEBUG_MODE    = true;
const UPDATE_ROUTES = true;

require_once "vendor/AeonDigital/CodeCraft/ini.php";

$ccAeonDigital\EnGarde = new AeonDigital\EnGarde([
    "rootPath"      => $_SERVER["DOCUMENT_ROOT"],
    "hostedApps"    => ["Site", "BackStage"],
    "defaultApp"    => "Site",
    "dateTimeLocal" => "America/Sao_Paulo",
    "timeOut"       => 1200,
    "maxFileSize"   => 100,
    "maxPostSize"   => 100
]);
~~~~



--





# Objeto de contexto
Ao longo do processamento de uma requisição a aplicação vai incrementando o objeto de contexto e passando-o a frente conforme as responsabilidades são transferidas de uma classe a outra.
Este objeto de contexto tem como principais membros:

- request       : que traz dados referentes à requisição em si.
- AeonDigital\EnGarde        : carrega informações de configuração do domínio.
- application   : configurações da aplicação que foi selecionada para resolver a requisição.
- response      : dados que serão devolvidos ao UA.

Estes objetos estão devidamente documentados em [ContextObject.md](ContextObject.md).


--





# Passo 1 - Iniciando uma requisição
Como podemos ver acima, o domínio está sendo iniciado em um ambiente "local" e possui tanto a constante "DEBUG\_MODE" quanto "UPDATE\_ROUTES" com valores "true".

A instância "$ccAeonDigital\EnGarde" criada do objeto "\AeonDigital\EnGarde" está configurada para comportar os projetos "Site" e "BackStage" sendo que a aplicação padrão é definida como sendo o "Site". Isso significa que se o UA omitir o nome da aplicação em uma requisição a URL será procurada dentro da aplicação "Site".

As demais opções de configuração podem ser conferidas dentro do script da classe "\AeonDigital\EnGarde".


--


**Iniciando uma requisição**
A seguinte requisição será usada para prosseguir com o exemplo:

> GET http://AeonDigital\EnGardename.com/searchby/beatles/3/asc





## 1.1 - Recebendo a requisição
Quando uma requisição chega, como vimos acima, é iniciado um objeto "\AeonDigital\EnGarde" com as configurações definidas no "index.php".
Internamente a primeira coisa que o construtor desta classe faz é coletar todas as informações que vem com uma requisição e a partir destes dados ele monta o objeto "request". Todo o processamento a seguir é resultado do uso destes dados.

Com a requisição de exemplo em curso, o sistema identifica que a aplicação a ser executada é a padrão (Site) pois nem seu nome e nem a outra aplicação configurada estão definidas no corpo da requisição.
Se quisessemos, poderiamos reescrever aquela URL da seguinte forma:

> GET http://AeonDigital\EnGardename.com/Site/searchby/beatles/3/asc

com esta nova parte "/Site/" estamos indicando explicitamente que queremos executar esta aplicação mas o efeito será exatamente o mesmo que se o ocultarmos. Já se fosse usado:

> GET http://AeonDigital\EnGardename.com/BackStage/searchby/beatles/3/asc

o sistema iria executar o roteador dentro da aplicação "BackStage" pois estariamos evocando-a explicitamente.

-

Uma vez que não existam erros no processamento da classe "\AeonDigital\EnGarde" será iniciará a classe "\AppConfig" da aplicação selecionada. No caso estamos falando de "\Site\AppConfig".





## 1.2 - Objeto de contexto "AeonDigital\EnGarde"
Assim como o objeto "request", o objeto "AeonDigital\EnGarde" é preenchido neste momento mas seu uso tem uma importancia menor para os fins do presente documento.





## 1.3 - Manter em mente
Lembre-se que o objeto "request" traz em sí uma série de valores que especificam o que o UA deseja receber em termos de formato da resposta (mimetype que será usado) assim como a lingua que o UA prefere. Estas informações serão importantes para a produção de uma resposta adequada.

Abaixo está a listagem de parametros que podem ser informados via querystring ou via POST que tem capacidade de alterar os valores padrões enviados em uma requisição:

**_method** 
Permite definir explicitamente qual método deve ser usado para responder a requisição.

**_locale**
Força a aplicação a tentar responder com o locale especificado caso ele conste nas configurações da mesma.

**_mime**
Força a aplicação a tentar responder a requisição devolvendo os dados no formato indicado.

**\_pretty_print**
Quando for requisitado uma saída em formato JSON, HTML, XHTML ou XML, se este parametro existir e for "true" ou "1", forçará a identação do resultado para facilitar a leitura.

**_download**
Permite forçar ou impedir o download de uma requisição.




# Passo 2 - Iniciando a Aplicação Alvo
A partir deste ponto o protagonismo do processamento passa para a aplicação que irá de fato responder pela requisição.
Lembrando que a aplicação alvo é sempre definida na primeira parte da URL posterior ao nome completo do domínio e não constando nesta porção um nome de uma das aplicações instaladas o sistema considerará que o UA está tentando atinjir uma URL da aplicação apontada como padrão (que para fins deste exemplo é a "Site").

Ao final do construtor da classe "\AeonDigital\EnGarde", já de posse do conteúdo tratado do objeto "request" o sistema irá iniciar a aplicação alvo evocando sua classe "\AppConfig" que deve estar presente no diretório raiz daquela aplicação e deve obrigatoriamente herdar a classe abstrata "\AeonDigital\CodeCraft\AeonDigital\EnGarde\Application".

Ao implementar esta herança, a classe "\AppConfig" deverá implementar o método "setConfiguration".
Para fins deste exeplo, considere este método executando as linhas abaixo:

~~~~ php
protected function setConfiguration() : void
{
    // Inicia as configurações da aplicaçaão. 
    $this->setDefaultConfiguration();
    
    $this->context->application->locales                = ["pt-BR", "en-US"];
    $this->context->application->defaultLocale          = "pt-BR";
    $this->context->application->useLabels              = true;
    $this->context->application->isXHTML                = true;

    // ...
}
~~~~



## Passo 2.1 - "\AppConfig->setConfiguration()"
A seguinte sequencia de eventos serão disparados assim que for criada uma instância do objeto "\AppConfig" da aplicação alvo:

1. \AeonDigital\CodeCraft\AeonDigital\EnGarde\Application->__construct()
2. \Site\AppConfig->setConfiguration()
3. \AeonDigital\CodeCraft\AeonDigital\EnGarde\Application->setDefaultConfiguration()

Note que ao iniciar o construtor da classe abstrata "\Application", esta irá evocar o método "setConfiguration" definido obrigatoriamente em todas as classes "\AppConfig".
Este método pode ou não evocar o método "setDefaultConfiguration" presente na classe abstrata "\Application". Se ele for evocado, tratará de iniciar adequadamente (e conforme os padrões definidos) todas as propriedades do objeto de contexto "application".

O desenvolvedor tem a opção de realizar todas as configurações do objeto "application" diretamente em "setConfiguration" se desejar.
Alem disso ele pode, assim como no exemplo de código acima, evocar o método "setDefaultConfiguration" para que este preencha adequadamente as propriedades conforme o padrão e logo em seguida altere aquelas que realmente importam para a aplicação corrente.

No exemplo acima, o desenvolvedor optou por deixar o Framework definir todas as propriedades da aplicação e editou apenas algumas.

Para melhores informações sobre o objeto "application" procure sua descrição em [ContextObject.md](ContextObject.md).

Sobre o código acima é importante notar que a aplicação foi definida como sendo poliglota e suportando as linguagens "pt-BR" e "en-US" sendo que a primeira foi considerada a padrão. Em adição foi adicionado suporte a legendas (assunto que será visto adiante) e definido o uso de XHTML para os UAs que suportam este formato (identificados pela propriedade "acceptMimes" do objeto "request").



## Passo 2.2 - "Iniciar o Roteador"
Imediatamente após iniciar as configurações da aplicação o Framework irá iniciar o roteador.
O roteador padrão usado pelas aplicações é o "\AeonDigital\CodeCraft\AeonDigital\EnGarde\Modules\Router" e implementa de "\AeonDigital\Interfaces\AeonDigital\EnGarde\iRouter". Sua função é a de processar a URL que o UA está requisitando e identificar qual controller e action irá responde-lo.

Uma outra responsabilidade desta classe é a de identificar entre os controllers da aplicação se houve alguma alteração em seus arquivos e comparar com a data de criação do arquivo "AppRoutes.php" da aplicação corrente. Se houver alguma modificação posterior nos controllers, esta classe irá refazer o "AppRoutes.php".
Esta ação pode ser impedida alterando o valor da constante "UPDATE_ROUTES" para "false".

Uma vez que a verificação da necessidade de atualizar o "AppRoutes.php" foi resolvida o próximo passo é justamente carregá-lo e então rodar o seletor de rotas que irá, com base nas regras encontradas para as rotas, encontrar a que mais apropriadamente corresponde ao que foi pedido pelo UA.

O resultado final do processamento do roteador será a definição da propriedade "routeConfig" do objeto "response" que está descrito em [ContextObject.md](ContextObject.md) e esmiuçado em [RouteRules.md](RouteRules.md).



## Passo 2.3 - "Negociação de conteúdo"
Independente do método que está sendo requisitado a aplicação irá iniciar um objeto "ContentNegotiation" que será responsável por inferir (a partir dos dados de contexto atuais) que tipo de documento deve ser devoldido ao UA (refere-se à lingua que deve ser usada e formato do documento).

Caracteristicas que podem ser negociadas neste momento:

1. _locale
   Indica explicitamente em qual lingua o UA deseja receber a resposta.
2. _mime
   Informa explicitamente o mimetype que deve ser usado para responder ao UA.
3. \_pretty_print
   Para respostas do tipo JSON, HTML, XHTML ou XML, quando "true" ou "1" irá identar os dados para facilitar a leitura.
4. _download
   Permite forçar ou impedir o download do conteúdo requisitado.
   
Todos os pontos acima podem ser ignorados quando seus valores não se aplicam à requisição ou contexto alvo.



## Passo 2.4 - Resposta para OPTIONS e TRACE
Os métodos "OPTIONS" e "TRACE" são respondidos não pela aplicação mas sim pelo Framework pois tratam-se de meta-informações coletadas da aplicação em si.

- OPTIONS : Retorna as meta-informações sobre o uso da rota indicada.
- TRACE : Retorna o mesmo conteúdo que foi enviado originalmente pelo UA (objeto "request").



## Passo 2.5 - Resposta para demais Métodos
Os métodos "GET", "HEAD", "POST", "PUT", "PATCH" e "DELETE" são retornados ao UA de maneira especial pois eles podem possuir um corpo (como uma página HTML por exemplo ou um documento XML ou JSON).

O processamento desta etapa se dá em 3 partes e é realizado no objeto "ProcessAction":



### Passo 2.5.1 - Etapa 1
Primeiramente o Framework certifica-se que as variáveis de contexto estarão todas preparadas para evocar a "action" alvo.



### Passo 2.5.2 - Etapa 2
Aqui a action alvo é efetivamente evocada.
Devido a natureza e proposta deste Framework NENHUM dado deve ser enviado para o UA neste momento, ou seja, o uso dos comandos "echo", "var\_dump", "print\_r", "header" e qualquer outro que envie dados para o UA não devem ser cogitados exceto para fins de debug.

Esta etapa cuida especificamente de processar e coletar os dados que serão usados para a criação da resposta que será enviada para o UA. Para comunicar-se com os documentos que formam a "view" o desenvolvedor deve fazer uso do objeto "$this->response->viewData".
Este objeto é um array associativo que pode ser usado livremente para os fins aos quais foi concebido (você pode conhecer mais sobre esta e outras propriedades em [ContextObject.md](ContextObject.md) ).

Nesta etapa, ainda dentro do processamento da "action" alvo o desenvolvedor tem a possibilidade de alterar várias propriedades do objeto de contexto "response". Desta forma ele pode configurar mais apropriadamente situações que o Framework não previu ou que não cabe aos propósitos gerais da resolução comum de uma rota. As propriedades que podem ser alteradas livremente estão descritas no documento [ContextObject.md](ContextObject.md) e são marcadas com um "[a]" ao lado de seu nome.



### Passo 2.5.2 - Etapa 3
Neste momento o Framework irá assegurar-se de que as propriedades imutáveis permanecem intactas e fará outras verificações menores para permitir que o processamento possa prosseguir.



## Passo 2.6 - Compilar o corpo da resposta
Após o processamento da action o Framework começa a processar o corpo de dados que serão retornados ao UA.
Há casos onde não é necessário criar uma "view" de retorno e neste caso esta etapa terá menos importância.

Dentro dos documentos ".phtml" usados para a confecção das "views" o desenvolvedor tem acesso a todas as definições de contexto mas o Framework prepara para ele alguns "wrappers" para facilitar o uso dos valores mais comuns. Abaixo segue uma lista dos objetos que o desenvolvedor pode desejar acessar a partir de dentro de uma "view".

1. $this->context
   O próprio objeto de contexto trazendo TODAS as informações coletadas até o momento.
2. $this->parans
   "wrapper" para "$this->context->request->parans"
3. $this->response
   "wrapper" para "$this->context->response"
4. $this->viewData
   "wrapper" para "$this->context->response->viewData"

Imediatamente após efetuar (ou não, conforme o caso) a montagem da "view" o conteúdo gerado ficará sujeito ao processamento do seu manipulador específico (cada mimetype possível de ser retornado deve ter um objeto "MimeHandler" equivalente).

Este último processamento será responsável por tratar os dados coletados até aqui e organizá-los de forma que possam ser consumidos conforme o mimetype requisitado.

**Legendas**
Saiba mais sobre como usar legendas no documento [Labels.md](Labels.md).



## Passo 2.7 - Enviar resposta ao UA
Uma vez que o Framework compilou todo o corpo da requisição é hora de enviar de volta para o UA.
Neste ponto serão feitos os envios de "Headers" e conforme o método HTTP selecionado o conteúdo será finalmente remetido para o cliente.
