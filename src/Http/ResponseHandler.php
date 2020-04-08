<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Http;

use AeonDigital\EnGarde\Interfaces\Http\iResponseHandler as iResponseHandler;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\Config\iDomain as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;


/**
 * Permite produzir uma view a partir das informações coletadas pelo processamento da rota alvo.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
class ResponseHandler implements iResponseHandler
{
    use \AeonDigital\Http\Traits\MimeTypeData;




    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    private iServerConfig $serverConfig;
    /**
     * Instância das configurações do Domínio.
     *
     * @var         iDomainConfig
     */
    private iDomainConfig $domainConfig;
    /**
     * Configuraçõs para a Aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    private iApplicationConfig $applicationConfig;
    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    private iServerRequest $serverRequest;
    /**
     * Objeto que representa a configuração bruta da rota alvo.
     *
     * @var         array
     */
    private array $rawRouteConfig = [];
    /**
     * Objeto que representa a configuração da rota alvo.
     *
     * @var         iRouteConfig
     */
    private iRouteConfig $routeConfig;
    /**
     * Objeto ``iResponse``.
     *
     * @var         iResponse
     */
    private iResponse $response;
    /**
     * Coleção de headers que devem ser enviados para o UA.
     *
     * @var         array
     */
    private array $useHeaders = [];









    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância ``iServerConfig``.
     *
     * @param       iDomainConfig $domainConfig
     *              Instância ``iDomainConfig``.
     *
     * @param       iApplicationConfig $applicationConfig
     *              Instância ``iApplicationConfig``.
     *
     * @param       iServerRequest $serverRequest
     *              Instância ``iServerRequest``.
     *
     * @param       array $rawRouteConfig
     *              Instância ``iServerConfig``.
     *
     * @param       ?iRouteConfig $routeConfig
     *              Instância ``iRouteConfig``.
     *
     * @param       iResponse $response
     *              Instância ``iResponse``.
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
        if ($routeConfig !== null) {
            $this->routeConfig      = $routeConfig;
        }
        $this->response             = $response;
    }










    /**
     * Prepara o objeto ``iResponse`` com os ``headers`` e com o ``body`` que deve ser usado
     * para responder ao ``UA``.
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

            // Inicia o manipulador do mimetype alvo
            $useMime = \strtoupper($this->routeConfig->getResponseMime());
            $mimeNS = "\\AeonDigital\\EnGarde\\MimeHandler\\$useMime";

            $mimeHandler = new $mimeNS(
                $this->serverConfig,
                $this->domainConfig,
                $this->applicationConfig,
                $this->serverRequest,
                $this->rawRouteConfig,
                $this->routeConfig,
                $this->response
            );


            // Define o novo corpo para o objeto Response
            $useBody = $mimeHandler->createResponseBody();
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

        return $this->response;
    }





    /**
     * Ajusta os headers do objeto Response antes do mesmo ser enviado ao ``UA``.
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
                $this->useHeaders[$key] = \implode(", ", $value);
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
     * Prepara o objeto ``response`` para responder a uma requisição em que foi usado o
     * método ``HTTP OPTIONS``.
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
                "Allow"             => \array_merge(\array_keys($this->rawRouteConfig), ["OPTIONS", "TRACE"]),
                "Allow-Languages"   => $this->applicationConfig->getLocales()
            ]
        );


        // Prepara o Body a ser enviado
        $useBody        = $this->useHeaders;
        $showAllValues  = (
            $this->domainConfig->getIsDebugMode() === true &&
            $this->domainConfig->getEnvironmentType() !== "production"
        );
        $allowedValues  = [
            "routes", "acceptMimes", "relationedRoutes", "description", "devDescription", "metaData"
        ];

        foreach ($this->rawRouteConfig as $method => $config) {
            $cfg = [];

            foreach ($config as $k => $v) {
                if (\in_array($k, $allowedValues) === true || $showAllValues === true) {
                    $cfg[$k] = $v;
                }
            }

            $useBody[$method] = $cfg;
        }

        $body = $this->response->getBody();
        $body->write(\json_encode($useBody));
        $this->response = $this->response->withBody($body);
    }
    /**
     * Prepara o objeto ``response`` para responder a uma requisição em que foi usado o
     * método ``HTTP TRACE``.
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
                "Allow"             => \array_merge(\array_keys($this->rawRouteConfig), ["OPTIONS", "TRACE"]),
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
        $body->write(\json_encode($useBody));
        $this->response = $this->response->withBody($body);
    }
}