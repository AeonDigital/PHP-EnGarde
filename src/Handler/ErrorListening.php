<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler;










/**
 * Classe a ser usada para permitir configurar o tratamento de erros ocorridos em runtime.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
class ErrorListening
{
    use \AeonDigital\Http\Traits\HTTPRawStatusCode;




    /**
     * Como esta versão do framework *EnGarde* foi feita a partir da versão 7.1 do
     * PHP e esta, por sua vez modificou a forma como tratava os "Errors" e as
     * "Exceptions", foi considerado importante adicionar aqui um recorte da
     * [documentação oficial](http://php.net/manual/pt_BR/language.errors.php7.php)
     * que explica em rápidas palavras o que ocorre quando um "Error" ou
     * "Exception" é disparado.
     *
     *
     * [Copiado da página do php.net]
     * O PHP 7 modificou como a maioria dos erros são reportados pelo PHP.
     * Em vez de reportá-los através do mecanismo tradicional de reporte de erros
     * utilizado pelo PHP 5, a maioria dos erros, agora são reportados lançando
     * exceções [Error](http://php.net/manual/pt_BR/class.error.php).
     *
     * Assim como exceções normais, as exceções "Error" serão elevadas até alcançarem
     * o primeiro bloco catch correspondente. Se não existir nenhum bloco
     * correspondente, qualquer manipulador de exceção padrão instalado com a
     * função set_exception_handler() será chamado, e se não existir nenhum
     * manipulador padrão de exceção, a exceção será convertida em um erro fatal e
     * tratada como um erro tradicional.
     */





    /**
     * Politica de tratamento de erros para o framework *EnGarde*;
     *
     * Por padrão um domínio controlado pelo *EnGarde* terá ZERO complacencia com
     * erros e exceções. Isto significa que TODA falha capturada pelo handler do
     * PHP irá interromper o fluxo de processamento naquele ponto e NADA mais será
     * feito.
     *
     * Nestes casos o comportamento comum do framework seguirá as seguintes
     * orientações:
     *
     * SE
     * DEBUG_MODE == true && ENVIRONMENT != "production"
     *
     * HTTP METHOD == GET
     * Código HTTP : 500
     * UA : Recebe uma página de erro contendo informações sobre a falha.
     *
     * HTTP METHOD != GET
     * Código HTTP : 500
     * UA : Recebe um documento JSON com informações sobre a falha.
     *
     *
     * ===
     *
     *
     * SE
     * DEBUG_MODE == false
     *
     * HTTP METHOD == GET
     * Código HTTP : 500
     * UA : Recebe uma página de erro genérica.
     *
     * HTTP METHOD != GET
     * Código HTTP : 500
     * UA : Recebe um documento de erro genérico em formato JSON
     * Exemplo : {"Message": "Internal Server Error"}
     */









    /**
     * Caminho até o diretório raiz do domínio.
     *
     * @var         string
     */
    private static string $rootPath = "";
    /**
     * Tipo de ambiente que o domínio está rodando no momento.
     * Esta propriedade deve ser imutável.
     *
     * @var         string
     */
    private static string $environmentType = "";
    /**
     * Indica se o domínio está em modo de debug.
     * Esta propriedade deve ser imutável.
     *
     * @var         bool
     */
    private static bool $isDebugMode = false;
    /**
     * Protocolo HTTP/HTTPS.
     * Esta propriedade deve ser imutável.
     *
     * @var         string
     */
    private static string $protocol = "";
    /**
     * Método HTTP usado.
     * Esta propriedade deve ser imutável.
     *
     * @var         string
     */
    private static string $method = "";
    /**
     * Caminho completo até a view que deve ser enviada ao
     * UA em caso de erros no domínio.
     *
     * @var         string
     */
    private static string $pathToErrorView = "";










    /**
     * Define o contexto do ambiente carregando as propriedades básicas da instância.
     *
     * @param       string $rootPath
     *              Caminho até o diretório raiz do domínio.
     *
     * @param       string $environmentType
     *              Tipo de ambiente que o domínio está rodando no momento.
     *
     * @param       bool $isDebugMode
     *              Indica se o domínio está em modo de debug.
     *
     * @param       string $protocol
     *              Protocolo HTTP/HTTPS.
     *
     * @param       string $method
     *              Método HTTP usado.
     *
     * @param       string $pathToErrorView
     *              Caminho completo até a view de erros
     */
    static public function setContext(
        string $rootPath,
        string $environmentType,
        bool $isDebugMode,
        string $protocol,
        string $method,
        string $pathToErrorView = ""
    ) : void {
        $isTestEnv = (  self::$environmentType === "" ||
                        self::$environmentType === "UTEST" ||
                        self::$environmentType === "testview" ||
                        self::$environmentType === "localtest");

        if ($isTestEnv === true)
        {
            self::$rootPath         = to_system_path($rootPath) . DIRECTORY_SEPARATOR;
            self::$environmentType  = $environmentType;
            self::$isDebugMode      = $isDebugMode;
            self::$protocol         = strtolower($protocol);
            self::$method           = strtoupper($method);
            self::$pathToErrorView  = $pathToErrorView;
        }
    }
    /**
     * Retorna um array associativo contendo o valor das variáveis do contexto atual.
     *
     * @return      array
     */
    static public function getContext() : array
    {
        return [
            "rootPath"          => self::$rootPath,
            "environmentType"   => self::$environmentType,
            "isDebugMode"       => self::$isDebugMode,
            "protocol"          => self::$protocol,
            "method"            => self::$method,
            "pathToErrorView"   => self::$pathToErrorView
        ];
    }
    /**
     * Elimina totalmente todos os valores das propriedades de contexto.
     *
     * Este método apenas surte efeito se o ambiente onde está rodando estiver definido como ``test``.
     *
     * @return void
     */
    static public function clearContext() : void
    {
        $isTestEnv = (  self::$environmentType === "" ||
                        self::$environmentType === "UTEST" ||
                        self::$environmentType === "testview" ||
                        self::$environmentType === "localtest");

        if ($isTestEnv === true)
        {
            self::$rootPath         = "";
            self::$environmentType  = "";
            self::$isDebugMode      = false;
            self::$protocol         = "";
            self::$method           = "";
            self::$pathToErrorView  = "";
        }
    }





    /**
     * Define o caminho completo até a view que deve ser enviada ao ``UA`` em caso de erros no
     * domínio.
     *
     * @param       string $pathToErrorView
     *              Caminho até a view de erro padrão.
     *
     * @return      void
     */
    static public function setPathToErrorView(string $pathToErrorView = "") : void
    {
        self::$pathToErrorView = "";
        if ($pathToErrorView !== "") {
            self::$pathToErrorView = to_system_path($pathToErrorView);
        }
    }





    /**
     * Prepara um documento ``X/HTML`` para ser enviado ao ``UA``.
     *
     * @param       array $viewData
     *              Objeto de dados do processamento no momento atual.
     *
     * @return      string
     */
    static private function prepareXHTML(array $viewData) : string
    {
        $str = "";

        if (self::$pathToErrorView === "" || file_exists(self::$pathToErrorView) === false) {
            $str = self::createNonStyleErrorPage($viewData);
        } else {
            $viewData = (object)$viewData;

            $viewData->http                 = (object)$viewData->http;
            $viewData->debugLog             = (object)$viewData->debugLog;
            $viewData->debugLog->traceLog   = (object)$viewData->debugLog->traceLog;

            @ob_start("mb_output_handler");
            require_once self::$pathToErrorView;
            $str = @ob_get_contents();
            @ob_end_clean();
        }

        return $str;
    }
    /**
     * Prepara um documento ``JSON`` para ser enviado ao ``UA``.
     *
     * @param       array $viewData
     *              Objeto de dados do processamento no momento atual.
     *
     * @return      string
     */
    static private function prepareJSON(array $viewData) : string
    {
        $str = "";

        if ($viewData["isDebugMode"] === true && $viewData["environmentType"] !== "PRD") {
            $str = json_encode($viewData["debugLog"]);
        } else {
            $str = '{"HTTP": ' . $viewData["http"]["code"] . ', "Message": "' . $viewData["http"]["message"] . '"}';
        }

        return $str;
    }
    /**
     * Monta um ``HTML`` básico para retornar ao usuário uma página não estilizada de um erro
     * disparado.
     *
     * @param       array $viewData
     *              Objeto de dados do processamento no momento atual.
     *
     * @return      string
     */
    static private function createNonStyleErrorPage(array $viewData) : string
    {
        $code       = $viewData["http"]["code"];
        $message    = $viewData["http"]["message"];
        if ($viewData["isDebugMode"] === true && $viewData["environmentType"] !== "PRD") {
            // @codeCoverageIgnoreStart
            $message = $viewData["debugLog"]["message"];
            // @codeCoverageIgnoreEnd
        }


        $str = '<!DOCTYPE html>' . PHP_EOL;
        $str .= '<html>' . PHP_EOL;
        $str .= '    <head>' . PHP_EOL;
        $str .= '        <meta charset="utf-8" />' . PHP_EOL;
        $str .= '        <title>' . $code . ' - ' . $message . '</title>' . PHP_EOL;
        $str .= '    </head>' . PHP_EOL;
        $str .= '    <body>' . PHP_EOL;
        $str .= '        <h1>' . $code . '</h1>' . PHP_EOL;

        if ($message !== "") {
            $str .= '        <h2>' . $message . '</h2>' . PHP_EOL;
        }

        if ($viewData["isDebugMode"] === true && $viewData["environmentType"] !== "PRD") {
            // @codeCoverageIgnoreStart
            $str .= '        <pre>' . PHP_EOL . print_r($viewData["debugLog"], true) . '</pre>' . PHP_EOL;
            // @codeCoverageIgnoreEnd
        }

        $str .= '    </body>' . PHP_EOL;
        $str .= '</html>';

        return $str;
    }





    /**
     * Manipulador padrão para as exceptions ocorridas.
     *
     * @param       \Exception $ex
     *              Exception capturada.
     *
     * @return      void
     */
    static public function onException($ex)
    {
        $errorCode      = $ex->getCode();
        $errorMessage   = $ex->getMessage();
        $errorFile      = $ex->getFile();
        $errorLine      = $ex->getLine();
        $errorTrace     = $ex->getTrace();


        // Gera o TraceLog
        $traceLog = [];
        $count = 0;
        $function = [];
        foreach ($errorTrace as $t) {
            if (isset($t["file"]) === true) {
                $function[] = ((isset($t["function"]) === true &&
                    $t["function"] !== "" &&
                    $t["function"] !== "errorHandler") ? $t["function"] : "");

                $traceLog[] = [
                    "act" => $count,
                    "file" => str_replace(self::$rootPath, "", $t["file"]),
                    "line" => (int)$t["line"],
                    "class" => ((isset($t["class"]) === true && $t["class"] !== "") ? $t["class"] : ""),
                    "function" => "",
                ];

                $count--;
            }
        }


        // Corrige os valores de "function"
        $function[] = "";
        array_shift($function);
        foreach ($traceLog as $k => $newTL) {
            $traceLog[$k]["function"] = $function[$k];
        }


        // Gera o viewData
        $viewData = [
            "rootPath"          => self::$rootPath,
            "environmentType"   => self::$environmentType,
            "isDebugMode"       => self::$isDebugMode,
            "http"              => [
                "code"              => 500,
                "message"           => "Internal Server Error",
                "protocol"          => self::$protocol,
                "method"            => self::$method,
            ],
            "debugLog"          => [
                "code"              => $errorCode,
                "message"           => $errorMessage,
                "file"              => str_replace(self::$rootPath, "", $errorFile),
                "line"              => $errorLine,
                "traceLog"          => $traceLog
            ]
        ];


        if ($viewData["environmentType"] === "UTEST") {
            return $viewData;
        }
        else {
            // @codeCoverageIgnoreStart
            return self::sendToUA($viewData);
            // @codeCoverageIgnoreEnd
        }
    }
    /**
     * Manipulador padrão para os erros ocorridos.
     *
     * @param       int $errorCode
     *              Código do erro que aconteceu.
     *
     * @param       string $errorMessage
     *              Mensagem de erro.
     *
     * @param       string $errorFile
     *              Arquivo onde o erro ocorreu.
     *
     * @param       int $errorLine
     *              Número da linha onde ocorreu a falha.
     *
     * @return      stdClass|void
     */
    static public function onError(
        $errorCode,
        $errorMessage,
        $errorFile,
        $errorLine
    ) {
        // Gera o TraceLog
        $backTrace = debug_backtrace();
        $traceLog = [];


        $count = 0;
        $function = [];
        foreach ($backTrace as $t) {
            if (isset($t["file"]) === true) {
                $function[] = ((isset($t["function"]) === true &&
                    $t["function"] !== "" &&
                    $t["function"] !== "errorHandler") ? $t["function"] : "");

                $traceLog[] = [
                    "act" => $count,
                    "file" => str_replace(self::$rootPath, "", $t["file"]),
                    "line" => (int)$t["line"],
                    "class" => ((isset($t["class"]) === true && $t["class"] !== "") ? $t["class"] : ""),
                    "function" => "",
                ];

                $count--;
            }
        }


        // Corrige os valores de "function"
        $function[] = "";
        array_shift($function);
        foreach ($traceLog as $k => $newTL) {
            $traceLog[$k]["function"] = $function[$k];
        }


        // Gera o viewData
        $viewData = [
            "rootPath"          => self::$rootPath,
            "environmentType"   => self::$environmentType,
            "isDebugMode"       => self::$isDebugMode,
            "http"              => [
                "code"              => 500,
                "message"           => "Internal Server Error",
                "protocol"          => self::$protocol,
                "method"            => self::$method,
            ],
            "debugLog"          => [
                "code"              => $errorCode,
                "message"           => $errorMessage,
                "file"              => str_replace(self::$rootPath, "", $errorFile),
                "line"              => $errorLine,
                "traceLog"          => $traceLog
            ]
        ];


        if ($viewData["environmentType"] === "UTEST") {
            return $viewData;
        }
        else {
            // @codeCoverageIgnoreStart
            return self::sendToUA($viewData);
            // @codeCoverageIgnoreEnd
        }
    }





    /**
     * Lança um erro ``HTTP`` de forma explicita.
     * Este tipo de erro não apresenta informações além do código ``HTTP`` e da ``reason phrase``
     * definidos e não tem como função ajudar a debugar a aplicação.
     *
     * Deve ser usado quando o desenvolvedor deseja lançar uma falha explicita para o ``UA``.
     *
     * @param       int $code
     *              Código ``HTTP``.
     *
     * @param       string $reasonPhrase
     *              Frase razão para o erro.
     *
     * @return      void
     */
    static public function throwHTTPError(
        int $code,
        string $reasonPhrase = ""
    ) {
        if ($reasonPhrase === "" && isset(self::$rawStatusCode[$code]) === true) {
            $reasonPhrase = self::$rawStatusCode[$code];
        }


        // Gera o viewData
        $viewData = [
            "rootPath"          => self::$rootPath,
            "environmentType"   => self::$environmentType,
            "isDebugMode"       => false,
            "http"              => [
                "code"              => $code,
                "message"           => $reasonPhrase,
                "protocol"          => self::$protocol,
                "method"            => self::$method,
            ],
            "debugLog"          => [
                "code"              => $code,
                "message"           => $reasonPhrase,
                "file"              => "",
                "line"              => 0,
                "traceLog"          => []
            ]
        ];


        if ($viewData["environmentType"] === "UTEST") {
            return $viewData;
        }
        else {
            // @codeCoverageIgnoreStart
            return self::sendToUA($viewData);
            // @codeCoverageIgnoreEnd
        }
    }





    /**
     * Prepara os dados coletados e envia-os ao ``UA``.
     *
     * Em um ambiente de testes retornará um array associativo contendo os dados que seriam
     * enviados ao ``UA``.
     *
     * @param       array $viewData
     *              Objeto de dados do processamento no momento atual.
     *
     * @return      void
     */
    static private function sendToUA(array $viewData)
    {
        $http = $viewData["http"];
        $str = "";
        $cType = "";
        if ($http["method"] === "GET") {
            $str = self::prepareXHTML($viewData);
            $cType = "text/html";
        }
        else {
            $str = self::prepareJSON($viewData);
            $cType = "application/json";
        }


        if ($viewData["environmentType"] === "testview" || $viewData["environmentType"] === "localtest") {
            return $str;
        } else {
            // @codeCoverageIgnoreStart
            $strHeader = $http["protocol"] . " " . $http["code"] . " " . $http["message"];
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Content-Type: $cType; charset=utf-8");
            header($strHeader, true, $http["code"]);

            echo $str;
            exit();
            // @codeCoverageIgnoreEnd
        }
    }
}
