<?php
declare (strict_types = 1);

use AeonDigital\EnGarde\DomainManager as DomainManager;

// Carrega o autoload gerado pelo "Composer".
require_once "/vendor/autoload.php";

// Carrega as configurações gerais do domínio.
require_once "domain-config.php";

// Inicia uma instância do gerenciador de domínio
// e efetua o processamento da requisição.
$enGarde = new DomainManager();
$enGarde->run();
