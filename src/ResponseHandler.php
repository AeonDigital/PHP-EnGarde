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

            // Inicia o manipulador do mimetype alvo
            $useMime = strtoupper($this->routeConfig->getResponseMime());
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

            /*
            // Efetua a criação do corpo do documento a ser entregue
            // conforme o mime que deve ser utilizado
            switch ($this->routeConfig->getResponseMime()) {
                case "html":
                case "xhtml":
                    $this->createResponseBodyXHTML();
                    break;

                case "json":
                    $this->createResponseBodyJSON();
                    break;

                case "txt":
                    $this->createResponseBodyTXT();
                    break;

                case "xml":
                    $this->createResponseBodyXML();
                    break;

                case "csv":
                case "xls":
                case "xlsx":
                    $this->createResponseBodySpreadSheeet();
                    break;
            }*/

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
     * Cria o body a ser entregue para o UA no formato X/HTML.
     * 
     * - Este método permite o uso de MasterPage.
     * - Este método permite o uso de View.
     *
     * @return      void
     */
    private function createResponseBodyXHTML() : void
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
        $resourcesBasePath = "/" . trim($resourcesBasePath, "/") . "/";


        // Gera o código para os recursos de CSS e JS
        $allCSSs = $this->routeConfig->getStyleSheets();
        $strCSSs = [];
        foreach ($allCSSs as $css) {
            $cssPath = $resourcesBasePath . trim($css, "/");
            $strCSSs[] = "<link rel=\"stylesheet\" href=\"$cssPath\" />";
        }
        $strCSSs = ((count($strCSSs) > 0) ? "\n" . implode("\n", $strCSSs) : "");


        $allJSs = $this->routeConfig->getJavaScripts();
        $strJSs = [];
        foreach ($allJSs as $js) {
            $jsPath = $resourcesBasePath . trim($js, "/");
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


        // Aplica "prettyPrint" caso seja requisitado
        if ($this->routeConfig->getResponseIsPrettyPrint() === true) {
            $useBody = $this->prettyPrintXHTMLDocument(
                $useBody,
                $this->routeConfig->getResponseMime()
            );
        }


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
    /**
     * Efetua um tratamento para facilitar leitura 
     * de documentos X/HTML por parte de humanos.
     *
     * @param       string $document
     *              String do documento X/HTML.
     * 
     * @param       string $mime
     *              Mime que está sendo usado [ "html" | "xhtml" ].
     * 
     * @return      string
     */
    private function prettyPrintXHTMLDocument(
        string $document, 
        string $mime
    ) : string {
        $strTidy = $document;
        $configOutput = [];

        if ($strTidy !== "") {
            // Configura o "tidy_parse" para obter uma saida compativel
            // com este formato
            //
            // Lista completa de configurações possíveis
            // http://tidy.sourceforge.net/docs/quickref.html
            $configOutput = [
                "indent"            => true,    // Indica se o código de saida deve estar identado
                "indent-spaces"     => 4,       // Indica a quantidade de espaços usados para cada nível de identação.
                "vertical-space"    => true,    // Irá adicionar algumas linhas em branco para facilitar a leitura.
                "wrap"              => 200,     // Máximo de caracteres que uma linha deve ter.

                "quote-ampersand"   => true,    // Converte todo & para &amp;
                "lower-literals"    => true,    // Converte o valor de atributos pré-definidos para lowercase
                "hide-comments"     => true,    // Remove comentários
                "indent-cdata"      => true,    // Identa sessões CDATA
                "fix-backslash"     => true,    // Corrige toda "\" para "/" em URLs
                "alt-text"          => "-",     // Adiciona o atributo "alt" nas imagens que não o possuem e usa o valor indicado.
                "break-before-br"   => true,    // Indica quando deve inserir um \n imediatamente antes de um <br />

                "char-encoding"     => "utf8"   // Encoding do código de saida.
            ];

            if ($mime === "html") {
                $configOutput["output-html"] = true;
            } elseif ($mime === "xhtml") {
                $configOutput["output-xhtml"] = true;
            }


            $tidy = tidy_parse_string($strTidy, $configOutput, "UTF8");
            $tidy->cleanRepair();
            $strTidy = (string)$tidy;
        }

        return $strTidy;
    }










    /**
     * Cria o body a ser entregue para o UA no formato JSON.
     * 
     * - Este método NÃO permite o uso de MasterPage.
     * - Este método NÃO permite o uso de View.
     *
     * @return      void
     */
    private function createResponseBodyJSON() : void
    {
        $viewData = $this->response->getViewData();
        $isPrettyPrint = $this->routeConfig->getResponseIsPrettyPrint();


        // Converte o valor de "viewData" em uma representação JSON
        $jsonOptions = (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        if ($isPrettyPrint === true) {
            $jsonOptions = (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES |
                            JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
        }
        $useBody = json_encode($viewData, $jsonOptions);


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








    /**
     * Cria o body a ser entregue para o UA no formato TXT.
     * 
     * - Este método permite o uso de MasterPage.
     * - Este método permite o uso de View.
     *
     * @return void
     */
    private function createResponseBodyTXT() : void
    {
        $viewContent    = "";
        $masterContent  = "<view />";
        $viewData       = $this->response->getViewData();
        $viewConfig     = $this->response->getViewConfig();
        $hasTemplate    = false;

        
        // Processa a view definida e resgata o resultado
        // de seu processamento.
        if ($this->routeConfig->getView() !== null) {
            $hasTemplate = true;
            $viewPath = to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getView());
		    ob_start("mb_output_handler");
            require_once $viewPath;

            $viewContent = "\n" . ob_get_contents();
            @ob_end_clean();
        }


        
        // Se há uma masterPage definido efetua
        // seu processamento e armazena seu resultado.
        if ($this->routeConfig->getMasterPage() !== null) {
            $hasTemplate = true;
            $viewMaster = to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getMasterPage());
            ob_start("mb_output_handler");
            require_once $viewMaster;

            $masterContent = ob_get_contents();
            @ob_end_clean();
        }



        // Se há um template definido para ser usado ao criar um documento TXT...
        if ($hasTemplate === true) {
            // Mescla a view com a master page
            $useBody = str_replace("<view />", $viewContent, $masterContent);
        }
        // Caso não exista, irá converter o objeto "viewData" em um formato
        // previamente definido.
        else {
            if ($viewData !== null) {
                $useBody = $this->convertToStructuredString((array)$viewData, "  ");
            }
        }



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
    /**
     * A partir de um array (associativo ou não) devolve uma string
     * estruturada com todos os valores linha a linha e devidamente indexados.
     *
     * @param       mixed $oArray
     *              Valor que será convertido para string.
     *
     * @param       string $indent
     *              Caracteres que servirão para identar o valor. 
     *              Normalmente é um conjunto de espaços vazios ou tabs.
     *
     * @param       string $acIndend
     *              String de identação acumulada pelo uso de sub-níveis.
     *
     * @param       string $parentIndex
     *              Index usado pelo nível superior do array que está sendo 
     *              estruturado no momento.
     *
     * @return      string
     */
    private function convertToStructuredString(
        array $oData,
        string $indent = "", 
        string $acIndend = "", 
        string $parentIndex = ""
    ) : string {
        $str = "";
        $val = [];

        foreach ($oData as $i => $v) {
            $useI = (($parentIndex === "") ? (string)$i : $parentIndex . "." . (string)$i);
            $useTab = (($parentIndex === "") ? "" : $acIndend);

            if (is_assoc($oData) === true && (is_array($oData[$i]) === true || is_a($oData[$i], "\StdClass") === true)) {
                $val[] = $acIndend . "[" . $i . "]";
            }

            if (is_array($v)) {
                $val[] = $this->convertToStructuredString($v, $indent, ($acIndend . $indent), $useI);
            } elseif (is_a($v, "\StdClass")) {
                $val[] = $this->convertToStructuredString((array)$v, $indent, ($acIndend . $indent), $useI);
            } else {
                $val[] = $useTab . "[" . $useI . "] : " . $this->convertValueToString($v, "\"", "\"\"");
            }
        }
        
        $str = implode("\n", $val);
        return $str;
    }
    /**
     * Converte um valor indicado para uma string devidamente tratada
     * para ser utilizada em contexto de um documento de um determinado tipo.
     *
     * @param       mixed $oValue
     *              Valor que será convertido para string.
     *
     * @param       string $outsideQuote
     *              Tipo de aspas que será utilizada para envolver a string final.
     *
     * @param       string $insideQuote
     *              Usado para substituir casos de "$outsideQuote" dentro das strings de valores.
     * 
     * @param       bool $forceQuote
     *              Quando "true" forçará o uso de "quote" definida em "$outsideQuote".
     *
     * @return      string
     */
    private function convertValueToString(
        $oValue,
        string $outsideQuote = "",
        string $insideQuote = "",
        bool $forceQuote = false
    ) : string {
        $str = "";
        $useQuote = ($forceQuote === true);

        if (is_bool($oValue)) {
            $str = ($oValue === true) ? "1" : "0";
        } elseif (is_numeric($oValue)) {
            $str = (string)$oValue;
        } elseif (is_string($oValue)) {
            $str = str_replace($outsideQuote, $insideQuote, $oValue);
            $useQuote = true;
        } elseif (is_a($oValue, "DateTime")) {
            $str = $oValue->format("Y-m-d H:i:s");
            $useQuote = true;
        } elseif (is_object($oValue)) {
            $str = "Object: " . get_class($oValue);
        }

        $q = (($useQuote === true) ? $outsideQuote : "");
        return $q . $str . $q;
    }








    /**
     * Cria o body a ser entregue para o UA no formato XML.
     * 
     * - Este método permite o uso de MasterPage.
     * - Este método permite o uso de View.
     *
     * @return void
     */
    private function createResponseBodyXML() : void
    {
        $viewContent    = "";
        $masterContent  = "<view />";
        $viewData       = $this->response->getViewData();
        $viewConfig     = $this->response->getViewConfig();
        $hasTemplate    = false;

        
        // Processa a view definida e resgata o resultado
        // de seu processamento.
        if ($this->routeConfig->getView() !== null) {
            $hasTemplate = true;
            $viewPath = to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getView());
		    ob_start("mb_output_handler");
            require_once $viewPath;

            $viewContent = "\n" . ob_get_contents();
            @ob_end_clean();
        }


        
        // Se há uma masterPage definido efetua
        // seu processamento e armazena seu resultado.
        if ($this->routeConfig->getMasterPage() !== null) {
            $hasTemplate = true;
            $viewMaster = to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getMasterPage());
            ob_start("mb_output_handler");
            require_once $viewMaster;

            $masterContent = ob_get_contents();
            @ob_end_clean();
        }



        // Se há um template definido para ser usado ao criar um documento XML...
        if ($hasTemplate === true) {
            // Mescla a view com a master page
            $useBody = str_replace("<view />", $viewContent, $masterContent);
        }
        // Caso não exista, irá converter o objeto "viewData" em um formato
        // previamente definido.
        else {
            if ($viewData !== null) {
                $xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\"?><root></root>");
                $this->convertArrayToXML((array)$viewData, $xml);
                $useBody = $xml->asXML();
            }
        }


        // Aplica "prettyPrint" caso seja requisitado
        if ($this->routeConfig->getResponseIsPrettyPrint() === true) {
            $useBody = $this->prettyPrintXMLDocument($useBody);
        }


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
    /**
     * Converte um array associativo em um XML.
     *
     * @param       array $oArray
     *              Objeto que será convertido.
     * 
     * @param       SimpleXMLElement $xml
     *              Instância do objeto XML que será gerado.
     *
     */
    private function convertArrayToXML(array $oArray, \SimpleXMLElement $xml)
    {
        foreach ($oArray as $key => $value) {
            $useKey = $key;

            // Verifica se "key" é um valor numérico
            if (is_numeric($key)) {
                $useKey = "item_" . $key;
            }

            // Se o valor for um novo array, gera um subnode
            // e preenche-o
            if (is_array($value)) {
                $subnode = $xml->addChild($useKey);
                $this->convertArrayToXML($value, $subnode);
            } elseif (is_a($value, "StdClass")) {
                $subnode = $xml->addChild($useKey);
                $this->convertArrayToXML((array)$value, $subnode);
            } else {
                $value = $this->convertValueToString($value);
                $xml->addChild($useKey, htmlspecialchars($value));
            }
        }
    }
    /**
     * Efetua um tratamento para facilitar leitura 
     * de documentos X/HTML por parte de humanos.
     *
     * @param       string $document
     *              String do documento X/HTML.
     * 
     * @return      string
     */
    private function prettyPrintXMLDocument(
        string $document
    ) : string {
        $strTidy = $document;
        $configOutput = [];

        if ($strTidy !== "") {
            // Configura o "tidy_parse" para obter uma saida compativel
            // com este formato
            //
            // Lista completa de configurações possíveis
            // http://tidy.sourceforge.net/docs/quickref.html
            $configOutput = [
                "input-xml"         => true,    // Indica que o código de entrada é um XML
                "output-xml"        => true,    // Tenta converter a string em um documento XML

                "indent"            => true,    // Indica se o código de saida deve estar identado
                "indent-spaces"     => 4,       // Indica a quantidade de espaços usados para cada nível de identação.
                "vertical-space"    => true,    // Irá adicionar algumas linhas em branco para facilitar a leitura.
                "wrap"              => 200,     // Máximo de caracteres que uma linha deve ter.

                "quote-ampersand"   => true,    // Converte todo & para &amp;
                "hide-comments"     => true,    // Remove comentários
                "indent-cdata"      => true,    // Identa sessões CDATA

                "char-encoding"     => "utf8"   // Encoding do código de saida.
            ];

            $tidy = tidy_parse_string($strTidy, $configOutput, "UTF8");
            $tidy->cleanRepair();
            $strTidy = (string)$tidy;
        }

        return $strTidy;
    }








    /**
     * Cria o body a ser entregue para o UA no formato CSV, XLS ou XLSX.
     * 
     * - Este método NÁO permite o uso de MasterPage.
     * - Este método NÃO permite o uso de View.
     *
     * @return      void
     */
    private function createResponseBodySpreadSheeet() : void
    {
        $viewData       = $this->response->getViewData();
        $finalArray     = [];
        $totalColumns   = null;


        $dataTable = (isset($viewData->dataTable) ? $viewData->dataTable : []);
        $useBody = $this->convertArrayToSpreadSheet(
            $dataTable, 
            $this->routeConfig->getResponseMime()
        );


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
    /**
     * Varre o array passado identificando se ele é válido para criar uma planilha.
     *
     * @param       array $dataTable
     *              Array de arrays onde cada membro filho representa uma linha
     *              de dados da planilha.
     *
     * @param       string $outsideQuote
     *              Tipo de aspas que será utilizada para envolver a string final.
     *
     * @param       string $insideQuote
     *              Usado para substituir casos de "$outsideQuote" dentro das strings de valores.
     * 
     * @return      array
     * 
     * @throws      \Exception
     *              Disparará uma exception caso os dados enviados não estejam bem
     *              definidos para a criação da planilha.
     */
    private function prepareArrayToCreateSpreadSheet(
        array $dataTable,
        string $outsideQuote = "",
        string $insideQuote = ""
    ) : array
    {
        $msgError           = null;
        $finalArray         = [];


        if ($dataTable === []) {
            $msgError = "Empty data table.";
        } 
        else {
            $countLines = 1;
            $expectedCountColumns = null;

            // Verifica se o array está minimamente formatado.
            foreach ($dataTable as $dataRow) {
                if (is_a($dataRow, "\StdClass") === true) {
                    $dataRow = (array)$dataRow;
                }


                if (is_array($dataRow) === false) {
                    $msgError .= "Invalid row data [line $countLines]. Must be array object.";
                    break;
                } else {
                    $finalRow = [];
                    $countColumns = count($dataRow);

                    if ($expectedCountColumns === null) {
                        $expectedCountColumns = $countColumns;
                    }

                    if ($countColumns !== $expectedCountColumns) {
                        $msgError .= "Invalid row data [line $countLines]. ";
                        $msgError .= "Expected \"$expectedCountColumns\" columns but there are \"$countColumns\".";
                        break;
                    }

                    // Verifica os valores da linha
                    foreach ($dataRow as $value) {
                        $finalRow[] = $this->convertValueToString($value, $outsideQuote, $insideQuote, true);
                    }

                    
                    $finalArray[] = $finalRow;
                    $countLines++;
                }
            }
        }

        // Havendo algum erro, mostra a falha.
        if ($msgError !== null) {
            throw new \Exception($msgError);
        } 

        return $finalArray;
    }
    /**
     * Efetua a conversão de um array para uma string que representa
     * uma planilha que pode ser CSV, XLS ou XLSX
     *
     * @param       array $dataTable
     *              Array de arrays onde cada membro filho representa uma linha
     *              de dados da planilha.
     * 
     * @param       string $type
     *              Precisa ser um dos tipos de saída, "CSV", "XLS" ou "XLSX".
     * 
     * @return      string
     * 
     * @throws      \Exception
     *              Disparará uma exception caso os dados enviados não estejam bem
     *              definidos para a criação da planilha.
     */
    private function convertArrayToSpreadSheet(array $dataTable, string $type) :string 
    {
        $r                  = "";
        $msgError           = null;
        $allowedTypes       = ["csv", "xls", "xlsx"];
        $finalArray         = [];
        


        if (in_array_ci($type, $allowedTypes) === false) {
            $msgError = "Invalid type [\"$type\"].";
            throw new \Exception($msgError);
        } 
        else {

            switch ($type) {
                case "csv":
                    $finalArray = $this->prepareArrayToCreateSpreadSheet($dataTable, "\"", "\"\"");

                    $tmpData    = [];
                    foreach ($finalArray as $dataRow) {
                        $tmpData[] = implode(",", $dataRow);
                    }
                    $r = implode("\n", $tmpData);
                    break;

                case "xls":
                case "xlsx":
                    $finalArray = $this->prepareArrayToCreateSpreadSheet($dataTable, "", "");
                    // https://gist.github.com/kasparsd/ade34dd94a80b97fb9ec59391a0c620f
                    // http://faisalman.github.io/simple-excel-php/api/0.3/
                    // https://gist.github.com/samatsav/6637984

                    $base = "<table><tbody>[[header]][[body]]</tbody></table>";
                    $base = '<html xmlns:x="urn:schemas-microsoft-com:office:excel"><head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Error Messages</x:Name><x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body><table border="1px"><thead>[[head]]</thead><tbody>[[body]]</tbody></table></body></html>';
                    $base = '<?xml version="1.0"?>
			<?mso-application progid="Excel.Sheet"?>
			<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
				xmlns:o="urn:schemas-microsoft-com:office:office"
				xmlns:x="urn:schemas-microsoft-com:office:excel"
				xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
				xmlns:html="http://www.w3.org/TR/REC-html40">
			<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
			</DocumentProperties>
			<Worksheet ss:Name="Sheet1">
				<Table>[[header]][[body]]</Table>
			</Worksheet>
			</Workbook>';
                    $header = "";
                    $body = "";
                    foreach ($finalArray as $i => $dataRow) {
                        $row = "<tr><td>" . implode("</td><td>", $dataRow) . "</td></tr>";
                        if ($i === 0) {
                            $header = $row;
                        }
                        else {
                            $body .= $row;
                        }
                    }
                    $r = str_replace(["[[header]]", "[[body]]"], [$header, $body], $base);
                    break;
            }

        }

        return $r;
    }


}
