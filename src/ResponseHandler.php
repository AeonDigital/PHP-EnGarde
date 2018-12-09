<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Config\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Config\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Config\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Config\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\iResponseHandler as iResponseHandler;


/**
 * Permite produzir uma view a partir das informações coletadas
 * pelo processamento da rota alvo e enviar o resultado ao UA finalizando
 * assim o ciclo de vida da requisição.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
class ResponseHandler implements iResponseHandler
{
    use \AeonDigital\Traits\MimeTypeData;




    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    private $serverConfig = null;
    /**
     * Instância das configurações do Domínio.
     *
     * @var         iDomainConfig
     */
    private $domainConfig = null;
    /**
     * Configuraçõs para a Aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    private $applicationConfig = null;
    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    private $serverRequest = null;
    /**
     * Objeto que representa a configuração bruta da rota alvo.
     *
     * @var         ?array
     */
    private $rawRouteConfig = null;
    /**
     * Objeto que representa a configuração da rota alvo.
     *
     * @var         iRouteConfig
     */
    private $routeConfig = null;
    /**
     * Objeto "iResponse".
     *
     * @var         iResponse
     */
    private $response = null;
    /**
     * Objeto de configurações para a montagem de uma view
     * 
     * @var         
     */ 





    /**
     * Coleção de headers que devem ser enviados para o UA.
     *
     * @var         array
     */
    private $useHeaders = [];









    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     * 
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     * 
     * @param       iApplicationConfig $applicationConfig
     *              Instância "iApplicationConfig".
     * 
     * @param       iServerRequest $serverRequest
     *              Instância "iServerRequest".
     * 
     * @param       array $rawRouteConfig
     *              Instância "iServerConfig".
     * 
     * @param       ?iRouteConfig $routeConfig
     *              Instância "iRouteConfig".
     * 
     * @param       iResponse $response
     *              Instância "iResponse".
     */
    function __construct(
        iServerConfig $serverConfig,
        iDomainConfig $domainConfig,
        iApplicationConfig $applicationConfig,
        iServerRequest $serverRequest,
        array $rawRouteConfig,
        ?iRouteConfig $routeConfig,
        iResponse $response
    ) {
        $this->serverConfig         = $serverConfig;
        $this->domainConfig         = $domainConfig;
        $this->applicationConfig    = $applicationConfig;
        $this->serverRequest        = $serverRequest;
        $this->rawRouteConfig       = $rawRouteConfig;
        $this->routeConfig          = $routeConfig;
        $this->response             = $response;
    }










    /**
     * Efetua o envio dos dados para o UA.
     *
     * @return      void
     */
    public function sendResponse()
    {
        // Identifica se está em um ambiente de testes.
        $isTestEnv = (  $this->domainConfig->getEnvironmentType() === "test" || 
                        $this->domainConfig->getEnvironmentType() === "testview" || 
                        $this->domainConfig->getEnvironmentType() === "localtest");


        // Sendo uma requisição que utiliza o método HTTP OPTIONS
        if ($this->serverRequest->getMethod() === "OPTIONS") {
            $this->prepareResponseToOPTIONS();
        } 
        // Sendo uma requisição que utiliza o método HTTP TRACE
        elseif ($this->serverRequest->getMethod() === "TRACE") {
            $this->prepareResponseToTRACE();
        } 
        // Sendo uma requisição que utiliza um método HTTP 
        // que pode ser controlado pelos controllers das aplicações.
        else {
            // Efetua a negociação de conteúdo identificando se forma
            // exigida pela requisição é possível de ser entregue ao UA.
            //
            // A execução desta etapa pode ocasionar em falhas
            //$this->executeContentNegotiation();


            // Após a negociação de conteúdo, efetua a criação
            // do corpo do documento a ser entregue.
            //$this->createResponseBody();


            //$this->prepareResponseHeaders();
            //$now = new \DateTime();
            //$this->useHeaders["ResponseDate"]       = $now->format("D, d M Y H:i:s");
        }

        // Em um ambiente de testes retorna o "iResponse" resultante.
        if ($isTestEnv === true) {
            return $this->response;
        } 
        //
        /*

        if ($isTestEnv === false) 
        {
            // Envia os Headers para o UA
            $useHeaders = $this->response->getHeaders();
            foreach ($useHeaders as $key => $values) {
                header($key . ": " . implode(", ", $values));
            }

            //print_html($useHeaders);
            
            
            
            echo $this->useMime . "<br />";
            echo $this->useLocale . "<br />";
            echo (string)$this->isPrettyPrint . "<br />";
            echo (string)$this->isDownload . "<br />";
            echo "Prosseguir com a geração do Response<br />";
            echo "- Observar métodos TRACE e OPTIONS<br />";
            //echo print_html($this->response->getViewData());
            echo print_html($this->response->getRouteConfig()->toArray());

            echo "- Aqui, entregue o conteúdo para o usuário.";       
            //echo (string)$this->response->getBody();
        }*/
    }





    /**
     * Ajusta os headers do objeto Response antes do mesmo
     * ser enviado ao UA.
     *
     * @return      void
     */
    private function prepareResponseHeaders() : void
    {
        // Prepara os headers que serão enviados.
        $this->useHeaders = [
            "Framework"             => "EnGarde!; version=" . $this->domainConfig->getVersion(),
            "Application"           => $this->applicationConfig->getName(),
            "Content-Type"          => $this->useMimeType . "; charset=utf-8",
            "Content-Language"      => $this->useLocale,
            "RequestDate"           => $this->serverRequest->getNow()->format("D, d M Y H:i:s"),
            "ResponseDate"          => null
        ];

        if ($this->isDownload === true) {
            $documentName = $this->routeConfig->getDownloadFileName();
            $this->useHeaders["Content-Disposition"] = "inline; filename=\"$documentName\"";
        }
    }





    /**
     * Prepara o objeto "response" para responder a uma
     * requisição em que foi usado o método HTTP OPTIONS.
     *
     * @return      void
     */
    private function prepareResponseToOPTIONS() : void
    {
        // Prepara os Headers a serem utilizados
        $this->useMime      = "json";
        $this->useMimeType  = $this->responseMimeTypes[$this->useMime];
        $this->useLocale    = $this->applicationConfig->getDefaultLocale();

        $this->prepareResponseHeaders();
        $now = new \DateTime();
        $this->useHeaders["ResponseDate"]       = $now->format("D, d M Y H:i:s");
        $this->useHeaders["Allow"]              = array_merge(array_keys($this->rawRouteConfig), ["OPTIONS", "TRACE"]);
        $this->useHeaders["Allow-Languages"]    = $this->applicationConfig->getLocales();

        $this->response = $this->response->withHeaders($this->useHeaders, true);


        // Prepara o Body a ser enviado
        $useBody        = $this->useHeaders;
        $showAllValues  = ($this->domainConfig->getIsDebugMode() === true && $this->domainConfig->getEnvironmentType() !== "production");
        $allowedValues  = [
            "routes", "acceptMimes", "relationedRoutes", "description", "devDescription", "metaData"
        ];

        foreach ($this->rawRouteConfig as $method => $config) {
            $cfg = [];

            foreach ($config as $k => $v) {
                if (in_array($k, $allowedValues) === true || $showAllValues === true) {
                    $cfg[$k] = $v;
                }
            }

            $useBody[$method] = $cfg;
        }

        $body = $this->response->getBody();
        $body->write(json_encode($useBody));
        $this->response->withBody($body);
    }
    /**
     * Prepara o objeto "response" para responder a uma
     * requisição em que foi usado o método HTTP TRACE.
     *
     * @return      void
     */
    private function prepareResponseToTRACE() : void
    {
        // Prepara os Headers a serem utilizados
        $this->useMime      = "json";
        $this->useMimeType  = $this->responseMimeTypes[$this->useMime];
        $this->useLocale    = $this->applicationConfig->getDefaultLocale();

        $this->prepareResponseHeaders();
        $now = new \DateTime();
        $this->useHeaders["ResponseDate"]       = $now->format("D, d M Y H:i:s");
        $this->useHeaders["Allow"]              = array_merge(array_keys($this->rawRouteConfig), ["OPTIONS", "TRACE"]);
        $this->useHeaders["Allow-Languages"]    = $this->applicationConfig->getLocales();

        $this->response = $this->response->withHeaders($this->useHeaders, true);



        // Prepara o Body a ser enviado
        $uFiles = $this->serverRequest->getUploadedFiles();
        $postedFiles = [];
        foreach ($uFiles as $file) {
            $postedFiles[] = $file->getClientFilename();
        }
        if ($postedFiles === []) { $postedFiles = null; }


        $useBody = [
            "requestDate"   => $this->serverRequest->getNow()->format("D, d M Y H:i:s"),
            "responseDate"  => $now->format("D, d M Y H:i:s"),
            "requestIP"     => $this->serverConfig->getClientIP(),
            "requestURI"       => [
                "protocol"          => $this->serverRequest->getUri()->getScheme(),
                "version"           => $this->serverConfig->getRequestHTTPVersion(),
                "port"              => $this->serverConfig->getRequestPort(),
                "method"            => $this->serverConfig->getRequestMethod(),
                "domain"            => $this->serverRequest->getUri()->getHost(),
                "path"              => $this->serverRequest->getUri()->getPath(),
                "query"             => $this->serverRequest->getUri()->getQuery(),
                "fragment"          => $this->serverRequest->getUri()->getFragment()
            ],
            "headers"       => $this->serverConfig->getRequestHeaders(),
            "requestData" => [
                "queryString"       => $this->serverRequest->getQueryParams(),
                "cookies"           => $this->serverRequest->getCookieParams(),
                "postedData"        => $this->serverRequest->getParsedBody(),
                "postedFiles"       => $postedFiles
            ]
        ];

        $body = $this->response->getBody();
        $body->write(json_encode($useBody));
        $this->response->withBody($body);
    }










    /**
     * Cria o body a ser entregue para o UA.
     *
     * @return      void
     */
    private function createResponseBody() : void
    {
        $viewConfig = $this->response->getViewConfig();
        //var_dump($viewConfig);
    }
}
