<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Http;

use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;








/**
 * Interface para classes que tem como função produzir uma view que pode ser enviada para o ``UA``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iResponseHandler
{





    /**
     * Prepara o objeto ``iResponse`` com os ``headers`` e com o ``body`` que deve ser usado
     * para responder ao ``UA``.
     *
     * @return      iResponse
     */
    function prepareResponse() : iResponse;
}
