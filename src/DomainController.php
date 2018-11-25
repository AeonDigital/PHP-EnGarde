<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\EnGarde\Interfaces\iController as iController;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;







/**
 * Classe abstrata que deve ser herdada pelos controllers
 * das aplicações.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
abstract class DomainController implements iController
{
    use \AeonDigital\EnGarde\Traits\CommomProperties;





    /**
     * Objeto "StdClass".
     * Deve ser preenchido durante a execução da Action 
     * e poderá ser acessado nas views.
     *
     * @var         \StdClass
     */
    protected $viewData = null;
    /**
     * Define o objeto "viewData".
     * Este objeto não pode ser redefinido.
     *
     * @return      void
     */
    public function setViewData(\StdClass $viewData) : void
    {
        if ($this->viewData === null) {
            $this->viewData = $viewData;
        }
    }





    /**
     * Mime a ser utilizado na resposta a ser enviada pelo UA.
     *
     * @var         ?string
     */
    private $mime = null;
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
     * @param       ?string
     *              $mime           Mime que deve ser utilizado para responder
     *                              a requisição. A definição "null" fará retornar
     *                              ao locale padrão.
     *
     * @return      void
     */
    public function setResponseMime(?string $mime) : void
    {
        $this->mime = $mime;
    }
    /**
     * Retorna o "mime" definido NESTE controller e que deve ser usado para
     * criar o corpo da resposta a ser enviado para o UA.
     *
     * Este valor, se for válido, irá sobrepor o encontrado em "getResponseMime"
     * do objeto "serverRequest".
     *
     * @return      ?string
     */
    public function getResponseMime() : ?string 
    {
        return $this->mime;
    }





    /**
     * Locale a ser utilizado na resposta a ser enviada pelo UA.
     *
     * @var         ?string
     */
    private $locale = null;
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
     * @param       ?string
     *              $locale         Locale que deve ser utilizado para responder
     *                              a requisição. A definição "null" fará retornar
     *                              ao locale padrão.
     *
     * @return      void
     */
    public function setResponseLocale(?string $locale) : void
    {
        $this->locale = $locale;
    }
    /**
     * Retorna o "locale" definido NESTE controller e que deve ser usado para
     * criar o corpo da resposta a ser enviado para o UA.
     *
     * Este valor, se for válido, irá sobrepor o encontrado em "getResponseLocale"
     * do objeto "serverRequest".
     *
     * @return      ?string
     */
    public function getResponseLocale() : ?string 
    {
        return $this->locale;
    }










    /**
     * Objeto "iResponse".
     *
     * @var         iResponse
     */
    protected $response = null;
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
    public function setResponse(iResponse $response) : void
    {
        if ($this->response === null) {
            $this->response = $response->withActionProperties(
                $this->viewData, 
                $this->mime,
                $this->locale
            );
        }
    }
    /**
     * Retorna a instância "iResponse".
     * Aplica no objeto "iResponse" as propriedades "viewData" e "routeConfig"
     * com os valores resultantes do processamento da action.
     * 
     * @return      iResponse
     */
    public function getResponse() : iResponse
    {
        if ($this->response === null) {
            $this->response = $this->serverConfig->getHttpTools()->createResponse();
        }

        return $this->response->withActionProperties(
            $this->viewData, 
            $this->mime,
            $this->locale
        );
    }
}
