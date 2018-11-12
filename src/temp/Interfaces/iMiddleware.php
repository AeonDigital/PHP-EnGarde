<?php
declare (strict_types = 1);

namespace AeonDigital\AeonDigital\EnGarde\Interfaces;

use AeonDigital\AeonDigital\EnGarde\Interfaces\iRequestHandler as iRequestHandler;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;






/**
 * Define um processo a ser executado para resolver requisições e 
 * produzir uma resposta para o UA.
 * 
 * @package     AeonDigital\AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iMiddleware
{

    /**
     * Esta interface é uma especialização da interface
     * "Psr\Http\Server\RequestHandlerInterface" que utiliza as respectivas
     * implementações *AeonDigital* para executar as mesmas tarefas mas com 
     * o ganho de suas funções extras.
     * 
     * Uma vez que todas as classes definidas aqui implementam
     * também as interfaces PSR originais é esperado que tais aplicações
     * possam usar Middlewares PSR.
     * 
     * Já os Middlewares que usarem esta interface poderão receber os 
     * respectivos objetos *AeonDigital* e assim usufruir das facilidades
     * extra adicionadas nos mesmos.
     */





    /**
     * Processa a requisição submetida pelo UA.
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
    public function process(iServerRequest $request, iRequestHandler $handler) : iResponse;
}
