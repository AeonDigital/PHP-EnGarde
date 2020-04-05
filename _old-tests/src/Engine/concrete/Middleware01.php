<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Tests\Concrete;

use AeonDigital\Interfaces\EnGarde\iMiddleware as iMiddleware;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\Interfaces\EnGarde\iRequestHandler as iRequestHandler;





/**
 * Classe concreta para "iMiddleware".
 *
 * Esta classe representa um modelo básico de como um Middleware deve
 * ser implementado para ser consumido pela aplicação.
 */
final class Middleware01 implements iMiddleware
{
    private $id = "";
    public function setId($id)
    {
        $this->id = $id;
    }



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
    public function process(iServerRequest $request, iRequestHandler $handler) : iResponse
    {
        // O processamento de um Middleware é dividido em 3 etapas.

        // 1.
        // São feitos os preparativos que podem variar
        // conforme os valores inicialmente definidos para o objeto "$request".
        //
        // - verificação de valores passados.
        // - verificações de segurança baseada nos cookies existentes.
        // - outras verificações que podem já iniciar a serem efetivas ANTES da rota em si ser executada.
        //
        // As alterações feitas em "$request" são executadas na ordem exata em que cada
        // Middleware é chamado.

        // -- Para este teste, definirá um novo atributo no objeto
        //    ANTES da execução do próximo processo.
        $request = $request->withAttribute("Mid_Before_" . $this->id, $this->id);

        // 2.
        // Nesta etapa será executado o método "handle" do objeto "iRequestHandler" passado.
        // A ele caberá decidir se deve executar um outro Middleware ou se deve produzir por si
        // uma instância "iResponse" a ser retornada.
        //
        // O resultado da etapa 2 quase invariavelmente conterá a seguinte linha de execução:
        $res = $handler->handle($request);

        // 3.
        // Nesta etapa, executada SEMPRE após obtenção de um objeto "iResponse" será possível
        // manipulá-lo e assim finalizar a presente execução.

        $viewData = $res->getViewData();
        $viewData->{"Mid_After_" . $this->id} = $this->id;
        $res = $res->withViewData($viewData);


        // É importante lembrar que ao usar uma instância "RequestProcessManager" para gerenciar
        // a execução dos Middlewares, as alterações feitas no objeto "iResponse" resultante serão executadas
        // na ordem inversa a declaração de cada Middleware.

        return $res;
    }
}
