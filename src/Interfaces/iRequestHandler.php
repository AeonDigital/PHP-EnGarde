<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;







/**
 * Responsável por manipular uma requisição e 
 * processar a action alvo.
 * 
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @license     GNUv3
 * @copyright   Aeon Digital
 */
interface iRequestHandler
{

    /**
     * Esta interface é uma especialização da interface
     * "Psr\Http\Server\RequestHandlerInterface" mas que utiliza as 
     * classes derivadas das interfaces dos projetos *AeonDigital* para 
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
