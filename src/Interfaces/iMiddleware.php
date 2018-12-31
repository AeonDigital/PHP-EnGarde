<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\iRequestHandler as iRequestHandler;






/**
 * Define uma camada de processo a ser executado para resolver 
 * requisições e assim produzir uma resposta para o UA.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iMiddleware
{

    /**
     * Esta interface é uma especialização da interface
     * "Psr\Http\Server\MiddlewareInterface" mas que utiliza as 
     * classes derivadas das interfaces dos projetos *AeonDigital* para 
     * executar as mesmas tarefas mas com o ganho de algumas funções extras.
     * 
     * Uma vez que todas as classes definidas aqui implementam
     * também as interfaces PSR originais é garantido a compatibilidade entre
     * estes projetos e outros que utilizem Middlewares PSR.
     */





    /**
     * Efetua uma camada do processo de resolução da requisição submetida pelo UA.
     * 
     * Se não for capaz de produzir um objeto response por si mesmo, deve delegar
     * esta responsabilidade para o manipulador padrão.
     *
     * @param       iServerRequest $request
     *              Objeto da requisição HTTP.
     * 
     * @param       iRequestHandler $handler
     *              Manipulador padrão para as requisições.
     * 
     * @return      iResponse
     */
    function process(iServerRequest $request, iRequestHandler $handler) : iResponse;
}
