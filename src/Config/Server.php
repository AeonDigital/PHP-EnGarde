<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\EnGarde\Interfaces\Config\iServer as iServer;
use AeonDigital\EnGarde\Interfaces\Http\iFactory as iFactory;







/**
 * Implementação de "iServer".
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Server implements iServer
{





    /**
     * Array associativo contendo todas as variáveis definidas para o servidor no momento atual.
     *
     * @var         array[string => mixed]
     */
    private array $SERVER = [];
    /**
     * Caminho completo até o diretório onde o domínio está sendo executado.
     *
     * @var         string
     */
    private string $rootPath = "";
    /**
     * Coleção de headers ``HTTP`` recebidas pela requisição.
     *
     * @var         array[string => mixed]
     */
    private array $headers = [];
    /**
     * Objeto ``iFactory``.
     *
     * @var         iFactory
     */
    private iFactory $httpFactory;

    /**
     * Indica se está rodando em um ambiente de testes.
     *
     * @var         bool
     */
    private bool $testEnvironment = false;
    /**
     * Data e Hora da criação desta instância.
     *
     * @var         \DateTime
     */
    private \DateTime $now;





    /**
     * Inicia uma instância com os dados de configuração atual para o servidor ``HTTP``.
     *
     * O valor ``$oServer`` apenas será definido se for em um ambiente de testes.
     * Num ambiente de produção estes valores devem ser definidos automaticamente pelo construtor
     * da classe (provavelmente baseado nos valores de ``$_SERVER`` ).
     *
     * @param       ?array $oServer
     *              Array associativo com as configurações do servidor.
     *
     * @param       bool $testEnvironment
     *              Quando ``true`` permite definir ativamente o valor das propriedades.
     */
    function __construct(array $oServer = [], bool $testEnvironment = false)
    {
        $this->testEnvironment = $testEnvironment;
        $this->setServerVariables($oServer);

        $this->now = new \DateTime();
    }





    /**
     * Resgata um array associativo contendo todas as variáveis definidas para o servidor no
     * momento atual.
     *
     * Será retornado ``null`` caso nada tenha sido definido.
     *
     * @return      ?array
     */
    public function getServerVariables() : ?array
    {
        return $this->SERVER;
    }
    /**
     * Permite definir a coleção de valores das variáveis do servidor que estão atualmente
     * definidas.
     *
     * Este método apenas pode ser efetivo se for em um ambiente de testes.
     * Num ambiente de produção estes valores devem ser definidos automaticamente pelo construtor
     * da classe.
     *
     * @param       array $oServer
     *              Array associativo com as variáveis do servidor.
     *
     * @return      void
     */
    public function setServerVariables(array $oServer) : void
    {
        $this->SERVER = $_SERVER;
        if ($this->testEnvironment === true) {
            $this->SERVER = $oServer;
        }
    }





    /**
     * Retorna um objeto ``iFactory``.
     *
     * @return      iFactory
     */
    public function getHttpFactory() : iFactory
    {
        return $this->httpFactory;
    }
    /**
     * Define uma instância ``iFactory`` para ser usada.
     *
     * @param       iFactory $httpFactory
     *              Instância a ser definida.
     *
     * @return      void
     */
    public function setHttpFactory(iFactory $httpFactory) : void
    {
        $this->httpFactory = $httpFactory;
    }










    /**
     * Retorna o endereço completo do diretório onde o domínio está sendo executado.
     * Normalmente este valor vem de ``$_SERVER`` mas ele pode também ser alterado e definido
     * diretamente através do método ``setRootPath``.
     *
     * @return      string
     */
    public function getRootPath() : string
    {
        if ($this->rootPath === null) {
            $oServer = $this->getServerVariables();
            $this->rootPath = $oServer["DOCUMENT_ROOT"];
        }

        return $this->rootPath;
    }
    /**
     * Define o local onde o domínio está sendo executado.
     *
     * @param       string $rootPath
     *              Endereço completo do diretório.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o caminho indicado seja inválido
     */
    public function setRootPath(string $rootPath) : void
    {
        $rootPath = to_system_path($rootPath);

        if (\file_exists($rootPath) === false || \is_dir($rootPath) === false) {
            $err = "The given directory does not exist.";
            throw new \InvalidArgumentException($err);
        }

        $this->rootPath = $rootPath;
    }





    /**
     * Retorna o ``IP`` do usuário que está no momento visitando o site.
     * Um valor vazio em retorno indica que não foi possível identificar o ``IP``.
     *
     * @return      string
     */
    public function getClientIP() : string
    {
        $ip = "";

        if (\getenv("HTTP_CLIENT_IP") !== false) {
            $ip = \getenv("HTTP_CLIENT_IP");
        } elseif (\getenv("HTTP_X_FORWARDED_FOR") !== false) {
            $ip = \getenv("HTTP_X_FORWARDED_FOR");
        } elseif (\getenv("HTTP_X_FORWARDED") !== false) {
            $ip = \getenv("HTTP_X_FORWARDED");
        } elseif (\getenv("HTTP_FORWARDED_FOR") !== false) {
            $ip = \getenv("HTTP_FORWARDED_FOR");
        } elseif (\getenv("HTTP_FORWARDED") !== false) {
            $ip = \getenv("HTTP_FORWARDED");
        } elseif (\getenv("REMOTE_ADDR") !== false) {
            $ip = \getenv("REMOTE_ADDR");
        }

        return $ip;
    }





    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna uma coleção de headers ``HTTP`` definidos para a requisição que está sendo
     * executada.
     *
     * Retornará ``[]`` caso nenhum seja encontrado.
     *
     * @return      array
     */
    public function getRequestHeaders() : array
    {
        if ($this->headers === []) {
            $oServer = $this->getServerVariables();

            if ($oServer !== null) {
                $sHeaders = [
                    "CONTENT_TYPE", "CONTENT_LENGTH", "PHP_AUTH_USER",
                    "PHP_AUTH_PW", "PHP_AUTH_DIGEST", "AUTH_TYPE"
                ];

                foreach ($oServer as $name => $value) {
                    $upName = \strtoupper($name);

                    if (\in_array($upName, $sHeaders) === true || \mb_substr($upName, 0, 5) === "HTTP_") {
                        $key = \str_replace("HTTP_", "", $name);
                        $this->headers[$key] = $value;
                    }
                }
            }
        }

        return $this->headers;
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a versão do protocolo ``HTTP``.
     *
     * Caso não seja possível identificar a versão deve ser retornado o valor ``1.1``.
     *
     * @return      string
     */
    public function getRequestHTTPVersion() : string
    {
        $v = "1.1";

        $oServer = $this->getServerVariables();
        if (isset($oServer["SERVER_PROTOCOL"]) === true) {
            $s = \explode("/", $oServer["SERVER_PROTOCOL"]);
            if (\count($s) === 2) {
                $v = $s[1];
            }
        }

        return $v;
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Indica se a requisição está exigindo o uso de ``HTTPS``.
     *
     * @return      bool
     */
    public function getRequestIsUseHTTPS() : bool
    {
        $oServer = $this->getServerVariables();
        return ((empty($oServer["HTTPS"]) === false && $oServer["HTTPS"] !== "off") || $oServer["SERVER_PORT"] == 443);
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna o método ``HTTP`` que está sendo usado.
     *
     * @return      string
     */
    public function getRequestMethod() : string
    {
        $oServer = $this->getServerVariables();
        return ((isset($oServer["REQUEST_METHOD"]) === false) ? "GET" : \strtoupper($oServer["REQUEST_METHOD"]));
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna ``http`` ou ``https`` conforme o protocolo que está sendo utilizado pela
     * requisição.
     *
     * @return      string
     */
    public function getRequestProtocol() : string
    {
        return (($this->getRequestIsUseHTTPS() === true) ? "https" : "http");
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna o nome do domínio onde o servidor está operando.
     *
     * @return      string
     */
    public function getRequestDomainName() : string
    {
        $oServer = $this->getServerVariables();
        return $oServer["SERVER_NAME"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a parte ``path`` da ``URI`` que está sendo executada.
     *
     * @return      string
     */
    public function getRequestPath() : string
    {
        $oServer = $this->getServerVariables();
        return $oServer["REQUEST_URI"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a porta ``HTTP`` que está sendo evocada.
     *
     * @return      int
     */
    public function getRequestPort() : int
    {
        $oServer = $this->getServerVariables();
        return (int)$oServer["SERVER_PORT"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna os cookies passados pelo ``UA`` em seu formato bruto.
     *
     * @return      string
     */
    public function getRequestCookies() : string
    {
        $oServer = $this->getServerVariables();
        return ((isset($oServer["HTTP_COOKIE"]) === false) ? "" : $oServer["HTTP_COOKIE"]);
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna os querystrings definidos na ``URI`` em seu formato bruto.
     *
     * @return      string
     */
    public function getRequestQueryStrings() : string
    {
        $oServer = $this->getServerVariables();
        return ((isset($oServer["QUERY_STRING"]) === false) ? "" : $oServer["QUERY_STRING"]);
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     *
     * Retorna um array de objetos que implementam ``AeonDigital\Interfaces\Stream\iFileStream``
     * representando os arquivos que foram submetidos durante a requisição.
     *
     * Os arquivos são resgatados de ``$_FILES``.
     *
     * @return      array
     */
    public function getRequestFiles() : array
    {
        $r = [];

        if (isset($_FILES) === true && \count($_FILES) > 0) {
            foreach ($_FILES as $fieldName => $fieldData) {
                if (\is_array($fieldData["error"]) === false) {
                    $r[$fieldName] = new \AeonDigital\Http\Data\File(
                        new \AeonDigital\Http\Stream\FileStream($fieldData["tmp_name"]),
                        $fieldData["name"],
                        $fieldData["error"]
                    );
                } else {
                    $r[$fieldName] = [];

                    foreach ($fieldData["name"] as $i => $v) {
                        $r[$fieldName][] = new \AeonDigital\Http\Data\File(
                            new \AeonDigital\Http\Stream\FileStream($fieldData["tmp_name"][$i]),
                            $fieldData["name"][$i],
                            $fieldData["error"][$i]
                        );
                    }
                }
            }
        }

        return $r;
    }





    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna uma string que representa toda a ``URI`` que está sendo acessada no momento.
     *
     * O resultado será uma string com o seguinte formato:
     *
     * ```
     *  [ scheme ":" ][ "//" authority ][ "/" path ][ "?" query ]
     * ```
     *
     * Obs: A porção ``fragment``, iniciada pelo caractere ``#`` não é utilizada.
     *
     * @return      string
     */
    public function getCurrentURI() : string
    {
        $str = "";
        $oServer = $this->getServerVariables();

        if ($oServer !== null) {
            $protocol = $this->getRequestProtocol();
            $domainName = $this->getRequestDomainName();
            $requestURL = $this->getRequestPath();
            $port = $this->getRequestPort();


            if (($protocol === "http" && $port === 80) || ($protocol === "https" && $port === 443)) {
                $port = "";
            }

            $str = $protocol . "://" . $domainName;
            if ($port != "") {
                $str .= ":" . $port;
            }
            $str .= \rtrim($requestURL, "/");
        }

        return $str;
    }





    /**
     * Resgata toda a coleção de informações passadas na requisição.
     * Sejam parametros via querystrings ou dados postados atravéz de formulários.
     *
     * Não inclui valores passados via cookies.
     *
     * @return      array
     */
    public function getPostedData() : array
    {
        $rawData = [];
        \parse_str(\file_get_contents("php://input"), $rawData);
        $parans = \array_merge($rawData, $_GET, $_POST);

        $oServer = $this->getServerVariables();

        // SE
        // nenhum parametro foi resgatado
        // E
        // Está em um ambiente de testes ONDE um objeto $SERVER foi definido
        // verifica se alguma informação foi passada via URL
        if ($parans === [] && $this->testEnvironment === true) {
            if ($oServer !== null && isset($oServer["REQUEST_URI"]) === true) {
                $qs = \parse_url($oServer["REQUEST_URI"], PHP_URL_QUERY);
                if ($qs !== null) {
                    \parse_str($qs, $parans);
                }
            }
        }

        return $parans;
    }










    /**
     * Desabilita a função mágica ``__set``.
     *
     * @codeCoverageIgnore
     */
    public function __set($name, $value)
    {
        // Não produz efeito
    }
}