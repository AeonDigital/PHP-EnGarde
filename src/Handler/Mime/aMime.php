<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler\Mime;

use AeonDigital\Interfaces\Http\Server\iMimeHandler as iMimeHandler;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRouteConfig;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\Config\iDomain as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServerConfig;


/**
 * Classe abstrata a ser usada pelas classes concretas manipuladoras de mimetypes.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
abstract class aMime implements iMimeHandler
{





    /**
     * Instância de configuração do Servidor.
     *
     * @var         iServerConfig
     */
    protected iServerConfig $serverConfig;
    /**
     * Instância das configurações do Domínio.
     *
     * @var         iDomainConfig
     */
    protected iDomainConfig $domainConfig;
    /**
     * Configuraçõs para a Aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    protected iApplicationConfig $applicationConfig;
    /**
     * Objeto de configuração da Requisição atual.
     *
     * @var         iServerRequest
     */
    protected iServerRequest $serverRequest;
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
    protected iRouteConfig $routeConfig;
    /**
     * Objeto "iResponse".
     *
     * @var         iResponse
     */
    protected iResponse $response;
    /**
     * Caminho relativo a ser usado pelos recursos CSS e Javascript de documentos X/HTML.
     *
     * @var         string
     */
    protected string $resourcesBasePath = "";









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
     * @param       iRouteConfig $routeConfig
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

        $resourcesBasePath = \str_replace(
                                [$this->domainConfig->getRootPath(), "\\"],
                                ["", "/"],
                                $this->applicationConfig->getPathToViewsResources()
                            );
        $this->resourcesBasePath = "/" . \trim($resourcesBasePath, "/") . "/";
    }










    /**
     * Efetua o processamento da View e retorna seu conteúdo em uma string.
     *
     * @return      string
     */
    protected function processViewContent() : string
    {
        $str = "";

        // Apenas se há uma view definida...
        if ($this->routeConfig->getView() !== "") {
            $viewData = $this->response->getViewData();
            $viewConfig = $this->response->getViewConfig();

            $viewPath = \to_system_path(
                $this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getView()
            );

            \ob_start("mb_output_handler");
            require $viewPath;

            $str = "\n" . \ob_get_contents();
            @\ob_end_clean();
        }

        return $str;
    }
    /**
     * Efetua o processamento da MasterPage e retorna seu conteúdo em uma string.
     *
     * @return      string
     */
    protected function processMasterPageContent() : string
    {
        $str = "";

        // Apenas se há uma masterpage definida...
        if ($this->routeConfig->getMasterPage() !== "") {
            $viewData = $this->response->getViewData();
            $viewConfig = $this->response->getViewConfig();

            $viewMaster = \to_system_path($this->applicationConfig->getPathToViews() . "/" . $this->routeConfig->getMasterPage());
            \ob_start("mb_output_handler");
            require $viewMaster;

            $str = \ob_get_contents();
            @\ob_end_clean();
        }

        return $str;
    }
    /**
     * Efetua o processamento dos atributos ``Meta`` para documentos X/HTML e retorna seu
     * conteúdo em uma string.
     *
     * @return      string
     */
    protected function processXHTMLMetaData() : string
    {
        $allMetas = $this->routeConfig->getMetaData();
        $strMetas = [];

        foreach ($allMetas as $key => $value) {
            $strMetas[] = "<meta name=\"$key\" content=\"". \htmlspecialchars($value) ."\" />";
        }

        return ((\count($strMetas) > 0) ? "\n" . \implode("\n", $strMetas) : "");
    }
    /**
     * Efetua o processamento das folhas de estilo a serem incorporadas a um documento ``X/HTML``
     * e retorna seu conteúdo em uma string.
     *
     * @return      string
     */
    protected function processXHTMLStyleSheets() : string
    {
        $allCSSs = $this->routeConfig->getStyleSheets();
        $strCSSs = [];

        foreach ($allCSSs as $css) {
            $cssPath = $this->resourcesBasePath . \trim($css, "/");
            $strCSSs[] = "<link rel=\"stylesheet\" href=\"$cssPath\" />";
        }

        return ((\count($strCSSs) > 0) ? "\n" . \implode("\n", $strCSSs) : "");
    }
    /**
     * Efetua o processamento dos recursos JavaScript a serem incorporados a um documento
     * ``X/HTML`` e retorna seu conteúdo em uma string.
     *
     * @return      string
     */
    protected function processXHTMLJavaScripts() : string
    {
        $allJSs = $this->routeConfig->getJavaScripts();
        $strJSs = [];

        foreach ($allJSs as $js) {
            $jsPath = $this->resourcesBasePath . \trim($js, "/");
            $strJSs[] = "<script src=\"$jsPath\"></script>";
        }

        return ((\count($strJSs) > 0) ? "\n" . \implode("\n", $strJSs) : "");
    }





    /**
     * Efetua um tratamento ``prettyPrint`` para documentos ``X/HTML``.
     *
     * @param       string $document
     *              String do documento ``X/HTML``.
     *
     * @param       string $mime
     *              Mime que está sendo usado ``[ "html" | "xhtml" ]``.
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
                "alt-text"          => "-",     // Adiciona o atributo "alt" nas imagens que não o possuem.
                "break-before-br"   => true,    // Indica quando deve inserir um \n imediatamente antes de um <br />

                "char-encoding"     => "utf8"   // Encoding do código de saida.
            ];

            if ($mime === "html") {
                $configOutput["output-html"] = true;
            } elseif ($mime === "xhtml") {
                $configOutput["output-xhtml"] = true;
            }


            $tidy = \tidy_parse_string($strTidy, $configOutput, "UTF8");
            $tidy->cleanRepair();
            $strTidy = (string)$tidy;
        }

        return $strTidy;
    }





    /**
     * Converte o valor indicado para uma string a ser usada em um contexto de um documento a
     * ser entregue ao ``UA``.
     *
     * @param       mixed $oData
     *              Valor que será convertido para string.
     *
     * @param       string $quote
     *              Quando o tipo ``natural`` do valor for uma string ou DateTime o resultado
     *              será retornado envolvido por este tipo de aspas.
     *
     * @param       string $escapeQuote
     *              Este valor será usado para ``escapar`` as aspas dentro de um valor que possua
     *              aspas do mesmo tipo definido em ``$quote``.
     *
     * @param       bool $forceQuote
     *              Quando ``true`` forçará o uso de aspas para qualquer tipo de valor.
     *
     * @return      string
     */
    protected function convertValueToString(
        $oData,
        string $quote = "",
        string $escapeQuote = "",
        bool $forceQuote = false
    ) : string {
        $str = "";
        $useQuote = ($forceQuote === true);

        if (\is_bool($oData) === true) {
            $str = ($oData === true) ? "true" : "false";
        } elseif (\is_numeric($oData) === true) {
            $str = (string)$oData;
        } elseif (\is_string($oData) === true) {
            $str = \str_replace($quote, $escapeQuote, $oData);
            $useQuote = true;
        } elseif (\is_a($oData, "\DateTime") === true) {
            $str = $oData->format("Y-m-d H:i:s");
            $useQuote = true;
        } elseif (\is_object($oData) === true) {
            $str = "INSTANCE OF '" . \get_class($oData) . "'";
        }

        $q = (($useQuote === true) ? $quote : "");
        return $q . $str . $q;
    }
    /**
     * A partir de um array (associativo ou não) devolve uma string estruturada com a informação
     * do array de forma a facilitar a leitura por um usuário humano.
     *
     * @param       mixed $oData
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
     *              Index usado pelo nível superior do array que está sendo estruturado no momento.
     *
     * @return      string
     */
    protected function convertArrayToStructuredString(
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

            if (\array_is_assoc($oData) === true &&
                (\is_array($oData[$i]) === true || \is_a($oData[$i], "\StdClass") === true))
            {
                $val[] = $acIndend . "[" . $i . "]";
            }

            if (\is_array($v) === true) {
                $val[] = $this->convertArrayToStructuredString($v, $indent, ($acIndend . $indent), $useI);
            } elseif (\is_a($v, "\StdClass") === true) {
                $val[] = $this->convertArrayToStructuredString((array)$v, $indent, ($acIndend . $indent), $useI);
            } else {
                $val[] = $useTab . "[" . $useI . "] : " . $this->convertValueToString($v, '"', '""');
            }
        }

        $str = \implode("\n", $val);
        return $str;
    }





    /**
     * Converte um array associativo em um ``XML``.
     *
     * @param       array $oData
     *              Objeto que será convertido.
     *
     * @param       SimpleXMLElement $xml
     *              Instância do objeto ``XML`` que será gerado.
     *
     * @return      void
     */
    protected function convertArrayToXML(
        array $oData,
        \SimpleXMLElement $xml
    ) :void {
        foreach ($oData as $key => $value) {
            $useKey = $key;

            // Verifica se "key" é um valor numérico
            if (\is_numeric($key) === true) {
                $useKey = "item_" . $key;
            }

            // Se o valor for um novo array, gera um subnode
            // e preenche-o
            if (\is_array($value) === true) {
                $subnode = $xml->addChild($useKey);
                $this->convertArrayToXML($value, $subnode);
            } elseif (\is_a($value, "\StdClass") === true) {
                $subnode = $xml->addChild($useKey);
                $this->convertArrayToXML((array)$value, $subnode);
            } else {
                $value = $this->convertValueToString($value);
                $xml->addChild($useKey, \htmlspecialchars($value));
            }
        }
    }





    /**
     * Efetua um tratamento para facilitar leitura de documentos ``X/HTML`` por parte de humanos.
     *
     * @param       string $document
     *              String do documento ``X/HTML``.
     *
     * @return      string
     */
    protected function prettyPrintXMLDocument(
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

            $tidy = \tidy_parse_string($strTidy, $configOutput, "UTF8");
            $tidy->cleanRepair();
            $strTidy = (string)$tidy;
        }

        return $strTidy;
    }





    /**
     * Varre o array passado item a item e gera como resposta um novo array contendo dados que
     * podem ser usados para gerar planilhas ``csv``, ``xls`` ou ``xlsx``.
     *
     * @param       array $oData
     *              Array de arrays onde cada membro filho representa uma linha de dados da
     *              planilha.
     *
     * @param       string $quote
     *              Quando o tipo ``natural`` do valor for uma string ou ``\DateTime`` o resultado
     *              será retornado envolvido por este tipo de aspas.
     *
     * @param       string $escapeQuote
     *              Este valor será usado para ``escapar`` as aspas dentro de um valor que possua
     *              aspas do mesmo tipo definido em ``$quote``.
     *
     * @param       bool $forceQuote
     *              Quando ``true`` forçará o uso de aspas para qualquer tipo de valor.
     *
     * @return      array
     *
     * @throws      \Exception
     *              Disparará uma exception caso os dados enviados não estejam bem definidos para
     *              a criação da planilha.
     */
    protected function prepareArrayToCreateSpreadSheet(
        array $oData,
        string $quote = "",
        string $escapeQuote = "",
        bool $forceQuote = false
    ) : array {
        $msgError           = null;
        $finalArray         = [];


        if ($oData === []) {
            $msgError = "Empty data table.";
        }
        else {
            $countLines = 1;
            $expectedCountColumns = null;

            // Verifica se o array está minimamente formatado.
            foreach ($oData as $dataRow) {
                if (\is_a($dataRow, "\StdClass") === true) {
                    $dataRow = (array)$dataRow;
                }


                if (\is_array($dataRow) === false) {
                    $msgError .= "Invalid row data [line $countLines]. Must be array object.";
                    break;
                } else {
                    $finalRow = [];
                    $countColumns = \count($dataRow);

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
                        $finalRow[] = $this->convertValueToString($value, $quote, $escapeQuote, $forceQuote);
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
     * Meta-propriedade para uso em documentos estruturados (xls, xlsx e pdf).
     * Nome do autor do conteúdo.
     *
     * @var         string
     */
    protected string $authorName = "EnGarde! Framework";
    /**
     * Meta-propriedade para uso em documentos estruturados (xls, xlsx e pdf).
     * Nome da empresa criadora do conteúdo.
     *
     * @var         string
     */
    protected string $companyName = "Aeon Digital";
    /**
     * Meta-propriedade para uso em documentos estruturados (xls, xlsx e pdf).
     * Data de criação do documento.
     *
     * @var         \DateTime
     */
    protected \DateTime $createdDate;
    /**
     * Meta-propriedade para uso em documentos estruturados (xls, xlsx e pdf).
     * Palavras chave referentes ao documento.
     *
     * @var         string
     */
    protected string $keywords = "";
    /**
     * Meta-propriedade para uso em documentos estruturados (xls, xlsx e pdf).
     * Descrição do documento.
     *
     * @var         string
     */
    protected string $description = "";
    /**
     * Verifica se o ``$viewData`` possui metadados a serem incorporados
     * nos documentos finais.
     *
     * @return      void
     */
    protected function setDocumentMetaData() : void
    {
        $viewData = $this->response->getViewData();
        $this->createdDate = new \DateTime();

        // Identifica se estão definidos os metadados para serem
        // adicionados no documento final.
        if (isset($viewData->metaData) === true) {
            $strPropNames = [
                "authorName", "companyName", "keywords", "description"
            ];
            foreach ($strPropNames as $propName) {
                if (isset($viewData->metaData->{$propName}) === true &&
                    \is_string($viewData->metaData->{$propName}) === true)
                {
                    $this->{$propName} = $viewData->metaData->{$propName};
                }
            }


            if (isset($viewData->metaData->createdDate) === true &&
                \is_a($viewData->metaData->createdDate, "\DateTime") === true)
            {
                $this->createdDate = $viewData->metaData->createdDate;
            }
        }
    }

}
