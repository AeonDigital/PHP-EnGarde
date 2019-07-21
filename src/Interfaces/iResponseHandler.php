<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;








/**
 * Interface para classes que tem como função produzir uma view 
 * que pode ser enviada para o UA.
 * 
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @license     GNUv3
 * @copyright   Aeon Digital
 */
interface iResponseHandler
{





    /**
     * Prepara o objeto "iResponse" com os "headers" e 
     * com o "body" que deve ser usado para responder
     * ao UA.
     *
     * @return      iResponse
     */
    function prepareResponse() : iResponse;
}
