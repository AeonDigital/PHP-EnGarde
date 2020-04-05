<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Http;

use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;







/**
 * Responsável por manipular uma requisição e processar a action alvo.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iRequest
{

    /**
     * Esta interface é uma especialização da interface
     * ``Psr\Http\Server\RequestHandlerInterface`` mas que utiliza as
     * classes derivadas das interfaces dos projetos ``AeonDigital`` para
     * executar as mesmas tarefas mas com o ganho de algumas funções extras.
     *
     * Uma vez que todas as classes definidas aqui implementam
     * também as interfaces PSR originais é garantido a compatibilidade entre
     * estes projetos e outros que utilizem Middlewares PSR.
     */





    /**
     * Processa a requisição e produz uma resposta.
     *
     * @param       iServerRequest $request
     *              Requisição que está sendo executada.
     *
     * @return      iResponse
     */
    function handle(iServerRequest $request) : iResponse;
}
