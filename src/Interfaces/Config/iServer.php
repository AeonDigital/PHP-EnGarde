<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Interfaces\Config;

use AeonDigital\EnGarde\Interfaces\Http\iFactory as iFactory;








/**
 * Interface para uma classe que representa a coleção de configurações do servidor no momento
 * em que a requisição ``HTTP`` é recebida.
 *
 * Normalmente servirá como um wrapper para os valores da variável ``$_SERVER``.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
interface iServerConfig
{





    /**
     * Resgata um array associativo contendo todas as variáveis definidas para o servidor no
     * momento atual.
     *
     * Será retornado ``null`` caso nada tenha sido definido.
     *
     * @return      ?array
     */
    function getServerVariables() : ?array;



    /**
     * Permite definir a coleção de valores das variáveis do servidor que estão atualmente
     * definidas.
     *
     * Este método apenas pode ser efetivo se for em um ambiente de testes.
     * Num ambiente de produção estes valores devem ser definidos automaticamente pelo construtor
     * da classe.
     *
     * @param       ?array $oServer
     *              Array associativo com as variáveis do servidor.
     *
     * @return      void
     */
    function setServerVariables(?array $oServer) : void;




    /**
     * Retorna um objeto ``iFactory``.
     *
     * @return      iFactory
     */
    function getHttpFactory() : iFactory;
    /**
     * Define uma instância ``iFactory`` para ser usada.
     *
     * @param       iFactory $httpFactory
     *              Instância a ser definida.
     *
     * @return      void
     */
    function setHttpFactory(iFactory $httpFactory) : void;





    /**
     * Retorna o endereço completo do diretório onde o domínio está sendo executado.
     * Normalmente este valor vem de ``$_SERVER`` mas ele pode também ser alterado e definido
     * diretamente através do método ``setRootPath``.
     *
     * @return      string
     */
    function getRootPath() : string;
    /**
     * Define o local onde o domínio está sendo executado.
     *
     * @param       string $rootPath
     *              Endereço completo do diretório.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o caminho indicado seja inválido
     */
    function setRootPath(string $rootPath) : void;





    /**
     * Retorna o ``IP`` do usuário que está no momento visitando o site.
     * Um valor vazio em retorno indica que não foi possível identificar o ``IP``.
     *
     * @return      string
     */
    function getClientIP() : string;





    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna uma coleção de headers ``HTTP`` definidos para a requisição que está sendo
     * executada.
     *
     * Retornará ``null`` caso nenhum seja encontrado.
     *
     * @return      ?array
     */
    function getRequestHeaders() : ?array;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a versão do protocolo ``HTTP``.
     *
     * Caso não seja possível identificar a versão deve ser retornado o valor ``1.1``.
     *
     * @return      string
     */
    function getRequestHTTPVersion() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Indica se a requisição está exigindo o uso de ``HTTPS``.
     *
     * @return      bool
     */
    function getRequestIsUseHTTPS() : bool;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna o método ``HTTP`` que está sendo usado.
     *
     * @return      string
     */
    function getRequestMethod() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna ``http`` ou ``https`` conforme o protocolo que está sendo utilizado pela
     * requisição.
     *
     * @return      string
     */
    function getRequestProtocol() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna o nome do domínio onde o servidor está operando.
     *
     * @return      string
     */
    function getRequestDomainName() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a parte ``path`` da ``URI`` que está sendo executada.
     *
     * @return      string
     */
    function getRequestPath() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a porta ``HTTP`` que está sendo evocada.
     *
     * @return      int
     */
    function getRequestPort() : int;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna os cookies passados pelo ``UA`` em seu formato bruto.
     *
     * @return      string
     */
    function getRequestCookies() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna os querystrings definidos na ``URI`` em seu formato bruto.
     *
     * @return      string
     */
    function getRequestQueryStrings() : string;
    /**
     * Baseado nos dados da requisição que está sendo executada.
     *
     * Retorna um array de objetos que implementam ``AeonDigital\Interfaces\Stream\iFileStream``
     * representando os arquivos que foram submetidos durante a requisição.
     *
     * Os arquivos são resgatados de ``$_FILES``.
     *
     * @return      array
     */
    function getRequestFiles() : array;





    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna uma string que representa toda a ``URI`` que está sendo acessada no momento.
     *
     * O resultado será uma string com o seguinte formato:
     *
     * ```
     *  [ scheme ":" ][ "//" authority ][ "/" path ][ "?" query ]
     * ```
     *
     * Obs: A porção ``fragment``, iniciada pelo caractere ``#`` não é utilizada.
     *
     * @return      string
     */
    function getCurrentURI() : string;





    /**
     * Resgata toda a coleção de informações passadas na requisição.
     * Sejam parametros via querystrings ou dados postados atravéz de formulários.
     *
     * Não inclui valores passados via cookies.
     *
     * @return      array
     */
    function getPostedData() : array;
}
