<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Handlers;

use AeonDigital\Http\Tools\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\iResponseHandler as iResponseHandler;
use AeonDigital\EnGarde\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\EnGarde\ErrorListening as ErrorListening;






/**
 * Permite produzir uma view a partir das informações coletadas
 * pela Aplicação e configuração da rota alvo e enviar o 
 * resultado ao UA.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
class ResponseHandler implements iResponseHandler
{
    use \AeonDigital\Traits\MimeTypeData;
    use \AeonDigital\EnGarde\Traits\CommomProperties;





    /**
     * Data e Hora da criação desta instância.
     *
     * @var         DateTime
     */
    private $now = null;
    /**
     * Método HTTP que está sendo usado para efetuar
     * a requisição atual.
     *
     * @var         string
     */
    private $useMethod = null;
    /**
     * Coleção de headers que devem ser enviados para o UA.
     *
     * @var         array
     */
    private $useHeaders = [];
    /**
     * Mime que deve ser usado para criar o corpo
     * da resposta a ser enviada para o UA.
     *
     * @var         string
     */
    private $useMime = null;
    /**
     * MimeType que deve ser usado para criar o corpo
     * da resposta a ser enviada para o UA.
     *
     * @var         string
     */
    private $useMimeType = null;
    /**
     * Locale que deve ser usado para criar o corpo
     * da resposta a ser enviada para o UA.
     *
     * @var         string
     */
    private $useLocale = null;
    /**
     * Indica se a resposta a ser submetida ao UA
     * deve passar por um processo de ajuste para facilitar
     * a leitura.
     * 
     * @var         boolean
     */
    private $isPrettyPrint = false;
    /**
     * Indica se a resposta deve ser submetida ao UA
     * em formato de download.
     *
     * @var         boolean
     */
    private $isDownload = false;





    /**
     * Objeto "iResponse".
     *
     * @var         iResponse
     */
    private $response = null;
    /**
     * Define o objeto "response" contendo o conteúdo bruto
     * que deve ser preparado para envio ao UA.
     * 
     * O conteúdo bruto esperado deve estar especificado nas 
     * propriedades "viewData" e "routeConfig".
     *
     * @param       iResponse 
     *              $response       Objeto "iResponse".
     * 
     * @return      void
     */
    public function setResponse(iResponse $response) : void
    {
        if ($this->response === null) {
            $this->response = $response;
        }
    }
    /**
     * Resgata o objeto "iResponse" atualmente definido.
     *
     * @return      iResponse
     */
    public function getResponse() : iResponse
    {
        return $this->response;
    }






    /**
     * Inicia o manipulador para respostas HTTP.
     * 
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     *
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     *
     * @param       iServerRequest $serverRequest
     *              Instância "iServerRequest".
     * 
     * @param       iApplicationConfig $applicationConfig
     *              Instância "iApplicationConfig".
     * 
     * @param       ?iRouteConfig $routeConfig
     *              Instância "iRouteConfig".
     * 
     * @param       ?array $rawRouteConfig
     *              Configuração bruta da rota selecionada.
     * 
     * @param       iResponse $response
     *              Instância "iResponse".
     */
    public function __construct(
        iDomainConfig $domainConfig,
        iServerConfig $serverConfig,
        iServerRequest $serverRequest,
        iApplicationConfig $applicationConfig,
        ?iRouteConfig $routeConfig,
        ?array $rawRouteConfig,
        iResponse $response
    ) {
        $this->setDomainConfig($domainConfig);
        $this->setServerConfig($serverConfig);
        $this->setServerRequest($serverRequest);
        $this->setApplicationConfig($applicationConfig);
        $this->setRouteConfig($routeConfig);
        $this->setRawRouteConfig($rawRouteConfig);
        $this->setResponse($response);

        $this->now = new \DateTime();
        $this->useMethod = $serverRequest->getMethod();
    }










    /**
     * Efetua a negociação de conteúdo para identificar
     * de que forma os dados devem ser retornados ao UA.
     * 
     * Deve ser executado após o processamento da rota.
     *
     * @return      void
     */
    public function executeContentNegotiation() : void
    {
        $this->negotiateLocale();
        $this->negotiateMime();
        $this->negotiatePrettyPrint();
        $this->negotiateDownload();

        
     
        // Se não for possível encontrar um mime para ser usado.
        if ($this->useMime === null) {
            $requestUseMime     = $this->serverRequest->getResponseMime();
            $actionUseMime      = $this->response->getMime();

            $useMime            = (($actionUseMime === null) ? $requestUseMime : $actionUseMime);
            $msg                = "Media type \"$useMime\" is not supported by this URL.";
            ErrorListening::throwHTTPError(415, $msg);
        }


        $this->response = $this->response->withActionProperties(
            $this->response->getViewData(),
            $this->routeConfig,
            $this->useMime,
            $this->useLocale
        );
    }
    /**
     * Efetua a negociação do conteúdo para identificar
     * qual "locale" deve ser usado ao criar a resposta
     * a ser enviada ao UA.
     *
     * @return      void
     */
    private function negotiateLocale() : void 
    {
        $defaultLocale      = $this->applicationConfig->getDefaultLocale();
        $acceptedLocales    = $this->applicationConfig->getLocales();
        $requestUseLocale   = $this->serverRequest->getResponseLocale();
        $actionUseLocale    = $this->response->getLocale();

        // Se o locale definido pela Action for válido, usa-o
        // Senão, tenta usar o mime pedido pelo UA
        // Senão, usa o locale padrão.
        $useLocale = (
            (in_array($actionUseLocale, $acceptedLocales) === true) ?
            $actionUseLocale :
            (
                (in_array($requestUseLocale, $acceptedLocales) === true) ?
                $requestUseLocale :
                $defaultLocale
            )
        );

        $this->useLocale = $useLocale;
    }
    /**
     * Efetua a negociação do conteúdo para identificar
     * qual "locale" deve ser usado ao criar a resposta
     * a ser enviada ao UA.
     *
     * @return      void
     */
    private function negotiateMime() : void
    {
        $isUseXhtml         = $this->routeConfig->getIsUseXHTML();
        $acceptedMimes      = $this->routeConfig->getAcceptMimes();
        $requestUseMime     = $this->serverRequest->getResponseMime();
        $actionUseMime      = $this->response->getMime();


        // Se o mime definido pela Action for válido, usa-o
        // Senão, tenta usar o mime pedido pelo UA
        $useMime = (
            (isset($acceptedMimes[$actionUseMime]) === true) ?
            $actionUseMime :
            (
                (isset($acceptedMimes[$requestUseMime]) === true) ?
                $requestUseMime :
                null
            )
        );


        // Sendo para retornar um documento "html" e
        // a aplicação estando configurada para forçar uma
        // saida "xhtml", identifica esta situação e força-a.
        if ($useMime === "html" && $isUseXhtml === true) {
            $useMime = "xhtml";
        }

        $this->useMime = $useMime;
        $this->useMimeType = $this->responseMimeTypes[$useMime];
    }
    /**
     * Efetua a negociação do conteúdo para identificar
     * se o corpo do objeto de retorno deve ser tratado para
     * facilitar a leitura do código por humanos.
     *
     * @return      void
     */
    private function negotiatePrettyPrint() : void
    {
        $prettyPrint = $this->serverRequest->getParam("_pretty_print");
        $this->isPrettyPrint = ($prettyPrint === "true" || $prettyPrint === "1");
    }
    /**
     * Efetua a negociação do conteúdo para identificar
     * se o corpo do objeto de retorno deve ser enviado para
     * o UA como um download.
     *
     * @return      void
     */
    private function negotiateDownload() : void
    {
        $isDownload_route = $this->routeConfig->getIsDownload();
        $isDownload_param = $this->serverRequest->getParam("_download");
        $isDownload_param = ($isDownload_param === "true" || $isDownload_param === "1");

        $this->isDownload = ($isDownload_route === true || $isDownload_param === true);
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
            "Date"                  => $this->now->format("D, d M Y H:i:s")
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
    public function prepareResponseToOPTIONS() : void
    {
        // Prepara os Headers a serem utilizados
        $this->useMime      = "json";
        $this->useMimeType  = $this->responseMimeTypes[$this->useMime];
        $this->useLocale    = $this->applicationConfig->getDefaultLocale();

        $this->prepareResponseHeaders();
        $this->useHeaders["Allow"] = array_merge(array_keys($this->rawRouteConfig), ["OPTIONS", "TRACE"]);
        $this->useHeaders["Allow-Languages"] = $this->applicationConfig->getLocales();

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
    public function prepareResponseToTRACE() : void
    {
        // Prepara os Headers a serem utilizados
        $this->useMime      = "json";
        $this->useMimeType  = $this->responseMimeTypes[$this->useMime];
        $this->useLocale    = $this->applicationConfig->getDefaultLocale();

        $this->prepareResponseHeaders();
        $this->useHeaders["Allow"] = array_merge(array_keys($this->rawRouteConfig), ["OPTIONS", "TRACE"]);
        $this->useHeaders["Allow-Languages"] = $this->applicationConfig->getLocales();

        $this->response = $this->response->withHeaders($this->useHeaders, true);



        // Prepara o Body a ser enviado
        $uFiles = $this->serverRequest->getUploadedFiles();
        $postedFiles = [];
        foreach ($uFiles as $file) {
            $postedFiles[] = $file->getClientFilename();
        }
        if ($postedFiles === []) { $postedFiles = null; }


        $useBody = [
            "date"          => $this->now->format("D, d M Y H:i:s"),
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
     * Efetua o envio dos dados para o UA.
     * 
     * Deve ser executado após o processamento da rota.
     *
     * @return      void
     */
    public function sendResponse() : void
    {
        // Apenas se não estiver em um ambiente
        // de testes.
        $isTestEnv = (  $this->domainConfig->getEnvironmentType() === "test" || 
                        $this->domainConfig->getEnvironmentType() === "testview" || 
                        $this->domainConfig->getEnvironmentType() === "localtest");

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
        }
    }
}
