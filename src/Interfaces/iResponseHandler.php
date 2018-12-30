<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;








/**
 * Interface para classes que tem como função produzir uma view e 
 * enviar o resultado para o UA conforme as exigências da requisição
 * feita pelo UA em conjunto com as configurações da rota alvo.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
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



    /**
     * Efetivamente envia os dados para o UA.
     *
     * @return      void
     */
    function sendResponse() : void;
}
