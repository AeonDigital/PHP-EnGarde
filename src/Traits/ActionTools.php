<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Traits;

use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRouteConfig;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;
use AeonDigital\Interfaces\DAL\iDAL as iDAL;




/**
 * Coleção de métodos e propriedades que devem estar disponíveis tanto no escopo das actions
 * dentro dos controllers quanto nas views e demais includes chamados por estas.
 *
 * @package     AeonDigital\Traits
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
trait ActionTools
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
    protected ?\stdClass $viewData;
    /**
     * Objeto ``stdClass``.
     *
     * Deve ser preenchido durante a execução da ``Action`` e poderá ser acessado nas views.
     * Tem como finalidade agregar informações que sirvam para a configuração da view e que não
     * devem ser expostas ao ``UA``.
     *
     * @var         \stdClass
     */
    protected ?\stdClass $viewConfig;
    /**
     * Objeto de conexão com o banco de dados para o UA atual.
     *
     * @var         iDAL
     */
    protected iDAL $DAL;










    /**
     * Retorna um array associativo referente a uma coleção de campos postados pelo UA
     * incluindo também aqueles passados via querystrings e os parametros identificados
     * na construção da rota.
     *
     * A identificação dos campos que fazem parte desta coleção se dá pelo prefixo
     * em comum que eles tenham em seus "name".
     *
     * Há um tratamento especial para todo campo definido com o nome "Id".
     * Para estes, sempre que seus valores forem vazios, tal chave será omitida no corpo
     * do array retornado.
     *
     * Todos os valores retornados estarão também tratados com o método ``\htmlspecialchars``
     * visando assim inibir ataques usando injeção xss. Portanto, é necessário que, naqueles
     * campos que se planeja permitir que sejam usadas marcações HTML, o valor seja
     * retratado com o método ``\htmlspecialchars_decode``.
     *
     * @param       \AeonDigital\EnGarde\Interfaces\Config\iServer $serverConfig
     *              Objeto "serverConfig" para uso.
     *
     * @param       string $prefix
     *              Prefixo que identifica os campos que devem ser retornados.
     *              Internamente adiciona um "_" ao final desta string caso ela seja
     *              diferente de ``""``
     *
     * @param       bool $onlyNotEmpty
     *              Quando ``true`` irá retornar apenas os dados que não sejam ``""``.
     *
     * @param       bool $prepareForXSS
     *              Quando ``true`` irá fazer todos os valores passados serem submetidos
     *              ao método ``\htmlspecialchars``.
     *
     * @return      array
     */
    public static function sttRetrieveFormFieldset(
        \AeonDigital\EnGarde\Interfaces\Config\iServer $serverConfig,
        string $prefix,
        bool $onlyNotEmpty = false,
        bool $prepareForXSS = true
    ) : array {
        $r = [];
        $postedFields = $serverConfig->getPostedData();
        if ($prefix !== "") { $prefix .= "_"; }

        foreach ($postedFields as $key => $value) {
            if (\mb_str_starts_with($key, $prefix) === true) {
                $k = \str_replace($prefix, "", $key);

                if ($onlyNotEmpty === false) {
                    if ($value === "") { $r[$k] = null; }
                    else { $r[$k] = self::prepareRawPostedValue($value, $prepareForXSS); }
                }
                else {
                    if ($value !== "") {
                        $r[$k] = self::prepareRawPostedValue($value, $prepareForXSS);
                    }
                }
            }
        }

        if (\key_exists("Id", $r) === true && $r["Id"] === null) {
            unset($r["Id"]);
        }

        return $r;
    }
    /**
     * Prepara o valor recebido do UA e trata o mesmo conforme a necessidade de proteção
     * ou não contra ataques XSS.
     *
     * @param       array|string $value
     *              Array ou string do valor que foi recebido.
     *
     * @param       bool $prepareForXSS
     *              Indica se deve ou não tratar o valor para proteção contra ataques
     *              do tipo XSS.
     *
     * @return      array|string
     */
    private static function prepareRawPostedValue($value, bool $prepareForXSS = true) {
        if (\is_array($value) === true) {
            $newValues = [];
            foreach ($value as $v) {
                $newValues[] = self::prepareRawPostedValue($v, $prepareForXSS);
            }
            $value = $newValues;
        }
        else {
            $value = (($prepareForXSS === true) ? \htmlspecialchars($value) : $value);
        }

        return $value;
    }
    /**
     * Retorna um array associativo referente a uma coleção de campos postados pelo UA
     * incluindo também aqueles passados via querystrings e os parametros identificados
     * na construção da rota.
     *
     * A identificação dos campos que fazem parte desta coleção se dá pelo prefixo
     * em comum que eles tenham em seus "name".
     *
     * Há um tratamento especial para todo campo definido com o nome "Id".
     * Para estes, sempre que seus valores forem vazios, tal chave será omitida no corpo
     * do array retornado.
     *
     * Todos os valores retornados estarão também tratados com o método ``\htmlspecialchars``
     * visando assim inibir ataques usando injeção xss. Portanto, é necessário que, naqueles
     * campos que se planeja permitir que sejam usadas marcações HTML, o valor seja
     * retratado com o método ``\htmlspecialchars_decode``.
     *
     * @param       string $prefix
     *              Prefixo que identifica os campos que devem ser retornados.
     *              Internamente adiciona um "_" ao final desta string caso ela seja
     *              diferente de ``""``
     *
     * @param       bool $onlyNotEmpty
     *              Quando ``true`` irá retornar apenas os dados que não sejam ``""``.
     *
     * @param       bool $prepareForXSS
     *              Quando ``true`` irá fazer todos os valores passados serem submetidos
     *              ao método ``\htmlspecialchars``.
     *
     * @return      array
     */
    protected function retrieveFormFieldset(
        string $prefix,
        bool $onlyNotEmpty = false,
        bool $prepareForXSS = true
    ) : array {
        return self::sttRetrieveFormFieldset(
            $this->serverConfig,
            $prefix,
            $onlyNotEmpty,
            $prepareForXSS
        );
    }
    /**
     * Retorna o valor do parametro da requisição de nome indicado.
     *
     * A chave é procurada entre RouteParans, Cookies, Attributes, QueryStrings e
     * Post Data respectivamente e será retornada a primeira entre as coleções
     * avaliadas.
     *
     * Retornará ``null`` caso o nome da chave não seja encontrado.
     *
     * Mesmo que ``$this->serverConfig->getPostedData()``
     * OU
     * que ``$this->serverConfig->getServerRequest()->getParam()``.
     *
     * @param       string $name
     *              Nome do campo que está sendo requerido.
     *
     * @param       bool $prepareForXSS
     *              Quando ``true`` irá fazer o valor retornado ser submetido
     *              ao método ``\htmlspecialchars``.
     *
     * @return      ?string
     */
    protected function getParam(string $name, bool $prepareForXSS = true)
    {
        $r = null;
        $requestRoutes = $this->serverConfig->getPostedData();
        if (\key_exists($name, $requestRoutes) === true) {
            $r = $requestRoutes[$name];
        }
        else {
            $r = $this->serverConfig->getServerRequest()->getParam($name);
        }


        if ($prepareForXSS === true && $r !== null) {
            if (\is_string($r) === true) {
                $r = \htmlspecialchars($r);
            }
            elseif (\is_array($r) === true) {
                $r = \array_map("htmlspecialchars", $r);
            }
        }

        return $r;
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
     * Retorna o objeto ``iCookie`` correspondente ao cookie de nome indicado.
     * Retornará ``null`` caso ele não exista.
     *
     * Mesmo que ``$this->serverConfig->getServerRequest()->getCookie()``.
     *
     * @param       string $name
     *              Nome do cookie alvo.
     *
     * @return      ?iCookie
     */
    protected function getCookie(string $name) : ?iCookie
    {
       return $this->serverConfig->getServerRequest()->getCookie($name);
    }





    /**
     * Identifica se o UA está autenticado.
     *
     * @return      bool
     */
    protected function isAuthenticated() : bool
    {
        return (
            $this->serverConfig->hasDefinedSecuritySettings() === true &&
            $this->serverConfig->getSecuritySession()->retrieveSecurityStatus() === \AeonDigital\EnGarde\SessionControl\Enum\SecurityStatus::UserSessionAuthenticated
        );
    }
    /**
     * Retorna os dados de um usuário autenticado que esteja associado a sessão
     * que está reconhecida, ativa e válida.
     *
     * @return      ?array
     */
    protected function retrieveUser() : ?array
    {
        return (($this->serverConfig->hasDefinedSecuritySettings() === true) ?
            $this->serverConfig->getSecuritySession()->retrieveUser() : null);
    }
    /**
     * Retorna o objeto completo do perfil de usuário atualmente em uso.
     *
     * @return      ?array
     */
    protected function retrieveUserProfile() : ?array
    {
        return (($this->serverConfig->hasDefinedSecuritySettings() === true) ?
            $this->serverConfig->getSecuritySession()->retrieveUserProfile() : null);
    }
    /**
     * Retorna o perfil de segurança do usuário atualmente em uso.
     *
     * @return      ?string
     */
    protected function retrieveUserProfileName() : ?string
    {
        return (($this->serverConfig->hasDefinedSecuritySettings() === true) ?
            $this->serverConfig->getSecuritySession()->retrieveUserProfileName() : null);
    }
    /**
     * Retorna uma coleção de perfis de segurança que o usuário tem autorização de utilizar.
     *
     * @param       string $applicationName
     *              Se definido, retornará apenas os profiles que correspondem ao nome da
     *              aplicação indicada.
     *
     * @return      ?array
     */
    protected function retrieveUserProfiles(string $applicationName = "") : ?array
    {
        return (($this->serverConfig->hasDefinedSecuritySettings() === true) ?
            $this->serverConfig->getSecuritySession()->retrieveUserProfiles($applicationName) : null);
    }
    /**
     * Efetua a troca do perfil de segurança atualmente em uso por outro que deve estar
     * na coleção de perfis disponíveis para este mesmo usuário.
     *
     * @return      bool
     */
    protected function changeUserProfile(string $profile) : bool
    {
        return (($this->serverConfig->hasDefinedSecuritySettings() === true) ?
            $this->serverConfig->getSecuritySession()->changeUserProfile($profile) : null);
    }





    /**
     * Retorna um objeto ``stdClass`` configurado com os valores padrões para
     * resposta a requisições que esperam um objeto JSON.
     *
     * @return       \stdClass
	 */
    protected function retrieveDefaultResponse() : \stdClass
    {
        return (object)[
            // Indica se a ação requisitada pelo UA foi bem sucedida.
            "success"       => false,
            // Flag genérica sobre o status de retorno da requisição.
            "status"        => "",
            // Mensagem de retorno para a requisição.
            // Geralmente é uma mensagem genérica sobre o sucesso ou falha da requisição.
            "message"       => "",
            // Indica se a mensagem de retorno deve ser tratada como HTML.
            "isHTML"        => true,
            // Array associativo contendo informações sobre a
            // validação dos dados recebidos.
            "validate"      => null,
            // Se definido, indica o local para onde o UA deve ser direcionado.
            "redirectTo"    => "",
            // Indica a URL em que o UA está neste momento.
            "fromURL"       => ""
        ];
    }
    /**
     * Retorna um objeto ``stdClass`` configurado com os valores padrões para
     * um objeto JSON que deve ser submetido pelo UA.
     *
     * @return       \stdClass
	 */
    protected function retrieveDefaultRequest() : \stdClass
    {
        return (object)[
            // Dados que estão sendo enviados.
            // Geralmente trata-se dos campos de um formulário.
            // Dados recebidos de uma requisição ou formulário.
            "data"          => null,
            // Nomes de cada uma das coleções de campos que foram submetidos
            "fieldsets"     => null,
            // Informações sobre a associação dos dados submetidos com relação as entidades
            // de dados correlacionadas a esta requisição.
            "attatchRules"  => null,
        ];
	}





    /**
     * Gera um registro de atividade para a requisição atual.
     *
     * @param       string $activity
     *              Atividade executada.
     *
     * @param       string $note
     *              Observação.
     *
     * @return      bool
     */
    protected function registerLogActivity(
        string $activity,
        string $note
    ) : bool {
        $securitySession = $this->serverConfig->getSecuritySession();
        return $securitySession->registerLogActivity(
            $this->routeConfig->getMethod(),
            $this->serverConfig->getApplicationRequestFullUri(),
            $this->serverConfig->getServerRequest()->getPostedFields(),
            $this->routeConfig->getController(),
            $this->routeConfig->getAction(),
            $activity,
            $note
        );
    }
}
