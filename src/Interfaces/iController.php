<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;








/**
 * Interface a ser usada em todas as classes que serão controllers das aplicações.
 * 
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iController
{





    /**
     * Retorna a instância ``iResponse``.
     * Aplica no objeto ``iResponse`` as propriedades ``viewData`` e ``routeConfig`` com os 
     * valores resultantes do processamento da ``Action``.
     * 
     * @return      iResponse
     */
    function getResponse() : iResponse;
}
