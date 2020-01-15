<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;










/**
 * Define uma Aplicação que pode ser manipulada pelo Gerenciador de Domínio 
 * ``AeonDigital/EnGarde/DomainManager``.
 * 
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iApplication
{





    /**
     * Permite configurar ou redefinir o objeto de configuração da aplicação na classe concreta 
     * da mesma.
     */
    function configureApplication() : void;



    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
    function run() : void;
}
