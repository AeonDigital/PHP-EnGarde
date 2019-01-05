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
 * pelo processamento da rota alvo.
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
     * Prepara o objeto "iResponse" com os "headers" e 
     * com o "body" que deve ser usado para responder
     * ao UA.
     *
     * @return      iResponse
     */
    public function prepareResponse() : iResponse
    {
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
            // Efetua a criação do corpo do documento a ser entregue.
            $this->createResponseBody();
        }

        return $this->response;
    }





    /**
     * Ajusta os headers do objeto Response antes do mesmo
     * ser enviado ao UA.
     *
     * @param       string $useMimeType
     *              Mimetype que deve ser usado.
     * 
     * @param       string $useLocale
     *              Locale usado para a resposta.
     * 
     * @param       array $useHeaders
     *              Coleção de headers a serem incorporados.
     * 
     * @param       bool $isDownload
     *              Indica se é para realizar um download.
     * 
     * @param       string $downloadFileName
     *              Nome do arquivo para download.
     * 
     * @return      void
     */
    private function prepareResponseHeaders(
        string $useMimeType,
        string $useLocale,
        array $useHeaders,
        bool $isDownload = false,
        string $downloadFileName = null
    ) : void {
        $now = new \DateTime();

        $http = "HTTP/" . 
                $this->response->getProtocolVersion() . " " . 
                $this->response->getStatusCode() . " " . 
                $this->response->getReasonPhrase();

                // Prepara os headers que serão enviados.
        $this->useHeaders = [
            "$http"                 => "",
            "Framework"             => "EnGarde!; version=" . $this->domainConfig->getVersion(),
            "Application"           => $this->applicationConfig->getName(),
            "Content-Type"          => $useMimeType . "; charset=utf-8",
            "Content-Language"      => $useLocale,
            "RequestDate"           => $this->serverRequest->getNow()->format("D, d M Y H:i:s"),
            "ResponseDate"          => $now->format("D, d M Y H:i:s")
        ];

        
        // Adiciona os headers definidos na action mas não substitui
        // os aqui definidos.
        foreach ($useHeaders as $key => $value) {
            if (isset($this->useHeaders[$key]) === false) {
                $this->useHeaders[$key] = implode(", ", $value);
            }
        }


        // Tratando-se de um download...
        if ($isDownload === true) {
            $this->useHeaders["Content-Disposition"] = "inline; filename=\"$downloadFileName\"";
        }


        // Aplica os headers no objeto response.
        $this->response = $this->response->withHeaders($this->useHeaders, false);
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
        $now = new \DateTime();
        $this->prepareResponseHeaders(
            $this->responseMimeTypes["json"],
            $this->applicationConfig->getDefaultLocale(),
            [
                "Allow"             => array_merge(array_keys($this->rawRouteConfig), ["OPTIONS", "TRACE"]),
                "Allow-Languages"   => $this->applicationConfig->getLocales()
            ]
        );


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
        $this->response = $this->response->withBody($body);
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
        $now = new \DateTime();
        $this->prepareResponseHeaders(
            $this->responseMimeTypes["json"],
            $this->applicationConfig->getDefaultLocale(),
            [
                "Allow"             => array_merge(array_keys($this->rawRouteConfig), ["OPTIONS", "TRACE"]),
                "Allow-Languages"   => $this->applicationConfig->getLocales()
            ]
        );


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
        $this->response = $this->response->withBody($body);
    }
    /**
     * Cria o body a ser entregue para o UA.
     *
     * @return      void
     */
    private function createResponseBody() : void
    {
        $viewContent    = "";
        $masterContent  = "<view />";
        $viewData       = $this->response->getViewData();
        $viewConfig     = $this->response->getViewConfig();

        
        // Processa a view definida e resgata o resultado
        // de seu processamento.
        if ($this->routeConfig->getView() !== null) {
            $viewPath = to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getView());
		    ob_start("mb_output_handler");
            require_once $viewPath;

            $viewContent = "\n" . ob_get_contents();
            @ob_end_clean();
        }


        
        // Se há uma masterPage definido efetua
        // seu processamento e armazena seu resultado.
        if ($this->routeConfig->getMasterPage() !== null) {
            $viewMaster = to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getMasterPage());
            ob_start("mb_output_handler");
            require_once $viewMaster;

            $masterContent = ob_get_contents();
            @ob_end_clean();
        }


        // Gera o código para as metatags do HTML
        $allMetas = $this->routeConfig->getMetaData();
        $strMetas = [];
        foreach ($allMetas as $key => $value) {
            $strMetas[] = "<meta name=\"$key\" content=\"". htmlspecialchars($value) ."\" />";
        }
        $strMetas = ((count($strMetas) > 0) ? "\n" . implode("\n", $strMetas) : "");



        $resourcesBasePath = str_replace(
                                [$this->domainConfig->getRootPath(), "\\"], 
                                ["", "/"], 
                                $this->applicationConfig->getPathToViewsResources()
                            );


        // Gera o código para os recursos de CSS e JS
        $allCSSs = $this->routeConfig->getStyleSheets();
        $strCSSs = [];
        foreach ($allCSSs as $css) {
            $cssPath = $resourcesBasePath . $css;
            $strCSSs[] = "<link rel=\"stylesheet\" href=\"$cssPath\" />";
        }
        $strCSSs = ((count($strCSSs) > 0) ? "\n" . implode("\n", $strCSSs) : "");


        $allJSs = $this->routeConfig->getJavaScripts();
        $strJSs = [];
        foreach ($allJSs as $js) {
            $jsPath = $resourcesBasePath . $js;
            $strJSs[] = "<script src=\"$jsPath\"></script>";
        }
        $strJSs = ((count($strJSs) > 0) ? "\n" . implode("\n", $strJSs) : "");



        // Mescla a view com a master page e arquivos CSS e JS
        $useBody = str_replace("<view />",          $viewContent, $masterContent);
        $useBody = str_replace("<metatags />",      $strMetas, $useBody);
        $useBody = str_replace("<stylesheets />",   $strCSSs, $useBody);
        $useBody = str_replace("<javascripts />",   $strJSs, $useBody);


        $htmlProp = "";
        // Conforme estiver servindo HTML ou XHTML
        if ($this->routeConfig->getResponseMime() === "html") {
            $htmlProp = "lang=\"".$this->routeConfig->getResponseLocale()."\"";
        } 
        elseif ($this->routeConfig->getResponseMime() === "xhtml") {
            $useBody = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . $useBody;
            $htmlProp = "xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".$this->routeConfig->getResponseLocale()."\"";
        }
        $useBody = str_replace("data-eg-html-prop=\"\"", $htmlProp, $useBody);
        


        // Define o novo corpo para o objeto Response
        $body = $this->response->getBody();
        $body->write($useBody);
        $this->response = $this->response->withBody($body);


        // Prepara os Headers para o envio
        $this->prepareResponseHeaders(
            $this->routeConfig->getResponseMimeType(),
            $this->routeConfig->getResponseLocale(),
            $this->response->getHeaders(),
            $this->routeConfig->getResponseIsDownload(),
            $this->routeConfig->getResponseDownloadFileName()
        );
    }
}
