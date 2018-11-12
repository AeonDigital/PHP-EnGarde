<?php
/**
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */





 /**
 * Array contendo o nome de cada aplicação que está 
 * hospedada no domínio.
 * 
 * @var     HOSTED_APPS
 */
const HOSTED_APPS = ["NewApplication", "Application02"];
/**
 * Nome da aplicação padrão para o domínio atual.
 * 
 * @var     DEFAULT_APP
 */
const DEFAULT_APP = "NewApplication";



/**
 * Informa o tipo de ambiente onde a aplicação está rodando no momento.
 *
 * Esta constante só causa algum efeito perceptível se for devidamente
 * implementada pelas soluções instaladas no domínio.
 *
 * Valores comuns : "production", "development, "local", "test"
 *
 * @var     ENVIRONMENT
 */
const ENVIRONMENT = "local";
/**
 * Indica se a aplicação está em debug mode.
 *
 * Esta constante só causa algum efeito perceptível se for devidamente
 * implementada pelas soluções instaladas no domínio.
 *
 * Sua principal função é configurar saidas de erros ou retorno de dados
 * para auxilio dos desenvolvedores.
 *
 * @var     bool
 */
const DEBUG_MODE = true;



/**
 * Quando "true" irá reprocessar as rotas a cada requisição feita.
 *
 * @var     bool
 */
const UPDATE_ROUTES = true;



/**
 * Define o timezone do domínio.
 * [Lista de fusos horários suportados](http://php.net/manual/en/timezones.php)
 * 
 * @var     string
 */
const DATETIME_LOCAL = "America/Sao_Paulo";



/**
 * Define o tempo máximo (em segundos) para a execução das requisições.
 * 
 * @var     integer
 */
const REQUEST_TIMEOUT = 1200;
/**
 * Define o valor máximo (em Mb) para o upload de um arquivo.
 * Este valor é usado caso não seja especificado outro na rota que está
 * sendo executada.
 * 
 * @var     integer
 */
const REQUEST_MAX_FILESIZE = 100;
/**
 * Define o valor máximo (em Mb) para a postagem de dados.
 * 
 * @var     integer
 */
const REQUEST_MAX_POSTSIZE = 100;



/**
 * Nome das classes que iniciam as aplicações do domínio.
 * 
 * @var     string
 */
const APPLICATION_CLASSNAME = "AppStart";



/**
 * Página de erros que deve ser mostrada para o UA caso
 * nenhuma outra tenha sido definida pela aplicação que
 * deve ser executada.
 * 
 * O caminho deve ser definido a partir do diretório
 * raiz do domínio.
 * 
 * @var     string
 */
const DEFAULT_ERROR_VIEW = "errorView.phtml";
