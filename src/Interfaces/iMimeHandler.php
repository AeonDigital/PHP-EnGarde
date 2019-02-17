<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;










/**
 * Interface para gerar um manipulador capaz de gerar uma
 * resposta adequada a um determinado tipo mime.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iMimeHandler
{





    /**
     * Gera uma string que representa a resposta a ser enviada
     * para o UA, compatível com o mimetype que esta classe está
     * apta a manipular.
     * 
     * @return      string
     */
    function createResponseBody() : string;
}