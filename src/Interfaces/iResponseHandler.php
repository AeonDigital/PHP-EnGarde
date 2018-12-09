<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;










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
     * Efetua o envio dos dados para o UA.
     *
     * @return      void
     */
    function sendResponse();
}
