<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler;

use AeonDigital\Interfaces\Http\Server\iResponseHandler as iResponseHandler;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;






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





    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    private iServerConfig $serverConfig;
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
     * Instância opcional que utilizará um subsistema
     * que tem como objetivo responder aos métodos ``Http`` especiais
     * que são originalmente reservados para o framework.
     *
     * @var         iResponseHandler
     */
    private iResponseHandler $httpSubSystem;









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
        $this->response     = $response;
    }










    /**
     * Prepara o objeto ``iResponse`` com os ``headers`` e com o ``body`` que deve ser usado
     * para responder ao ``UA``.
     *
     * @return      iResponse
     */
    public function prepareResponse() : iResponse
    {
        $httpMethod = $this->serverConfig->getServerRequest()->getMethod();


        // SE
        // o método Http que está sendo evocado deve ser executado pelo framework...
        if (\array_in_ci($httpMethod, $this->serverConfig->getFrameworkHttpMethods()) === true) {
            // Verifica se existe na aplicação atual algum subsistema definido para responder
            // a este tipo de requisição.
            $allowedHttpSubSystem = $this->serverConfig->getApplicationConfig()->getHttpSubSystemNamespaces();
            if (\key_exists($httpMethod, $allowedHttpSubSystem) === true &&
                \class_exists($allowedHttpSubSystem[$httpMethod]) === true)
            {
                $httpSubSystemNamespace = $allowedHttpSubSystem[$httpMethod];
                $this->httpSubSystem    = new $httpSubSystemNamespace(
                    $this->serverConfig,
                    $this->response
                );
                $this->response = $this->httpSubSystem->prepareResponse();
            }
            // Caso contrário, executa a ação padrão para o método.
            else {
                $fn = "prepareResponseTo$httpMethod";
                $this->$fn();
            }
        }
        // SENÃO
        // Sendo uma requisição que utiliza um método Http
        // que pode ser controlado pelos controllers das aplicações.
        else {

            // Inicia o manipulador do mimetype alvo
            $useMime = \strtoupper($this->serverConfig->getRouteConfig()->getResponseMime());
            $mimeNS = "\\AeonDigital\\EnGarde\\Handler\\Mime\\$useMime";

            $mimeHandler = new $mimeNS(
                $this->serverConfig,
                $this->response
            );


            // Define o novo corpo para o objeto Response
            $useBody = $mimeHandler->createResponseBody();
            $body = $this->response->getBody();
            $body->write($useBody);
            $this->response = $this->response->withBody($body);


            // Prepara os Headers para o envio
            $this->prepareResponseHeaders(
                $this->serverConfig->getRouteConfig()->getResponseMimeType(),
                $this->serverConfig->getRouteConfig()->getResponseLocale(),
                $this->response->getHeaders(),
                $this->serverConfig->getRouteConfig()->getResponseIsDownload(),
                $this->serverConfig->getRouteConfig()->getResponseDownloadFileName()
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
    protected function prepareResponseHeaders(
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
            "Framework"             => "EnGarde!; version=" . $this->serverConfig->getVersion(),
            "Application"           => $this->serverConfig->getApplicationConfig()->getAppName(),
            "Content-Type"          => $useMimeType . "; charset=utf-8",
            "Content-Language"      => $useLocale,
            "RequestDate"           => $this->serverConfig->getNow()->format("D, d M Y H:i:s"),
            "ResponseDate"          => $now->format("D, d M Y H:i:s")
        ];


        //
        // Verifica se a configuração da rota indica que a mesma não é cacheavel.
        // Nestes casos adiciona os headers Http que forçarão os navegadores a não
        // salvarem uma cópia desta resposta.
        // Lembrando: apenas os métodos Http "GET" e "HEAD" são cacheáveis
        if (\in_array($this->serverConfig->getRequestMethod(), ["GET", "HEAD"]) === true &&
            $this->serverConfig->getRouteConfig()->getIsUseCache() === false)
        {
            $this->useHeaders = \array_merge(
                $this->useHeaders,
                [
                    "Expires"       => "Tue, 01 Jan 2000 00:00:00 UTC",
                    "Last-Modified" => $this->serverConfig->getNow()->format("D, d M Y H:i:s") . " UTC",
                    "Cache-Control" => "no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0",
                    "Pragma"        => "no-cache"
                ],
            );
        }



        // Adiciona os headers definidos na action mas não substitui
        // os aqui definidos.
        foreach ($useHeaders as $key => $value) {
            if (isset($this->useHeaders[$key]) === false) {
                $this->useHeaders[$key] = \implode(", ", $value);
            }
        }


        // Tratando-se de um download...
        if ($isDownload === true) {
            if ($downloadFileName === "") {
                $downloadFileName = $now->format("Y-m-d_H-i-s") . "_" .
                    str_replace(
                        "/", "_", trim($this->serverConfig->getApplicationRequestUri(), "/")
                    ) .
                    "." . $this->serverConfig->getRouteConfig()->getResponseMime();
            }
            $this->useHeaders["Content-Disposition"] = "inline; filename=\"$downloadFileName\"";
            $this->useHeaders["Content-Type"] = "application/octet-stream";
        }


        // Aplica os headers no objeto response.
        $this->response = $this->response->withHeaders($this->useHeaders, false);
    }











    /**
     * Prepara o objeto ``response`` para responder a uma requisição em que foi usado o
     * método ``Http HEAD``.
     *
     * @return      void
     */
    private function prepareResponseToHEAD() : void
    {
        $rawRouteConfig         = $this->serverConfig->getRawRouteConfig();
        $frameworkHttpMethods   = $this->serverConfig->getFrameworkHttpMethods();

        // Prepara os Headers a serem utilizados
        $this->prepareResponseHeaders(
            "application/json",
            $this->serverConfig->getApplicationConfig()->getDefaultLocale(),
            [
                "Allow" => \array_merge(\array_keys($rawRouteConfig["config"]), $frameworkHttpMethods),
                "Allow-Languages" => $this->serverConfig->getApplicationConfig()->getLocales()
            ]
        );
    }



    /**
     * Prepara o objeto ``response`` para responder a uma requisição em que foi usado o
     * método ``Http OPTIONS``.
     *
     * @return      void
     */
    private function prepareResponseToOPTIONS() : void
    {
        $rawRouteConfig         = $this->serverConfig->getRawRouteConfig();
        $frameworkHttpMethods   = $this->serverConfig->getFrameworkHttpMethods();

        // Prepara os Headers a serem utilizados
        $this->prepareResponseHeaders(
            "application/json",
            $this->serverConfig->getApplicationConfig()->getDefaultLocale(),
            [
                "Allow" => \array_merge(\array_keys($rawRouteConfig["config"]), $frameworkHttpMethods),
                "Allow-Languages" => $this->serverConfig->getApplicationConfig()->getLocales()
            ]
        );


        // Prepara o Body a ser enviado
        $useBody        = $this->useHeaders;
        $showAllValues  = (
            $this->serverConfig->getIsDebugMode() === true &&
            $this->serverConfig->getEnvironmentType() !== "PRD"
        );
        $allowedValues  = [
            "routes", "acceptMimes", "relationedRoutes", "description", "devDescription", "metaData"
        ];

        foreach ($rawRouteConfig["config"] as $method => $config) {
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
     * método ``Http TRACE``.
     *
     * @return      void
     */
    private function prepareResponseToTRACE() : void
    {
        $now                    = new \DateTime();
        $rawRouteConfig         = $this->serverConfig->getRawRouteConfig();
        $frameworkHttpMethods   = $this->serverConfig->getFrameworkHttpMethods();


        // Prepara os Headers a serem utilizados
        $this->prepareResponseHeaders(
            "application/json",
            $this->serverConfig->getApplicationConfig()->getDefaultLocale(),
            [
                "Allow" => \array_merge(\array_keys($rawRouteConfig["config"]), $frameworkHttpMethods),
                "Allow-Languages" => $this->serverConfig->getApplicationConfig()->getLocales()
            ]
        );


        // Prepara o Body a ser enviado
        $uFiles = $this->serverConfig->getServerRequest()->getUploadedFiles();
        $postedFiles = [];
        foreach ($uFiles as $file) {
            $postedFiles[] = $file->getClientFilename();
        }
        if ($postedFiles === []) { $postedFiles = null; }


        $useBody = [
            "requestDate"   => $this->serverConfig->getNow()->format("D, d M Y H:i:s"),
            "responseDate"  => $now->format("D, d M Y H:i:s"),
            "requestIP"     => $this->serverConfig->getRequestUserAgentIP(),
            "requestURI"       => [
                "protocol"          => $this->serverConfig->getServerRequest()->getUri()->getScheme(),
                "version"           => $this->serverConfig->getRequestHttpVersion(),
                "port"              => $this->serverConfig->getRequestPort(),
                "method"            => $this->serverConfig->getRequestMethod(),
                "domain"            => $this->serverConfig->getServerRequest()->getUri()->getHost(),
                "path"              => $this->serverConfig->getServerRequest()->getUri()->getPath(),
                "query"             => $this->serverConfig->getServerRequest()->getUri()->getQuery(),
                "fragment"          => $this->serverConfig->getServerRequest()->getUri()->getFragment()
            ],
            "headers"       => $this->serverConfig->getRequestHeaders(),
            "requestData" => [
                "queryString"       => $this->serverConfig->getServerRequest()->getQueryParams(),
                "cookies"           => $this->serverConfig->getServerRequest()->getCookieParams(),
                "postedData"        => $this->serverConfig->getServerRequest()->getParsedBody(),
                "postedFiles"       => $postedFiles
            ]
        ];

        $body = $this->response->getBody();
        $body->write(\json_encode($useBody));
        $this->response = $this->response->withBody($body);
    }



    /**
     * Prepara o objeto ``response`` para responder a uma requisição em que foi usado o
     * método ``Http DEV``.
     *
     * @return      void
     */
    private function prepareResponseToDEV() : void
    {
        throw new \RuntimeException("The \"DEV\" method was not implemented.");
    }



    /**
     * Prepara o objeto ``response`` para responder a uma requisição em que foi usado o
     * método ``Http CONNECT``.
     *
     * @return      void
     */
    private function prepareResponseToCONNECT() : void
    {
        throw new \RuntimeException("The \"CONNECT\" method was not implemented.");
    }
}
