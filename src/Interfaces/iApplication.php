<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;










/**
 * Define uma Aplicação que pode ser manipulada pelo 
 * Gerenciador de Domínio **AeonDigital/EnGarde/DomainManager**.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iApplication
{





    /**
     * Permite configurar ou redefinir o objeto de configuração
     * da aplicação na classe concreta da mesma.
     */
    function configureApplication() : void;



    /**
     * Inicia o processamento da rota selecionada.
     *
     * @return      void
     */
    function run() : void;
}
