<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde;

use AeonDigital\EnGarde\Interfaces\Engine\iController as iController;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRouteConfig;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;





/**
 * Classe abstrata que deve ser herdada pelos controllers das aplicações.
 *
 * @codeCoverageIgnore
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
abstract class MainController implements iController
{





    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    protected iServerConfig $serverConfig;
    /**
     * Instância de configuração da rota.
     *
     * @var         iRouteConfig
     */
    protected iRouteConfig $routeConfig;
    /**
     * Objeto ``iResponse``.
     *
     * @var         iResponse
     */
    protected iResponse $response;
    /**
     * Objeto ``stdClass``.
     *
     * Deve ser preenchido durante a execução da ``Action`` e poderá ser acessado nas views.
     * Tem como finalidade agregar todas as informações que o ``UA`` está requisitando.
     *
     * @var         \stdClass
     */
    protected \stdClass $viewData;
    /**
     * Objeto ``stdClass``.
     *
     * Deve ser preenchido durante a execução da ``Action`` e poderá ser acessado nas views.
     * Tem como finalidade agregar informações que sirvam para a configuração da view e que não
     * devem ser expostas ao ``UA``.
     *
     * @var         \stdClass
     */
    protected \stdClass $viewConfig;










    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância ``iServerConfig``.
     *
     * @param       iResponse $response
     *              Instância ``iResponse``.
     */
    function __construct(
        iServerConfig $serverConfig,
        iResponse $response
    ) {
        $this->serverConfig = $serverConfig;
        $this->routeConfig  = $serverConfig->getRouteConfig();
        $this->response     = $response;

        $this->viewData     = new \stdClass();
        $this->viewConfig   = new \stdClass();
    }










    /**
     * Retorna a instância ``iResponse``.
     *
     * Aplica no objeto ``iResponse`` as propriedades ``viewData``, ``viewConfig`` e
     * ``headers``. Todos manipuláveis durante a execução da action.
     *
     * @return      iResponse
     */
    public function getResponse() : iResponse
    {
        return $this->response->withActionProperties(
            $this->viewData,
            $this->viewConfig,
            $this->serverConfig->getRouteConfig()->getResponseHeaders()
        );
    }










    /**
     * Retorna um array associativo referente a uma coleção de campos postados pelo UA.
     * A identificação dos campos que fazem parte desta coleção se dá pelo prefixo
     * em comum que eles tenham em seus "name".
     *
     * Há um tratamento especial para todo campo definido com o nome "Id".
     * Para estes, sempre que seus valores forem vazios, tal chave será omitida no corpo
     * do array retornado.
     *
     * @param       string $prefix
     *              Prefixo que identifica os campos que devem ser retornados.
     *
     * @return      array
     */
    protected function retrieveFormFieldset(string $prefix) : array
    {
        $r = [];
        $postedFields = $this->getPostedFields();

        if ($postedFields !== null) {
            foreach ($postedFields as $key => $value) {
                if (\mb_str_starts_with($key, $prefix) === true) {
                    $k      = \str_replace($prefix, "", $key);
                    $r[$k]  = (($value === "") ? null : $value);
                }
            }

            if (\key_exists("Id", $r) === true && $r["Id"] === null) {
                unset($r["Id"]);
            }
        }

        return $r;
    }
    /**
     * Retorna os querystrings enviados pelo ``UA``.
     *
     * Será retornado um array associativo contendo chave/valor de cada querystring recebido.
     *
     * Mesmo que ``$this->serverConfig->getServerRequest()->getQueryParams()``.
     *
     * @return      array
     */
    protected function getQueryParams() : array
    {
        return $this->serverConfig->getServerRequest()->getQueryParams();
    }
    /**
     * Retorna o valor da querystring de nome indicado.
     * Retornará ``null`` caso ela não exista.
     *
     * Mesmo que ``$this->serverConfig->getServerRequest()->getQueryString()``.
     *
     * @param       string $name
     *              Nome da querystring alvo.
     *
     * @return      ?string
     */
    protected function getQueryString(string $name) : ?string
    {
        return $this->serverConfig->getServerRequest()->getQueryString($name);
    }
    /**
     * Retorna os arquivos enviados pelo ``UA``.
     *
     * Mesmo que ``$this->serverConfig->getServerRequest()->getUploadedFiles()``.
     *
     * @return      array
     */
    protected function getUploadedFiles() : ?array
    {
        return $this->serverConfig->getServerRequest()->getUploadedFiles();
    }
    /**
     * Retorna um array contendo todos os campos recebidos no corpo da requisição.
     *
     * Mesmo que ``$this->serverConfig->getServerRequest()->getPostedFields()``.
     *
     * @return      ?array
     */
    protected function getPostedFields() : ?array
    {
        return $this->serverConfig->getServerRequest()->getPostedFields();
    }
    /**
     * Retorna o valor do campo de nome indicado.
     * Retornará ``null`` caso ele não exista.
     *
     * Mesmo que ``$this->serverConfig->getServerRequest()->getPost()``.
     *
     * @param       string $name
     *              Nome do campo alvo.
     *
     * @return      ?string
     */
    protected function getPost(string $name)
    {
        return $this->serverConfig->getServerRequest()->getPost($name);
    }
    /**
     * Retorna o valor do cookie de nome indicado.
     * Retornará ``null`` caso ele não exista.
     *
     * Mesmo que ``$this->serverConfig->getServerRequest()->getCookie()``.
     *
     * @param       string $name
     *              Nome do cookie alvo.
     *
     * @return      ?string
     */
    protected function getCookie(string $name) : ?string
    {
        return $this->serverConfig->getServerRequest()->getCookie($name);
    }
    /**
     * Retorna o valor do parametro da requisição de nome indicado.
     * A chave é procurada entre Cookies, Attributes, QueryStrings e Post Data respectivamente e
     * será retornada a primeira entre as coleções avaliadas.
     *
     * Retornará ``null`` caso o nome da chave não seja encontrado.
     *
     * Mesmo que ``$this->serverConfig->getServerRequest()->getParam()``.
     *
     * @param       string $name
     *              Nome do campo que está sendo requerido.
     *
     * @return      ?string
     */
    protected function getParam(string $name)
    {
        return $this->serverConfig->getServerRequest()->getParam($name);
    }
}
