<?php
declare (strict_types = 1);

namespace AeonDigital\AeonDigital\EnGarde\Interfaces;

use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;







/**
 * Responsável por manipular uma requisição e produzir uma resposta.
 * 
 * @package     AeonDigital\AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iRequestHandler
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
     * Processa a requisição e produz uma resposta.
     *
     * @param       iServerRequest $request
     *              Requisição que está sendo executada.
     * 
     * @return      iResponse
     */
    public function handle(iServerRequest $request) : iResponse;
}
