PHP-EnGarde : Arquitetura e estilo de codificação
=================================================

> [Aeon Digital](http://aeondigital.com.br)
>
> rianna@aeondigital.com.br  

O presente documento versa sobre arquitetura, estrutura, forma e conteúdo da disposição e escrita do código usado para o presente framework.  
Para a compreenção do funcionamento deste é necessário um entendimento mínimo sobre REST.  


&nbsp;  
&nbsp;  

_______________________________________________________________________________________________________________________


**Sobre REST, RESTfull, RESTlike e RESTless**

> Por vários motivos que não cabem nesta documentação explainar, foi decidido que esta seria uma aplicação RESTlike sendo que, tanto quanto possível os padrões e comportamentos experados para uma aplicação REST serão observados e seguidos.  

&nbsp;  

**Importante**  

Tenha em mente que em algumas vezes, neste e em outros projetos *AeonDigital* optou-se de forma consciênte em não utilizar uma ou outra regra de otimização dos artefatos de software quando foi percebida uma maior vantagem para a equipe de desenvolvimento em flexibilizar tal ponto do que extritamente seguir todas as regras de otimização.  

&nbsp;  

**Compatibilidade**  

O presente framework foi desenvolvido utilizando o PHP 7.1 por acreditarmos que a partir desta versão uma série de features da linguagem trará um amadurecimento importantissimo para seu ecossistema presente e futuro. As soluções que envolvem banco de dados foram desenvolvidas e testadas com o uso do MySql na versão 5.5.38  


&nbsp;  
&nbsp;  

_______________________________________________________________________________________________________________________


## Arquitetura e funcionamento
Este framework foi desenvolvido para servir aplicações a partir de um domínio ou subdomínio gerenciando toda requisição HTTP que for destinado para tal. Para tanto, o servidor web (Apache, IIS ou outro) deve contar com um uma configuração que aponte toda requisição para o arquivo [index.php](index.php) que deve ficar no diretório raiz do site.  


&nbsp;  
&nbsp;  


### Estrutura de diretórios
O seguinte modelo representa como deve ser a disposição dos arquivos e subdiretórios dentro de um domínio.

```
Root/
└── vendor/                 [ Diretório padrão para os subprojetos que sustentam o atual ]
    ├── aeondigital/
    ├── psr/
    |
    ├── Application01       [ As aplicações tem seu próprio esquema estrutural que está documentado em outro tópico ]
    ├── Application02
    | 
    ├── .htaccess           [ para servidor APACHE ]
    ├── .gitignore  
    ├── index.php  
    ├── HUMANS.txt  
    ├── LICENCE.md  
    ├── README.md  
    ├── ROBOTS.txt  
    └── web.config          [ para servidor IIS ]
```


&nbsp;  
&nbsp;  

_______________________________________________________________________________________________________________________


## Estilo de codificação
Os projetos desenvolvidos pela *AeonDigital* seguem as recomendações PSR de desenvolvimento de código.  
Para maiores informações sobre estas regras e estilo de codificação os seguintes links podem ser visitados.  

1. [PSR 1 - Basic Coding Standard](http://www.php-fig.org/psr/psr-1/)
2. [PSR 2 - Coding Style Guide](http://www.php-fig.org/psr/psr-2/)
3. [PSR 3 - Logger Interface](http://www.php-fig.org/psr/psr-3/)
4. [PSR 4 - Autoloader](http://www.php-fig.org/psr/psr-4/)
5. [PSR 5 - PHPDoc Standard](https://github.com/phpDocumentor/fig-standards/tree/master/proposed)

&nbsp;  

### Strict Type
Por padrão, todos projetos PHP *AeonDigital* foram desenvolvidos utilizando **strict_types = 1** para forçar que o código possua uma checagem forte quanto aos tipos de dados usados. Encorajamos todo desenvolvedor a prosseguir com esta prática e usar em seus próprios scripts sempre esta configuração do PHP.  

&nbsp;  

### Destaques das regras PSR
Segue uma breve descrição das regras PSR 1 e 2 que devem ser seguidas:

#### Arquivos
  - SEMPRE usar UTF-8 sem BOM para código PHP.
  - Usar SEMPRE Unix LF (linefeed) ao final das linhas.
  - Todos os arquivos devem terminar com uma linha em branco.
  - Tente separar arquivos que definem simbolos (classes, funções, constantes...) daqueles que geram código de output.

#### Arquivos de código PHP
  - Usar APENAS as tags \<?php ou \<?= ?>
  - Quando um arquivo possuir apenas código PHP a tag ?> deve ser omitida.

#### Namespaces
  - Namespaces e classes devem seguir regras de autoloading definidos no PSR 4.

#### Organização do código
  - O código DEVE usar identação de 4 espaços (e não tabs).
  - Uma linha de código DEVE ter até 80 caracteres, mas em casos especiais este limite pode ser de até 120.
  - DEVE haver 1 linha em branco após a declaração de "namespaces".
  - DEVE haver 1 linha em branco após a declarações "use".

##### Declaração de simbolos
  - Classes DEVEM ser declaradas em StudlyCaps.
  - Constantes DEVEM ser declaradas em UPPERCASE podendo ter "_" como separador.
  - Métodos DEVEM estar declarados em camelCase.
  - As "{}" de abertura e fechamento de uma classe DEVEM estar cada qual em uma linha só sua.
  - As "{}" de abertura e fechamento de um método DEVEM estar cada qual em uma linha só sua.
  - Visibilidade (public | protected | private) de propriedades e métodos DEVEM ser SEMPRE declarados.
  - As definições "abstract" e "final" devem ser declaradas ANTES da definição de visibilidade.
  - A definição "static" DEVE ser declarada APÓS a declaração de visibilidade.
  - Usar preferencialmente "elseif" ao invés de "else if". 
  - Estrutura de controle (if | switch | do | while | for | foreach) DEVEM ter um espaço após.
  - Estruturas de controle DEVEM ter seu "{" de abertura na mesma linha (após o espaço definido acima).
  - O "}" de fechamento de estruturas de controle DEVEM estar em uma linha só sua.
  - Não devem haver espaços entre os parenteses de estruturas de controle e seu conteúdo interno.
  - As constantes "true", "false" e "null" DEVEM estar SEMPRE em lowercase.

&nbsp;  

Entre todas as regras PSR descritas acima há outras que estão na descrição dos respectivos links e aqui foram 
omitidas por serem pouco utilizadas mas devem ser conhecidas pelos desenvolvedores que desejam manter ou desenvolver 
código PHP com alta qualidade.  

&nbsp;  

## UTF-8
Importante atentar para SEMPRE utilizar como padrão o UTF-8 tanto para os arquivos PHP, HTML, CSS, JS, XML, JSON ou 
qualquer outro que venha a ser servido ou distribuído para os usuários exceto em casos onde tecnicamente isto 
realmente não é possível ou quando por algum motivo justificável tal opção não é recomendada.  
Estas mesmas orientações servem para o armazenamento de informações nos bancos de dados.
