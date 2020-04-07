<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Http;










/**
 * Interface para uma classe que efetue o trabalho de rotear as URLs entre os controllers e
 * actions de uma Aplicação.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iRouter
{





    /**
     * Define o valores padrões para as configurações de rotas de uma aplicação.
     *
     * @param       array $defaultRouteConfig
     *              Configurações padrões para as rotas da aplicação.
     *
     * @return      void
     */
    function setDefaultRouteConfig(array $defaultRouteConfig) : void;



    /**
     * Indica se é permitido efetuar a atualização do arquivo de rotas da aplicação.
     *
     * @param       bool $isUpdateRoutes
     *              Quando ``true`` irá permitir a atualização do arquivo de rotas.
     *
     * @return      void
     */
    function setIsUpdateRoutes(bool $isUpdateRoutes) : void;



    /**
     * Quando executado este método irá excluir o atual arquivo de configuração de rotas da
     * aplicação, forçando assim que ele seja refeito.
     *
     * @return      void
     */
    function forceUpdateRoutes() : void;



    /**
     * Retornará ``true`` quando for identificado que é para redefinir o arquivo de configuração
     * de rotas da aplicação.
     *
     * Apenas retornará ``true`` quando:
     * - for  definido ``true`` em ``setIsUpdateRoutes``.
     * - há algum arquivo ``controller`` com data de alteração posterior a data de criação do
     *   arquivo de configuração de rotas da aplicação.
     *
     * Também retornará ``true`` quando não existir um arquivo de rotas no local indicado.
     *
     * @return      bool
     */
    function checkForUpdateApplicationRoutes() : bool;



    /**
     * Varre os arquivos de ``controllers`` da aplicação e remonta o arquivo de configuração de
     * rotas do mesmo.
     *
     * Este método apenas pode ser executado quando o resultado de
     * ``checkForUpdateApplicationRoutes`` for ``true``.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso algum parametro interno esteja com um valor inválido.
     *
     * @throws      \RuntimeException
     *              Caso algum erro ocorra no processo.
     */
    function updateApplicationRoutes() : void;



    /**
     * Identifica se a rota passada correspondem a alguma rota que tenha sido previamente
     * registrada no ``AppRoutes``.
     * Uma vez identificada a rota alvo, retorna todas suas configurações.
     *
     * Em caso de falha na identificação da rota será retornado ``null``.
     *
     * @param       string $targetRoute
     *              Porção relativa da ``URI`` que está sendo executada.
     *              É necessário constar na rota, como sua primeira parte, o nome da aplicação
     *              que está sendo executada. Não deve constar quaisquer parametros ``querystring``
     *              ou ``fragment``.
     *
     * @return      ?array
     */
    function selectTargetRawRoute(string $targetRoute) : ?array;



    /**
     * Retorna a coleção de parametros identificados na ``URL`` passada por último no método
     * ``selectTargetRawRoute``.
     *
     * @return      ?array
     */
    function getSelectedRouteParans() : ?array;
}
