<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;

use AeonDigital\EnGarde\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\Http\Tools\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\EnGarde\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;



/**
 * Interface a ser usada em todas as classes
 * que serão controllers das aplicações.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iController
{





    /**
     * Define a configuração para o Domínio.
     *
     * @param       iDomainConfig $domainConfig
     *              Configuração do Domínio.
     * 
     * @return      void
     */
    function setDomainConfig(iDomainConfig $domainConfig) : void;


    /**
     * Define o objeto de configuração do Servidor.
     *
     * @param       iServerConfig $serverConfig
     *              Configuração do Servidor.
     * 
     * @return      void
     */
    function setServerConfig(iServerConfig $serverConfig) : void;


    /**
     * Define um objeto que representa a requisição
     * que está sendo resolvida.
     *
     * @param       iServerRequest $serverRequest
     *              Requisição.
     * 
     * @return      void
     */
    function setServerRequest(iServerRequest $serverRequest) : void;


    /**
     * Define a configuração para a Aplicação corrente.
     *
     * @param       iApplicationConfig $applicationConfig
     *              Configuração da Aplicação.
     * 
     * @return      void
     */
    function setApplicationConfig(iApplicationConfig $applicationConfig) : void;


    /**
     * Define a configuração para a rota que deve ser executada.
     *
     * @param       ?iRouteConfig $routeConfig
     *              Configuração da rota a ser executada.
     * 
     * @return      void
     */
    function setRouteConfig(?iRouteConfig $routeConfig) : void;


    /**
     * Define a configuração em estado bruto para a rota como um todo,
     * incluindo todas as opções relativa a seus métodos HTTP aceitos.
     *
     * @param       ?array $rawRouteConfig
     *              Configuração bruta da rota a ser executada.
     * 
     * @return      void
     */
    function setRawRouteConfig(?array $rawRouteConfig) : void;





    /**
     * Define o objeto "viewData".
     * Este objeto não pode ser redefinido.
     *
     * @return      void
     */
    function setViewData(\StdClass $viewData) : void;





    /**
     * Com este método é possível alterar o "mime" a ser usado contanto
     * que ele seja válido para a rota atual.
     *
     * Por padrão, o "mime" utilizado para responder uma requisição é aquele
     * encontrado/definido para o objeto "serverRequest" que representa a
     * própria requisição. Este objeto recebeu do UA um Header "accept" com
     * os "mimes" que ele aceita de forma qualificada.
     *
     * Caso o "mime" não seja válido, será mantido o valor encontrado em
     * "getResponseMime" do objeto "serverRequest".
     *
     * @param       ?string $mime
     *              Mime que deve ser utilizado para responder
     *              a requisição. A definição "null" fará retornar
     *              ao locale padrão.
     *
     * @return      void
     */
    function setResponseMime(?string $mime) : void;
    /**
     * Retorna o "mime" definido NESTE controller e que deve ser usado para
     * criar o corpo da resposta a ser enviado para o UA.
     *
     * Este valor, se for válido, irá sobrepor o encontrado em "getResponseMime"
     * do objeto "serverRequest".
     *
     * @return      ?string
     */
    function getResponseMime() : ?string;





    /**
     * Com este método é possível alterar o "locale" a ser usado contanto
     * que ele seja válido para a rota atual.
     *
     * Por padrão, o "locale" utilizado para responder uma requisição é aquele
     * encontrado/definido para o objeto "serverRequest" que representa a
     * própria requisição. Este objeto recebeu do UA um Header "accept-language" com
     * os "locales" que ele aceita de forma qualificada.
     *
     * Caso o "locale" não seja válido, será mantido o valor encontrado em
     * "getResponseLocale" do objeto "serverRequest".
     *
     * @param       ?string $locale
     *              Locale que deve ser utilizado para responder
     *              a requisição. A definição "null" fará retornar
     *              ao locale padrão.
     *
     * @return      void
     */
    function setResponseLocale(?string $locale) : void;
    /**
     * Retorna o "locale" definido NESTE controller e que deve ser usado para
     * criar o corpo da resposta a ser enviado para o UA.
     *
     * Este valor, se for válido, irá sobrepor o encontrado em "getResponseLocale"
     * do objeto "serverRequest".
     *
     * @return      ?string
     */
    function getResponseLocale() : ?string;





    /**
     * Define uma instância "iResponse" a ser usada pela 
     * rota que será executada.
     * 
     * Esta ação só é efetiva na primeira execução.
     *
     * @param       iResponse $response
     *              Instância "iResponse".
     * 
     * @return      void
     */
    function setResponse(iResponse $response) : void;
    /**
     * Retorna a instância "iResponse".
     * Aplica no objeto "iResponse" as propriedades "viewData" e "routeConfig"
     * com os valores resultantes do processamento da action.
     * 
     * @return      iResponse
     */
    function getResponse() : iResponse;
}
