 Testes unitários com PHPUnit
==============================

Todos projetos da AeonDigital disponíveis publicamente tem uma razoável cobertura de seu código (geralmente aproximando-se de 100%), oferecendo assim uma robusta documentação executável para um melhor controle da qualidade do código oferecido.  

Para executar os testes é necessário que você tenha o PHPUnit instalado em seu computador.  
Abaixo seguem as orientações para executar a instalação e a execução.  


&nbsp;  
&nbsp;  


## Instalação
O PHPUnit é distribuido no formato **phar** que pode ser convertido em um comando executável conforme o ambiente que você está usando. 


&nbsp;  
&nbsp;  


### Linux

  - Acesse o Terminal e baixe-o:
  > sudo wget https://phar.phpunit.de/phpunit.phar
  - Altere o nome do arquivo baixado para **phpunit.phar**.
  > mv phpunit-x.x.x.phar phpunit.phar
  - Torne-o executável:
  > chmod +x phpunit.phar
  - Mova-o para a pasta de binários local:
  > sudo mv phpunit.phar /usr/local/bin/phpunit
  - Verifique:
  > phpunit --version

&nbsp;  

### Windows

  - Baixe o arquivo **phar** em https://phar.phpunit.de/phpunit.phar
  - Altere o nome do arquivo baixado para **phpunit.phar**.
  - Abra um terminal (como administrador) e vá até o diretório onde o arquivo está salvo.
  - Torne-o executável com o comando:
  > echo @php "%~dp0phpunit.phar" %* > phpunit.cmd
  - Mova o arquivo para um local que faça parte da Variável de Ambiente "PATH".
  - Verifique:
  > phpunit --version


&nbsp;  
&nbsp;  


## Configuração para o VSCode (plugin)
Após fazer a instalação do PHPUnit você pode usar o Plugin PHPUnit para o VSCode.
Lembre-se de adicionar as seguintes definições nas configurações de usuário:

> "phpunit.execPath": "C:/phpunit/phpunit.cmd",  
> "phpunit.args": [  
>   "--debug", "--verbose"  
>  ]


&nbsp;  
&nbsp;  


## Executando
Abra um terminal (bash, cmd, PowerShell) e vá até o diretório onde está o arquivo de configuração **phpunit.xml**.  
Este arquivo já está preparado com as configurações necessárias para a execução dos testes de cada projeto AeonDigital.  

&nbsp;  

Para um teste completo use o seguinte comando:
> phpunit --configuration "phpunit.xml" --verbose --debug

Para executar todos os testes de uma classe de testes:
> phpunit <TestClassName> <PathToTestFile.php>

Para um teste de apenas 1 método em uma classe de testes:
> phpunit --filter <TestMethodName> <TestClassName> <PathToTestFile.php>

&nbsp;  

### Teste de cobertura
Um teste de cobertura irá verificar o percentual do código que está sendo verificado pelos testes unitários.  
Use o comando:

  > phpunit --coverage-html "cover" --verbose --debug

Será criado um diretório "cover" com o resultado.  


&nbsp;  
&nbsp;  


### Uso
Se você é novato no uso do PHPUnit pode ser importante estar ciente das sequintes informações:

  - Ao escrever os testes, você só será capaz de usar "require" e "require_once" se usar o caminho completo até os arquivos alvo.
  - Nos testes de cobertura, se precisar ignorar algum trecho de código como uma classe ou uma função, use a seguinte marcação:
  > @codeCoverageIgnore
  - Nos testes de cobertura, para ignorar um trecho específico de código (como apenas algumas linhas), use a seguinte marcação:
  > // @codeCoverageIgnoreStart  
  >  ...  
  > // @codeCoverageIgnoreEnd


&nbsp;  
&nbsp;  

_______________________________________________________________________________________________________________________

# Menu
  - [README](../README.md)
  - [PHPUnit](../tests/phpunit.md)
  - [PHPDoc](../docs/phpdoc.md)
