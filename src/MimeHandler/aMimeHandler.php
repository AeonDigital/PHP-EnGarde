<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\MimeHandler;

use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Config\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Config\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Config\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Config\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\iMimeHandler as iMimeHandler;


/**
 * Classe abstrata a ser usada pelas classes concretas manipuladoras
 * de mimetypes.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
abstract class aMimeHandler implements iMimeHandler
{





    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    protected $serverConfig = null;
    /**
     * Instância das configurações do Domínio.
     *
     * @var         iDomainConfig
     */
    protected $domainConfig = null;
    /**
     * Configuraçõs para a Aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    protected $applicationConfig = null;
    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    protected $serverRequest = null;
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
    protected $routeConfig = null;
    /**
     * Objeto "iResponse".
     *
     * @var         iResponse
     */
    protected $response = null;
    /**
     * Caminho relativo a ser usado pelos recursos CSS e Javascript
     * de documentos X/HTML.
     *
     * @var         string
     */
    protected $resourcesBasePath = null;









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
     * @param       iRouteConfig $routeConfig
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
        iRouteConfig $routeConfig,
        iResponse $response
    ) {
        $this->serverConfig         = $serverConfig;
        $this->domainConfig         = $domainConfig;
        $this->applicationConfig    = $applicationConfig;
        $this->serverRequest        = $serverRequest;
        $this->rawRouteConfig       = $rawRouteConfig;
        $this->routeConfig          = $routeConfig;
        $this->response             = $response;

        $resourcesBasePath = str_replace(
                                [$this->domainConfig->getRootPath(), "\\"], 
                                ["", "/"], 
                                $this->applicationConfig->getPathToViewsResources()
                            );
        $this->resourcesBasePath = "/" . trim($resourcesBasePath, "/") . "/";
    }










    /**
     * Efetua o processamento da View e retorna seu 
     * conteúdo em uma string.
     *
     * @return      string
     */
    protected function processViewContent() : string
    {
        $str = "";
        
        // Apenas se há uma view definida...
        if ($this->routeConfig->getView() !== null) {
            $viewData = $this->response->getViewData();
            $viewConfig = $this->response->getViewConfig();

            $viewPath = to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getView());
		    ob_start("mb_output_handler");
            require_once $viewPath;

            $str = "\n" . ob_get_contents();
            @ob_end_clean();
        }

        return $str;
    }
    /**
     * Efetua o processamento da MasterPage e retorna seu 
     * conteúdo em uma string.
     *
     * @return      string
     */
    protected function processMasterPageContent() : string
    {
        $str = "";
        
        // Apenas se há uma masterpage definida...
        if ($this->routeConfig->getMasterPage() !== null) {
            $viewData = $this->response->getViewData();
            $viewConfig = $this->response->getViewConfig();

            $viewMaster = to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getMasterPage());
            ob_start("mb_output_handler");
            require_once $viewMaster;

            $str = ob_get_contents();
            @ob_end_clean();
        }

        return $str;
    }
    /**
     * Efetua o processamento dos atributos "Meta" para documentos
     * X/HTML e retorna seu conteúdo em uma string.
     *
     * @return      string
     */
    protected function processXHTMLMetaData() : string
    {
        $allMetas = $this->routeConfig->getMetaData();
        $strMetas = [];
        
        foreach ($allMetas as $key => $value) {
            $strMetas[] = "<meta name=\"$key\" content=\"". htmlspecialchars($value) ."\" />";
        }
        
        return ((count($strMetas) > 0) ? "\n" . implode("\n", $strMetas) : "");
    }
    /**
     * Efetua o processamento das folhas de estilo a serem incorporadas
     * a um documento X/HTML e retorna seu conteúdo em uma string.
     *
     * @return      string
     */
    protected function processXHTMLStyleSheets() : string
    {
        $allCSSs = $this->routeConfig->getStyleSheets();
        $strCSSs = [];
        
        foreach ($allCSSs as $css) {
            $cssPath = $this->resourcesBasePath . trim($css, "/");
            $strCSSs[] = "<link rel=\"stylesheet\" href=\"$cssPath\" />";
        }
        
        return ((count($strCSSs) > 0) ? "\n" . implode("\n", $strCSSs) : "");
    }
    /**
     * Efetua o processamento dos recursos JavaScript a serem incorporados
     * a um documento X/HTML e retorna seu conteúdo em uma string.
     *
     * @return      string
     */
    protected function processXHTMLJavaScripts() : string
    {
        $allJSs = $this->routeConfig->getJavaScripts();
        $strJSs = [];

        foreach ($allJSs as $js) {
            $jsPath = $this->resourcesBasePath . trim($js, "/");
            $strJSs[] = "<script src=\"$jsPath\"></script>";
        }

        return ((count($strJSs) > 0) ? "\n" . implode("\n", $strJSs) : "");
    }





    /**
     * Efetua um tratamento "prettyPrint" para documentos X/HTML.
     *
     * @param       string $document
     *              String do documento X/HTML.
     * 
     * @param       string $mime
     *              Mime que está sendo usado [ "html" | "xhtml" ].
     * 
     * @return      string
     */
    protected function prettyPrintXHTMLDocument(
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
}
