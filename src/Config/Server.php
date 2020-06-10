<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Config\iServer as iServer;
use AeonDigital\Interfaces\Http\iFactory as iFactory;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplication;
use AeonDigital\EnGarde\Interfaces\Config\iSecurity as iSecurity;
use AeonDigital\EnGarde\Interfaces\Config\iRoute as iRoute;


/**
 * Implementação de "Config\iServer".
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Server extends BObject implements iServer
{
    use \AeonDigital\Traits\MainCheckArgumentException;




    /**
     * Data e hora do momento em que a requisição chegou ao domínio.
     *
     * @var         \DateTime
     */
    private \DateTime $now;
    /**
     * Data e hora do momento em que a requisição que ativou a aplicação
     * chegou ao domínio.
     *
     * @codeCoverageIgnore
     *
     * @return      \DateTime
     */
    public function getNow() : \DateTime
    {
        return $this->now;
    }



    /**
     * Resgata a versão atual do framework.
     *
     * @codeCoverageIgnore
     *
     * @return      string
     */
    public function getVersion() : string
    {
        return "v0.5.5-beta";
    }





    /**
     * Array associativo contendo todas as variáveis definidas para o servidor no momento atual.
     *
     * @var         array[string => string|int]
     */
    private array $SERVER = [];
    /**
     * Array associativo contendo todas as variáveis definidas para o servidor no momento atual.
     *
     * @var         array[string => string|int]
     */
    private array $FILES = [];
    /**
     * Coleção de headers ``HTTP`` recebidas pela requisição.
     *
     * @var         array[string => mixed]
     */
    private array $HEADERS = [];
    /**
     * Resgata um array associativo contendo todas as variáveis definidas para o servidor no
     * momento atual. Normalmente retorna o conteúdo de ``$_SERVER``.
     *
     * @return      array
     *              Será retornado ``[]`` caso nada tenha sido definido.
     */
    public function getServerVariables() : array
    {
        return \array_merge([], $this->SERVER);
    }



    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna uma coleção de headers ``HTTP`` definidos.
     *
     * @return      array
     *              Retornará ``[]`` caso nenhum seja encontrado.
     */
    public function getRequestHeaders() : array
    {
        return \array_merge([], $this->HEADERS);
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a versão do protocolo ``HTTP``.
     *
     * @return      string
     *              Caso não seja possível identificar a versão deve ser retornado o valor ``1.1``.
     */
    public function getRequestHTTPVersion() : string
    {
        return $this->SERVER["SERVER_PROTOCOL"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Indica se a requisição está exigindo o uso de ``HTTPS``.
     *
     * @return      bool
     */
    public function getRequestIsUseHTTPS() : bool
    {
        return (($this->SERVER["HTTPS"] === "on") || ($this->SERVER["SERVER_PORT"] == 443));
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna o método ``HTTP`` que está sendo usado.
     *
     * @return      string
     */
    public function getRequestMethod() : string
    {
        return (
            (isset($this->serverRequest) === false) ?
            $this->SERVER["REQUEST_METHOD"] :
            $this->getServerRequest()->getMethod()
        );
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
        return $this->SERVER["SERVER_NAME"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a parte ``path`` da ``URI`` que está sendo executada.
     *
     * @return      string
     */
    public function getRequestPath() : string
    {
        return $this->SERVER["REQUEST_URI"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna a porta ``HTTP`` que está sendo evocada.
     *
     * @return      int
     */
    public function getRequestPort() : int
    {
        return $this->SERVER["SERVER_PORT"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna os cookies passados pelo ``UA`` em seu formato bruto.
     *
     * @return      string
     */
    public function getRequestCookies() : string
    {
        return $this->SERVER["HTTP_COOKIE"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     * Retorna os querystrings definidos na ``URI`` em seu formato bruto.
     *
     * @return      string
     */
    public function getRequestQueryStrings() : string
    {
        return $this->SERVER["QUERY_STRING"];
    }
    /**
     * Baseado nos dados da requisição que está sendo executada.
     *
     * Retorna um array de objetos que implementam ``AeonDigital\Interfaces\Stream\iFileStream``
     * representando os arquivos que foram submetidos durante a requisição.
     *
     * @return      array
     *              Os arquivos são resgatados de ``$_FILES``.
     */
    public function getRequestFiles() : array
    {
        return $this->FILES;
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
        $protocol   = $this->getRequestProtocol();
        $domainName = $this->getRequestDomainName();
        $requestURL = $this->getRequestPath();
        $port       = $this->getRequestPort();

        if ($domainName !== "" || $requestURL !== "") {
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
     * Coleção de parametros identificados na URI da requisição.
     *
     * @var         array
     */
    private array $requestRouteParans = [];
    /**
     * Resgata toda a coleção de informações passadas na requisição.
     *
     * Concatena neste resultado as informações submetidas pelo UA.
     * Em caso de colisão de chaves de valores a ordem de prioridade de prevalencia será:
     *
     * - requestRouteParans
     *   Parametros nomeados na própria rota e identificados pelo processamento da mesma.
     * - $_POST
     *   Parametros passados por POST.
     * - $_GET
     *   Parametros passados por GET.
     * - "php://input"
     *   Dados obtidos do stream bruto.
     *
     * Não inclui valores passados via cookies.
     *
     * @return      array
     */
    public function getPostedData() : array
    {
        $rawData = [];
        \parse_str(\file_get_contents("php://input"), $rawData);
        $parans = \array_merge($rawData, $_GET, $_POST, $this->requestRouteParans);

        return $parans;
    }










    /**
     * Caminho completo até o diretório onde o domínio está sendo executado.
     *
     * @var         string
     */
    private string $rootPath = "";
    /**
     * Retorna o endereço completo do diretório onde o domínio está sendo executado.
     *
     * @return      string
     */
    public function getRootPath() : string
    {
        return $this->rootPath;
    }



    private bool $forceHTTPS = false;
    /**
     * Indica que as requisições feitas para o domínio devem ser realizadas sob o protocolo
     * HTTPS.
     *
     * @return      bool
     */
    public function getForceHTTPS() : bool
    {
        return $this->forceHTTPS;
    }
    /**
     * Define se as requisições feitas para o domínio devem ser realizadas sob o protocolo
     * HTTPS.
     *
     * @param       bool $forceHTTPS
     *              Indica se deve forçar o protocolo HTTPS
     *
     * @return      void
     */
    private function setForceHTTPS(bool $forceHTTPS) : void
    {
        $this->forceHTTPS = $forceHTTPS;
    }



    /**
     * Tipo de ambiente que o domínio está rodando no momento.
     *
     * @var         string
     */
    private string $environmentType = "";
    /**
     * Retorna o tipo de ambiente que o domínio está rodando no momento.
     *
     * Valores Esperados:
     *  - ``PRD``   : Production
     *  - ``HML``   : Homolog
     *  - ``QA``    : Quality Assurance
     *  - ``DEV``   : Development
     *  - ``LCL``   : Local
     *  - ``UTEST`` : Unit Test
     *
     * @return      string
     */
    public function getEnvironmentType() : string
    {
        return $this->environmentType;
    }
    /**
     * Define o tipo de ambiente que o domínio está rodando no momento
     *
     * @param       string $environmentType
     *              Tipo de ambiente.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o valor indicado seja inválido
     */
    private function setEnvironmentType(string $environmentType) : void
    {
        $this->environmentType = $this->mainCheckForInvalidArgumentException(
            "environmentType", $environmentType, [
                [
                    "validate"          => "is allowed value",
                    "allowedValues"     => [
                        "PRD",      // Production
                        "HML",      // Homolog
                        "QA",       // Quality Assurance
                        "DEV",      // Development
                        "LCL",      // Local
                        "UTEST"     // Unit Test
                    ],
                    "caseInsensitive"   => true,
                    "executeBeforeReturn"   => function($args) {
                        return \strtoupper($args["argValue"]);
                    }
                ]
            ]
        );
    }



    /**
     * Indica se o domínio está em modo de debug.
     *
     * @var         bool
     */
    private bool $isDebugMode = false;
    /**
     * Retorna ``true`` se o domínio está em modo de debug.
     *
     * @return      bool
     */
    public function getIsDebugMode() : bool
    {
        return $this->isDebugMode;
    }
    /**
     * Define configuração para o modo de debug.
     *
     * @param       bool $isDebugMode
     *              Indique ``true`` se o domínio estiver em modo de debug.
     *
     * @return      void
     */
    private function setIsDebugMode(bool $isDebugMode) : void
    {
        $this->isDebugMode = $isDebugMode;
    }



    /**
     * Indica se a aplicação alvo da requisição deve atualizar suas respectivas rotas.
     *
     * @var         bool
     */
    private bool $isUpdateRoutes = false;
    /**
     * Retorna ``true`` se for para a aplicação alvo atualizar suas respectivas rotas.
     *
     * @return      bool
     */
    public function getIsUpdateRoutes() : bool
    {
        return $this->isUpdateRoutes;
    }
    /**
     * Define configuração que indica para a aplicação algo que ela deve atualizar suas
     * respectivas rotas.
     *
     * @param       bool $isUpdateRoutes
     *              Indique ``true`` se for para a aplicação alvo atualizar suas rotas.
     *
     * @return      void
     */
    private function setIsUpdateRoutes(bool $isUpdateRoutes) : void
    {
        $this->isUpdateRoutes = $isUpdateRoutes;
    }



    /**
     * Array contendo o nomes das aplicações que estão instaladas no domínio.
     *
     * @var         array
     */
    private array $hostedApps = [];
    /**
     * Retorna a coleção de nomes de aplicações instaladas no domínio
     *
     * @return      array
     */
    public function getHostedApps() : array
    {
        return $this->hostedApps;
    }
    /**
     * Define a coleção de nomes das aplicações instaladas no domínio.
     *
     * @param       array $hostedApps
     *              Array contendo o nome de cada uma das aplicações do domínio. Cada uma delas
     *              precisa necessariamente corresponder ao nome de um diretório que fique na
     *              raiz do domínio.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setHostedApps(array $hostedApps) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "hostedApps", $hostedApps, [
                [
                    "validate"          => "is array not empty"
                ],
                [
                    "validate"          => "foreach array child",
                    "foreachChild"      => [
                        [
                            "validate" => "closure",
                            "closure" => function($app) {
                                $r = true;
                                $appPath = $this->getRootPath() . DS . $app;
                                if (\file_exists($appPath) === false) {
                                    $r = false;
                                    $this->customInvalidArgumentExceptionMessage = "The main directory of the application \"" . $app . "\" does not exist.";
                                    $this->showArgumentInExceptionMessage = false;
                                }
                                return $r;
                            },
                            ""
                        ]
                    ],
                ]
            ]
        );
        $this->hostedApps = $hostedApps;
    }



    /**
     * Nome da aplicação padrão do domínio.
     *
     * @var         string
     */
    private string $defaultApp = "";
    /**
     * Retorna o nome da aplicação padrão do domínio.
     *
     * @return      string
     */
    public function getDefaultApp() : string
    {
        return $this->defaultApp;
    }
    /**
     * Define a aplicação padrão para o domínio.
     * A aplicação apontada precisa estar definida em ``hostedApps``.
     *
     * @param       string $defaultApp
     *              Nome da aplicação que será a padrão.
     *              Caso ``''`` será definida a primeira aplicação definida em
     *              ``hostedApps``.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setDefaultApp(string $defaultApp) : void
    {
        if ($defaultApp === "") {
            $defaultApp = $this->hostedApps[0];
        }
        else {
            $this->mainCheckForInvalidArgumentException(
                "defaultApp", $defaultApp, [
                    [
                        "validate"          => "is allowed value",
                        "allowedValues"     => $this->hostedApps
                    ]
                ]
            );
        }
        $this->defaultApp = $defaultApp;
    }



    /**
     * Define o timezone do domínio.
     *
     * @var         string
     */
    private string $dateTimeLocal = "";
    /**
     * Retorna o timezone do domínio.
     * [Lista de fusos horários suportados](http://php.net/manual/en/timezones.php)
     *
     * @return      string
     */
    public function getDateTimeLocal() : string
    {
        return $this->dateTimeLocal;
    }
    /**
     * Define o timezone do domínio.
     *
     * @param       string $dateTimeLocal
     *              Timezone que será definido.
     *              [Lista de fusos horários suportados](http://php.net/manual/en/timezones.php)
     *
     * @return      void
     */
    private function setDateTimeLocal(string $dateTimeLocal) : void
    {
        $this->dateTimeLocal = $dateTimeLocal;
    }



    /**
     * Valor máximo (em segundos) para a execução das requisições.
     *
     * @var         int
     */
    private int $timeout = 0;
    /**
     * Retorna o tempo máximo (em segundos) para a execução das requisições.
     *
     * @return      int
     */
    public function getTimeout() : int
    {
        return $this->timeout;
    }
    /**
     * Define o tempo máximo (em segundos) para a execução das requisições.
     *
     * @param       int $timeout
     *              Timeout que será definido.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setTimeout(int $timeout) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "timeout", $timeout, ["is integer greather than zero"]
        );
        $this->timeout = $timeout;
    }



    /**
     * Valor máximo (em Mb) para o upload de um arquivo.
     *
     * @var         int
     */
    private int $maxFileSize = 0;
    /**
     * Valor máximo (em Mb) para o upload de um arquivo.
     *
     * @return      int
     */
    public function getMaxFileSize() : int
    {
        return $this->maxFileSize;
    }
    /**
     * Define o valor máximo (em Mb) para o upload de um arquivo.
     *
     * @param       int $maxFileSize
     *              Tamanho máximo (em Mb).
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setMaxFileSize(int $maxFileSize) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "maxFileSize", $maxFileSize, ["is integer greather than zero"]
        );
        $this->maxFileSize = $maxFileSize;
    }



    /**
     * Valor máximo (em Mb) para a postagem de dados.
     *
     * @var         int
     */
    private int $maxPostSize = 0;
    /**
     * Valor máximo (em Mb) para a postagem de dados.
     *
     * @return      int
     */
    public function getMaxPostSize() : int
    {
        return $this->maxPostSize;
    }
    /**
     * Define o valor máximo (em Mb) para a postagem de dados.
     *
     * @param       int $maxPostSize
     *              Tamanho máximo (em Mb).
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setMaxPostSize(int $maxPostSize) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "maxPostSize", $maxPostSize, ["is integer greather than zero"]
        );
        $this->maxPostSize = $maxPostSize;
    }



    /**
     * Caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros no domínio.
     *
     * @var         string
     */
    private string $pathToErrorView = "";
    /**
     * Resgata o caminho até a view que deve ser enviada ao ``UA`` em caso de
     * erros no domínio.
     *
     * @param       bool $fullPath
     *              Se ``false`` retornará o caminho relativo.
     *              Quando ``true`` deverá retornar o caminho completo.
     *
     * @return      string
     */
    public function getPathToErrorView(bool $fullPath = false) : string
    {
        return (
            ($fullPath === false) ?
            $this->pathToErrorView :
            $this->rootPath . $this->pathToErrorView
        );
    }
    /**
     * Define o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros no
     * domínio.
     *
     * O caminho deve ser definido a partir do diretório raiz do domínio.
     *
     * @param       string $pathToErrorView
     *              Caminho até a view de erro padrão.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    private function setPathToErrorView(string $pathToErrorView) : void
    {
        $this->pathToErrorView = \to_system_path($pathToErrorView);
        $this->mainCheckForInvalidArgumentException(
            "pathToErrorView", $this->getPathToErrorView(true), [
                [
                    "conditions" => "is string not empty",
                    "validate" => "is file exists",
                ]
            ]
        );
    }



    /**
     * Nome da classe responsável por iniciar a aplicação.
     *
     * @var         string
     */
    private string $applicationClassName = "";
    /**
     * Resgata o nome da classe responsável por iniciar a aplicação.
     *
     * @return      string
     */
    public function getApplicationClassName() : string
    {
        return $this->applicationClassName;
    }
    /**
     * Define o nome da classe responsável por iniciar a aplicação.
     *
     * @param       string $applicationClassName
     *              Nome da classe.
     *
     * @return      void
     */
    private function setApplicationClassName(string $applicationClassName) : void
    {
        $this->mainCheckForInvalidArgumentException(
            "applicationClassName", $applicationClassName, ["is string not empty"]
        );
        $this->applicationClassName = $applicationClassName;
    }










    /**
     * Nome da aplicação que irá responder a requisição.
     *
     * @var         string
     */
    private string $applicationName = "";
    /**
     * Indica se o nome da aplicação foi omitido na ``URI`` da requisição.
     *
     * @var         bool
     */
    private bool $applicationNameOmitted = false;
    /**
     * Local para onde o ``UA`` deve ser redirecionado.
     *
     * @var         string
     */
    private string $newLocationPath = "";
    /**
     * Retorna o nome da aplicação que deve responder a requisição ``HTTP`` atual.
     *
     * @return      string
     */
    public function getApplicationName() : string
    {
        return $this->applicationName;
    }
    /**
     * Indica quando na ``URI`` atual o nome da aplicação a ser executada está omitida. Nestes
     * casos a aplicação padrão deve ser executada.
     *
     * @return      bool
     */
    public function getIsApplicationNameOmitted() : bool
    {
        return $this->applicationNameOmitted;
    }
    /**
     * Retorna o nome completo da classe da aplicação que deve ser instanciada para responder
     * a requisição atual.
     *
     * @return      string
     */
    public function getApplicationNamespace() : string
    {
        return "\\" . $this->applicationName . "\\" . $this->applicationClassName;
    }
    /**
     * Retorna a URI que está sendo requisitada em ``nível de aplicação``, ou seja, irá SEMPRE
     * adicionar o nome da aplicação que está sendo chamada na primeira partícula da URI caso
     * ela esteja omitida.
     * Não irá retornar usar qualquer querystring da requisição, apenas a parte ``path``.
     *
     * @return      string
     */
    public function getApplicationRequestUri() : string
    {
        $url = trim($this->getServerRequest()->getUri()->getPath(), "/");
        if ($this->getIsApplicationNameOmitted() === true) {
            $url = $this->applicationName . "/" . $url;
        }
        return "/" . trim($url, "/");
    }
    /**
     * Pode retornar uma string para onde o UA deve ser redirecionado caso alguma das
     * configurações ou processamento dos presentes dados indique que tal redirecionamento
     * seja necessário.
     *
     * Retorna ``''`` caso nenhum redirecionamento seja necessário.
     *
     * @return      string
     */
    public function getNewLocationPath() : string
    {
        return $this->newLocationPath;
    }





    /**
     * Coleção de Métodos HTTP que podem ser usados pelos desenvolvedores ao
     * criar suas actions dentro da aplicação.
     *
     * @var         array
     */
    private array $developerHTTPMethods = [];
    /**
     * Retorna a coleção de métodos HTTP que devem poder ser usados pelas actions.
     * Ou seja, aqueles que os desenvolvedores terão acesso de configurar.
     *
     * Originalmente estes:
     * "GET", "POST", "PUT", "PATCH", "DELETE"
     *
     * @return      array
     */
    public function getDeveloperHTTPMethods() : array
    {
        return $this->developerHTTPMethods;
    }
    /**
     * Define a coleção de métodos HTTP que os desenvolvedores devem ter acesso
     * de configurar.
     *
     * @param       array $developerHTTPMethods
     *              Coleção de métodos HTTP.
     *
     * @return      void
     */
    private function setDeveloperHTTPMethods(array $developerHTTPMethods) : void
    {
        $this->developerHTTPMethods = $developerHTTPMethods;
    }



    /**
     * Coleção de Métodos HTTP que devem ser usados exclusivamente pelo próprio
     * framework.
     *
     * @var         array
     */
    private array $frameworkHTTPMethods = [];
    /**
     * Retorna a coleção de métodos HTTP que devem poder ser controlados exclusivamente
     * pelo próprio framework.
     *
     * Originalmente estes:
     * "HEAD", "OPTIONS", "TRACE", "DEV", "CONNECT"
     *
     * @return      array
     */
    public function getFrameworkHTTPMethods() : array
    {
        return $this->frameworkHTTPMethods;
    }
    /**
     * Define a coleção de métodos HTTP que o framework devem ter acesso exclusivo
     * para resolver.
     *
     * @param       array $frameworkHTTPMethods
     *              Coleção de métodos HTTP.
     *
     * @return      void
     */
    private function setFrameworkHTTPMethods(array $frameworkHTTPMethods) : void
    {
        $this->frameworkHTTPMethods = $frameworkHTTPMethods;
    }









    /**
     * Inicia uma instância com os dados de configuração atual para o servidor ``HTTP``.
     *
     * @param       array $serverVariables
     *              Array associativo contendo todas as variáveis definidas para o servidor no
     *              momento atual. Normalmente será o conteúdo de ``$_SERVER``.
     *
     * @param       array $uploadedFiles
     *              Coleção de arquivos que estão sendo submetidos na requisição.
     *              Deve ser um array compatível com a estrutura esperada do objeto $_FILES
     *              padrão.
     *
     * @param       array $engineVariables
     *              Array associativo contendo todas as variáveis de configuração para o
     *              motor de aplicações que está sendo iniciado.
     *              São esperados, obrigatoriamente os seguintes valores:
     *
     *              - bool forceHTTPS
     *              Indica se as requisições deste domínio devem ser feitos sob HTTPS.
     *
     *              - string rootPath
     *              Caminho completo até o diretório onde o domínio está sendo executado.
     *              Se não for definido, irá pegar o valor existente em DOCUMENT_ROOT.
     *
     *              - string environmentType
     *              Tipo de ambiente que o domínio está rodando no momento.
     *
     *              -bool isDebugMode
     *              Indica se o domínio está em modo de debug.
     *
     *              - bool isUpdateRoutes
     *              Indica se a aplicação alvo da requisição deve atualizar suas respectivas rotas.
     *
     *              - array hostedApps
     *              Array contendo o nomes das aplicações que estão instaladas no domínio.
     *
     *              - string defaultApp
     *              Nome da aplicação padrão do domínio.
     *
     *              - string dateTimeLocal
     *              Define o timezone do domínio.
     *
     *              - int timeout
     *              Valor máximo (em segundos) para a execução das requisições.
     *
     *              - int maxFileSize
     *              Valor máximo (em Mb) para o upload de um arquivo.
     *
     *              - int maxPostSize
     *              Valor máximo (em Mb) para a postagem de dados.
     *
     *              - string pathToErrorView
     *              Caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros no domínio.
     *
     *              - string applicationClassName
     *              Nome da classe responsável por iniciar a aplicação.
     *
     */
    function __construct(
        array $serverVariables,
        array $uploadedFiles,
        array $engineVariables
    ) {
        $this->now = new \DateTime();



        // Define os valores padrões para as variáveis de servidor.
        $this->SERVER = \array_merge(
            [
                "DOCUMENT_ROOT"     => "",
                "SERVER_PROTOCOL"   => "1.1",
                "HTTPS"             => "",
                "SERVER_PORT"       => 0,
                "REQUEST_METHOD"    => "GET",
                "SERVER_NAME"       => "",
                "REQUEST_URI"       => "",
                "HTTP_COOKIE"       => "",
                "QUERY_STRING"      => ""
            ],
            $serverVariables
        );




        \extract($engineVariables);
        // Efetua tratamento do valores iniciais
        $s = \explode("/", $this->SERVER["SERVER_PROTOCOL"]);
        if (\count($s) === 2) {
            $this->SERVER["SERVER_PROTOCOL"] = $s[1];
        }
        $this->SERVER["REQUEST_METHOD"] = \strtoupper($this->SERVER["REQUEST_METHOD"]);
        $this->SERVER["SERVER_PORT"] = (int)$this->SERVER["SERVER_PORT"];



        // Define o diretório padrão até a raiz do domínio
        $this->rootPath = (
            (\key_exists("rootPath", $engineVariables) === false || $rootPath === "") ?
            $this->SERVER["DOCUMENT_ROOT"] :
            $rootPath
        );
        $this->rootPath = \to_system_path($this->rootPath);



        // Identifica e gera os objetos referentes aos arquivos que estão sendo
        // submetidos nesta requisição.
        if (\count($uploadedFiles) > 0) {
            foreach ($uploadedFiles as $fieldName => $fieldData) {
                if (\is_array($fieldData["error"]) === false) {
                    $this->FILES[$fieldName] = new \AeonDigital\Http\Data\File(
                        new \AeonDigital\Http\Stream\FileStream($fieldData["tmp_name"]),
                        $fieldData["name"],
                        $fieldData["error"]
                    );
                }
                else {
                    $this->FILES[$fieldName] = [];

                    foreach ($fieldData["name"] as $i => $v) {
                        $this->FILES[$fieldName][] = new \AeonDigital\Http\Data\File(
                            new \AeonDigital\Http\Stream\FileStream($fieldData["tmp_name"][$i]),
                            $fieldData["name"][$i],
                            $fieldData["error"][$i]
                        );
                    }
                }
            }
        }



        // Identifica os headers HTTP para ficarem disponíveis de forma
        // separada dos demais valores enviados pelo server.
        $sHeaders = [
            "CONTENT_TYPE", "CONTENT_LENGTH", "PHP_AUTH_USER",
            "PHP_AUTH_PW", "PHP_AUTH_DIGEST", "AUTH_TYPE"
        ];

        foreach ($this->SERVER as $name => $value) {
            $upName = \strtoupper($name);

            if (\in_array($upName, $sHeaders) === true || \mb_substr($upName, 0, 5) === "HTTP_") {
                $key = \str_replace("HTTP_", "", $name);
                $this->HEADERS[$key] = $value;
            }
        }
        if ($this->HEADERS["COOKIE"] === "") { unset($this->HEADERS["COOKIE"]); }





        // Define as demais variáveis relativas a configuração atual
        // do servidor.
        $this->setForceHTTPS($forceHTTPS);
        $this->setEnvironmentType($environmentType);
        $this->setIsDebugMode($isDebugMode);
        $this->setIsUpdateRoutes($isUpdateRoutes);
        $this->setHostedApps($hostedApps);
        $this->setDefaultApp($defaultApp);
        $this->setDateTimeLocal($dateTimeLocal);
        $this->setTimeout($timeout);
        $this->setMaxFileSize($maxFileSize);
        $this->setMaxPostSize($maxPostSize);
        $this->setPathToErrorView($pathToErrorView);
        $this->setApplicationClassName($applicationClassName);
        $this->setDeveloperHTTPMethods($developerHTTPMethods);
        $this->setFrameworkHTTPMethods($frameworkHTTPMethods);





        // Identifica a aplicação que deve ser acionada a partir da requisição
        // que está sendo feita.
        $uriRelativePath = $this->getRequestPath();
        $applicationName = "";


        $this->applicationName = $this->getDefaultApp();
        $this->applicationNameOmitted = true;

        if ($uriRelativePath !== "" && $uriRelativePath !== "/") {
            $applicationName = \strtok(\strtok(\ltrim($uriRelativePath, "/"), "?"), "/");
        }


        if (\in_array($applicationName, $this->getHostedApps()) === true) {
            $this->applicationName = $applicationName;
            $this->applicationNameOmitted = false;
        } else {
            // Permite normalizar a URL mantendo o nome da aplicação conforme
            // foi definida.
            foreach ($this->getHostedApps() as $i => $app) {
                if (\strtolower($applicationName) === \strtolower($app)) {
                    $this->applicationName = $app;
                    $this->applicationNameOmitted = false;

                    $parts = \explode("/", \ltrim($uriRelativePath, "/"));
                    \array_shift($parts);

                    $this->newLocationPath = "/" . $app . "/" . \implode("/", $parts);
                }
            }
        }
    }










    /**
     * Indica quando a configuração do domínio já foi executada.
     *
     * @var         bool
     */
    private bool $isSetPHPConfig = false;
    /**
     * Efetua as configurações necessárias para os manipuladores de exceptions e errors
     * para as aplicações do domínio.
     *
     * @codeCoverageIgnore
     *
     * @return      void
     */
    public function setErrorListening() : void
    {
        // Define o contexto a ser usado para o ``listening`` de falhas..
        \AeonDigital\EnGarde\Handler\ErrorListening::setContext(
            $this->getRootPath(),
            $this->getEnvironmentType(),
            $this->getIsDebugMode(),
            $this->getRequestProtocol(),
            $this->getRequestMethod(),
            $this->getPathToErrorView(true)
        );
        set_exception_handler([\AeonDigital\EnGarde\Handler\ErrorListening::class,   "onException"]);
        set_error_handler([\AeonDigital\EnGarde\Handler\ErrorListening::class,       "onError"], E_ALL);
    }
    /**
     * Efetua configurações para o ``PHP`` conforme as propriedades definidas para esta classe.
     *
     * Esta ação só tem efeito na primeira vez que é executada.
     *
     * @codeCoverageIgnore
     *
     * @throws      \RunTimeException
     *              Caso alguma propriedade obrigatória não tenha sido definida ou seja um valor
     *              inválido.
     */
    public function setPHPConfiguration() : void
    {
        if ($this->isSetPHPConfig === false) {
            $this->isSetPHPConfig = true;



            //
            // Por padrão irá ocultar quaisquer erros, alertas e
            // notificações sempre que ocorrerem.
            // Caberá ao manipulador de erros e exceções mostrar ou não
            // detalhes sobre o que ocorre quando a aplicação falhar.
            //
            //
            // Para que os erros sejam mostrados é preciso alterar os
            // valores abaixo alem do arquivo "php.ini" para setar os
            // seguintes atributos :
            //      display_errors = 1
            //      error_reporting = E_ALL
            \error_reporting(0);
            \ini_set("display_errors", "0");
            if (\function_exists("xdebug_disable")) {
                \xdebug_disable();
            }





            // Define o UTF-8 como o padrão para uso nos domínios
            \mb_internal_encoding("UTF-8");
            \mb_http_output("UTF-8");
            \mb_http_input("UTF-8");
            \mb_language("uni");
            \mb_regex_encoding("UTF-8");


            // Seta o timezone para o domínio
            \date_default_timezone_set($this->getDateTimeLocal());


            // - Define o valor máximo (em segundos) que um processamento pode durar.
            \ini_set("max_execution_time",  (string)$this->getTimeout());

            // - Define os limites aceitáveis para o upload e a postagem de dados vindos do cliente.
            \ini_set("upload_max_filesize", (string)$this->getMaxFileSize());
            \ini_set("post_max_size",       (string)$this->getMaxPostSize());
        }
    }










    /**
     * Objeto ``iFactory``.
     *
     * @var         iFactory
     */
    private iFactory $httpFactory;
    /**
     * Retorna um objeto ``iFactory``.
     *
     * @codeCoverageIgnore
     *
     * @return      iFactory
     */
    public function getHttpFactory() : iFactory
    {
        if (isset($this->httpFactory) === false) {
            $this->httpFactory = new \AeonDigital\Http\Factory();
        }
        return $this->httpFactory;
    }



    /**
     * Objeto ``iServerRequest``.
     *
     * @var         iServerRequest
     */
    private iServerRequest $serverRequest;
    /**
     * Retorna a instância ``iServerRequest`` a ser usada.
     *
     * @codeCoverageIgnore
     *
     * @return      iServerRequest
     */
    public function getServerRequest() : iServerRequest
    {
        if (isset($this->serverRequest) === false) {
            // Inicia a configuração da instância que representa a requisição que está sendo
            // feita para este servidor.
            $this->serverRequest = $this->getHttpFactory()
                ->createServerRequest(
                    $this->getRequestMethod(),
                    $this->getCurrentURI(),
                    $this->getRequestHTTPVersion(),
                    $this->getHttpFactory()->createHeaderCollection($this->getRequestHeaders()),
                    $this->getHttpFactory()->createStreamFromBodyRequest(),
                    $this->getHttpFactory()->createCookieCollection($this->getRequestCookies()),
                    $this->getHttpFactory()->createQueryStringCollection($this->getRequestQueryStrings()),
                    $this->getHttpFactory()->createFileCollection($this->getRequestFiles()),
                    $this->getServerVariables(),
                    $this->getHttpFactory()->createCollection(),
                    $this->getHttpFactory()->createCollection()
            );
        }
        return $this->serverRequest;
    }



    /**
     * Instância ``Config\iApplication`` a ser usada.
     *
     * @var         iApplication
     */
    private iApplication $applicationConfig;
    /**
     * Retorna a instância ``Config\iApplication``.
     *
     * @codeCoverageIgnore
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @return      iApplication
     */
    public function getApplicationConfig(array $config = []) : iApplication
    {
        if (isset($this->applicationConfig) === false) {
            $this->applicationConfig = \AeonDigital\EnGarde\Config\Application::fromArray($config);
        }
        return $this->applicationConfig;
    }



    /**
     * Instância ``Config\iSecurity`` a ser usada.
     *
     * @var         ?iSecurity
     */
    private ?iSecurity $securityConfig = null;
    /**
     * Retorna a instância ``Config\iSecurity`` a ser usada.
     *
     * @codeCoverageIgnore
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @return      ?iSecurity
     */
    public function getSecurityConfig(array $config = []) : ?iSecurity
    {
        if (isset($this->securityConfig) === false && $config !== []) {
            // Seleciona o grupo de credenciais a serem utilizadas para este UA nesta aplicação.
            $config["dbCredentials"] = ENV_DATABASE[$this->getEnvironmentType()][$this->getApplicationName()];


            // Identifica o código de autenticação do UA, se houver
            // Tenta resgatar do cookie de autenticação
            //$secCookie = (
            //    (\key_exists("securityCookieName", $config) === true) ?
            //    $config["securityCookieName"] :
            //    ""
            //);
            //$config["authUserInfo"] = (string)$this->getServerRequest()->getCookie($secCookie);
            $this->securityConfig = \AeonDigital\EnGarde\Config\Security::fromArray($config);
        }
        return $this->securityConfig;
    }



    /**
     * Instância ``Config\iRoute`` a ser usada.
     *
     * @var         ?iRoute
     */
    private ?iRoute $routeConfig = null;
    /**
     * Array de dados brutos que formaram o objeto ``Config\iRoute``.
     *
     * @var         ?array
     */
    private ?array $rawRouteConfig = null;
    /**
     * Retorna a instância ``Config\iRoute`` a ser usada.
     *
     * @codeCoverageIgnore
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @param       bool $isRaw
     *              Quando ``true`` indica que o parametro passado em ``$config`` possui as
     *              informações necessárias para a criação do objeto ``iRoute``, no entanto
     *              este precisa de algum tratamento especial antes da criação da instância.
     *
     * @return      ?iRoute
     */
    public function getRouteConfig(?array $config = null, bool $isRaw = false) : ?iRoute
    {
        if ($this->routeConfig === null) {
            if ($isRaw === false) {
                if ($config !== null) {
                    $this->routeConfig = \AeonDigital\EnGarde\Config\Route::fromArray($config);
                }
            }
            else {
                // Identifica se há alguma falha na definição desta rota.
                $this->checkRouteConfigError($config, $isRaw);
                $this->rawRouteConfig = $config;


                // Em caso de uma configuração em modo 'raw',
                // é preciso identificar se a rota atualmente selecionada possui ou não
                // uma configuração específica para o método HTTP que está sendo usado.
                $httpMethod = $this->getServerRequest()->getMethod();
                if ($config !== null && isset($this->rawRouteConfig["config"][$httpMethod]) === true) {
                    $this->requestRouteParans   = $config["parans"] ?? [];
                    $selectedMethodConfig       = $this->rawRouteConfig["config"][$httpMethod];


                    //
                    // Identifica se a rota é "naturalmente" um download.
                    // ou se o download está sendo forçado via parametro "_download".
                    $isDownload_route = $selectedMethodConfig["responseIsDownload"];

                    // Identifica se o ``UA`` está ou não forçando um download
                    $isDownload_param = $this->getServerRequest()->getParam("_download");
                    $isDownload_param = ($isDownload_param === "true" || $isDownload_param === "1");
                    $selectedMethodConfig["responseIsDownload"] = (
                        $isDownload_param === true || $isDownload_route === true
                    );


                    //
                    // Identifica se o ``UA`` está forçando o uso de pretty_print
                    // via parametro "_pretty_print".
                    $prettyPrint_param = $this->getServerRequest()->getParam("_pretty_print");
                    $prettyPrint_param = ($prettyPrint_param === "true" || $prettyPrint_param === "1");
                    $selectedMethodConfig["responseIsPrettyPrint"] = $prettyPrint_param;


                    //
                    // Uma vez identificada exatamente qual é a rota alvo
                    // e tendo todos seus atributos corretamente definidos, inicia seu objeto
                    // de configuração e inicia a fase de negociação de conteúdo.
                    $this->routeConfig = \AeonDigital\EnGarde\Config\Route::fromArray($selectedMethodConfig);


                    //
                    // Primeiro negocia qual o Locale que deve ser usado para servir ao UA.
                    $isOk = $this->routeConfig->negotiateLocale(
                        $this->getServerRequest()->getResponseLocales(),
                        $this->getServerRequest()->getResponseLanguages(),
                        $this->getApplicationConfig()->getLocales(),
                        $this->getApplicationConfig()->getDefaultLocale(),
                        $this->getServerRequest()->getParam("_locale")
                    );

                    //
                    // Só é capaz de falhar na negociação de locale caso o parametro "_locale"
                    // esteja presente e não seja válido.
                    //
                    // Por que é necessário causar um erro neste caso?
                    // Basicamente por que de outra forma, uma URL com um parametro "_locale" inválido
                    // poderia ser usada causando erro de interpretação por parte do usuário e implicando
                    // na desconfiança sobre a própria aplicação.
                    if ($isOk === false) {
                        $forceLocale = $this->getServerRequest()->getParam("_locale");
                        $err = "Locale \"$forceLocale\" is not supported by this Application.";
                        \AeonDigital\EnGarde\Handler\ErrorListening::throwHTTPError(415, $err);
                    }


                    //
                    // Verifica qual mimetype deve ser usado para responder esta requisição
                    $isOk = $this->routeConfig->negotiateMimeType(
                        $this->getServerRequest()->getResponseMimes(),
                        $this->getServerRequest()->getParam("_mime")
                    );


                    //
                    // Pode falhar nesta negociação em qualquer caso onde o UA especifique (seja via header
                    // ou via querystring) que deseja receber um mimetype que não é suportado pela rota
                    // em questão.
                    if ($isOk === false) {
                        $mime = $this->getServerRequest()->getParam("_mime");
                        if ($mime === null) { $err = "Unsupported media type."; }
                        else { $err = "Media type \"$mime\" is not supported by this URL."; }
                        \AeonDigital\EnGarde\Handler\ErrorListening::throwHTTPError(415, $err);
                    }
                }
            }
        }

        return $this->routeConfig;
    }
    /**
     * Retorna os dados brutos referentes a rota que está sendo executada no momento.
     *
     * @codeCoverageIgnore
     *
     * @return      ?array
     */
    public function getRawRouteConfig() : ?array
    {
        return $this->rawRouteConfig;
    }










    /**
     * Verifica a os dados da rota identificada são válidos.
     * - Se ela foi encontrada e se o método HTTP indicado é compatível.
     *
     * @codeCoverageIgnore
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *
     * @param       bool $isRaw
     *              Quando ``true`` indica que o parametro passado em ``$config`` possui as
     *              informações necessárias para a criação do objeto ``iRoute``, no entanto
     *              este precisa de algum tratamento especial antes da criação da instância.
     *
     * @return      void
     */
    private function checkRouteConfigError(?array $config = null, bool $isRaw = false) : void
    {
        $httpMethod         = $this->getServerRequest()->getMethod();
        $httpErrorCode      = null;
        $httpErrorMessage   = null;

        // SE
        // o método HTTP que está sendo evocado deve ser executado pelo desenvolvedor...
        if (\in_array($httpMethod, $this->getDeveloperHTTPMethods()) === true)
        {
            // Se a rota acessada não foi encontrada...
            if ($config === null) {
                $httpErrorCode      = 404;
                $httpErrorMessage   = "Not Found";
            }
            // Senão, se
            // A rota a ser acessada está configurada
            else {
                $config = (($isRaw === true) ? $config["config"] : $config);

                // Se a rota não está preparada para servir
                // a uma requisição com o método especificado...
                if (isset($config[$httpMethod]) === false) {
                    $httpErrorCode      = 501;
                    $httpErrorMessage   = "Method \"$httpMethod\" is not implemented in this route.";
                }
            }


            // Havendo capturado alguma falha que não pode ser
            // resolvida e precisa entregar ao UA uma mensagem
            // do que ocorreu...
            if ($httpErrorCode !== null) {
                \AeonDigital\EnGarde\Handler\ErrorListening::throwHTTPError($httpErrorCode, $httpErrorMessage);
            }
        }
    }










    /**
     * Inicia uma nova instância ``Config\iServer``.
     *
     * @codeCoverageIgnore
     *
     * @param       array $config
     *              Array associativo contendo as configurações para esta instância.
     *              Esperado um array com 3 posições sendo:
     *              "SERVER" => Equivalente ao valor de $_SERVER
     *              "FILES"  => Equivalente ao valor de $_FILES
     *              "ENGINE" => Contendo todos os valores obrigatórios para a configuração
     *                          do motor da aplicação.
     *
     * @return      iServer
     */
    public static function fromArray(array $config) : iServer
    {
        $serverConfig = new Server(
            $config["SERVER"],
            $config["FILES"],
            $config["ENGINE"]
        );

        // Configura o gerenciador de erros do domínio.
        $serverConfig->setErrorListening();
        // Ativa as configurações do PHP
        $serverConfig->setPHPConfiguration();
        // Inicia as demais instâncias necessárias para compor o contexto
        // atual do servidor e esta respectiva requisição.
        $serverConfig->getHttpFactory();
        $serverConfig->getServerRequest();

        return $serverConfig;
    }
}
