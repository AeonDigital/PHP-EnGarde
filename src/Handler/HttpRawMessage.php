<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Handler;










/**
 * Classe que implementa métodos que servem a função de envio de mensagens ``Http``
 * para o UA de forma simplificada.
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
class HttpRawMessage
{
    use \AeonDigital\Http\Traits\HttpRawStatusCode;




    /**
     * Como esta versão do framework *EnGarde* foi feita após a versão 7.1 do
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
     *
     * @var         string
     */
    private static string $environmentType = "";
    /**
     * Indica se o domínio está em modo de debug.
     *
     * @var         bool
     */
    private static bool $isDebugMode = false;
    /**
     * Protocolo ``Http/Https``.
     *
     * @var         string
     */
    private static string $protocol = "";
    /**
     * Método ``Http`` usado.
     *
     * @var         string
     */
    private static string $method = "";
    /**
     * Caminho completo até a view que deve ser enviada ao
     * UA em caso de erros.
     *
     * @var         string
     */
    private static string $pathToErrorView = "";
    /**
     * Caminho completo até a view que deve ser enviada ao
     * UA em caso de mensagens ``Http`` simples.
     *
     * @var         string
     */
    private static string $pathToHttpMessageView = "";










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
     *              Protocolo ``Http/Https``.
     *
     * @param       string $method
     *              Método ``Http`` usado.
     *
     * @param       string $pathToErrorView
     *              Caminho completo até a view de erros
     *
     * @param       string $pathToHttpMessageView
     *              Caminho completo até a view de mensagem.
     */
    static public function setContext(
        string $rootPath,
        string $environmentType,
        bool $isDebugMode,
        string $protocol,
        string $method,
        string $pathToErrorView = "",
        string $pathToHttpMessageView = ""
    ) : void {
        $isTestEnv = (  self::$environmentType === "" ||
                        self::$environmentType === "UTEST");

        if ($isTestEnv === true)
        {
            self::$rootPath                 = \to_system_path($rootPath) . DIRECTORY_SEPARATOR;
            self::$environmentType          = $environmentType;
            self::$isDebugMode              = $isDebugMode;
            self::$protocol                 = \strtolower($protocol);
            self::$method                   = \strtoupper($method);
            self::$pathToErrorView          = $pathToErrorView;
            self::$pathToHttpMessageView    = $pathToHttpMessageView;
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
            "rootPath"              => self::$rootPath,
            "environmentType"       => self::$environmentType,
            "isDebugMode"           => self::$isDebugMode,
            "protocol"              => self::$protocol,
            "method"                => self::$method,
            "pathToErrorView"       => self::$pathToErrorView,
            "pathToHttpMessageView" => self::$pathToHttpMessageView
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
                        self::$environmentType === "UTEST");

        if ($isTestEnv === true)
        {
            self::$rootPath                 = "";
            self::$environmentType          = "";
            self::$isDebugMode              = false;
            self::$protocol                 = "";
            self::$method                   = "";
            self::$pathToErrorView          = "";
            self::$pathToHttpMessageView    = "";
        }
    }





    /**
     * Define o caminho completo até a view que deve ser enviada ao
     * UA em caso de erros.
     *
     * @param       string $pathToErrorView
     *              Caminho completo até a view.
     *
     * @return      void
     */
    static public function setPathToErrorView(string $pathToErrorView = "") : void
    {
        self::$pathToErrorView = "";
        if ($pathToErrorView !== "") {
            self::$pathToErrorView = \to_system_path($pathToErrorView);
        }
    }





    /**
     * Define o caminho completo até a view que deve ser enviada ao
     * UA em caso de mensagens ``Http`` simples.
     *
     * @param       string $pathToErrorView
     *              Caminho completo até a view.
     *
     * @return      void
     */
    static public function setPathToHttpMessageView(string $pathToHttpMessageView = "") : void
    {
        self::$pathToHttpMessageView = "";
        if ($pathToHttpMessageView !== "") {
            self::$pathToHttpMessageView = \to_system_path($pathToHttpMessageView);
        }
    }





    /**
     * Manipulador padrão para as exceptions.
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
                $function[] = (
                    (
                        isset($t["function"]) === true &&
                        $t["function"] !== "" &&
                        $t["function"] !== "errorHandler"
                    ) ?
                    $t["function"] :
                    ""
                );

                $traceLog[] = [
                    "act"       => $count,
                    "file"      => \str_replace(self::$rootPath, "", $t["file"]),
                    "line"      => (int)$t["line"],
                    "class"     => ((isset($t["class"]) === true && $t["class"] !== "") ? $t["class"] : ""),
                    "function"  => "",
                ];

                $count--;
            }
        }


        // Corrige os valores de "function"
        $function[] = "";
        \array_shift($function);
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
                "file"              => \str_replace(self::$rootPath, "", $errorFile),
                "line"              => $errorLine,
                "traceLog"          => $traceLog
            ]
        ];


        return self::sendToUA($viewData, self::$pathToErrorView);
    }
    /**
     * Manipulador padrão para os erros.
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
        $backTrace = \debug_backtrace();
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
                    "file" => \str_replace(self::$rootPath, "", $t["file"]),
                    "line" => (int)$t["line"],
                    "class" => ((isset($t["class"]) === true && $t["class"] !== "") ? $t["class"] : ""),
                    "function" => "",
                ];

                $count--;
            }
        }


        // Corrige os valores de "function"
        $function[] = "";
        \array_shift($function);
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
                "file"              => \str_replace(self::$rootPath, "", $errorFile),
                "line"              => $errorLine,
                "traceLog"          => $traceLog
            ]
        ];


        return self::sendToUA($viewData, self::$pathToErrorView);
    }





    /**
     * Lança um erro ``Http`` de forma explicita.
     * Este tipo de erro não apresenta informações além do código ``Http`` e da ``reason phrase``
     * definidos e não tem como função ajudar a debugar a aplicação.
     *
     * Deve ser usado quando o desenvolvedor deseja lançar uma falha explicita para o ``UA``.
     *
     * @param       int $code
     *              Código ``Http``.
     *
     * @param       string $reasonPhrase
     *              Frase razão para o erro.
     *
     * @return      void
     */
    static public function throwHttpError(
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
            "isDebugMode"       => self::$isDebugMode,
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


        return self::sendToUA($viewData, self::$pathToErrorView);
    }





    /**
     * Envia para o UA uma mensagem Http básica (código ``Http`` e ``reason phrase``).
     *
     * @param       int $code
     *              Código ``Http``.
     *
     * @param       string $reasonPhrase
     *              Frase razão para o erro.
     *
     * @return      void
     */
    static public function throwHttpMessage(
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
            "isDebugMode"       => self::$isDebugMode,
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


        return self::sendToUA($viewData, self::$pathToHttpMessageView);
    }





    /**
     * Prepara os dados coletados e envia-os ao ``UA``.
     *
     * Em um ambiente de testes retornará uma string contendo os dados brutos que
     * devem ser enviados ao ``UA``.
     *
     * @param       array $viewData
     *              Objeto de dados do processamento no momento atual.
     *
     * @param       string $pathToView
     *              Caminho completo até a view que deve ser usada.
     *
     * @return      void|string
     */
    static private function sendToUA(array $viewData, string $pathToView = "")
    {
        $http = $viewData["http"];
        $str = "";
        $cType = "";
        if ($http["method"] === "GET") {
            $str = self::prepareXHTML($viewData, $pathToView);
            $cType = "text/html";
        }
        else {
            $str = self::prepareJSON($viewData);
            $cType = "application/json";
        }


        if ($viewData["environmentType"] === "UTEST") {
            return $str;
        } else {
            $strHeader = $http["protocol"] . " " . $http["code"] . " " . $http["message"];
            \header("Cache-Control: no-cache, must-revalidate");
            \header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            \header("Content-Type: $cType; charset=utf-8");
            \header($strHeader, true, $http["code"]);

            echo $str;
            exit();
        }
    }





    /**
     * Prepara um documento ``X/HTML`` para ser enviado ao ``UA``.
     *
     * @param       array $viewData
     *              Objeto de dados do processamento no momento atual.
     *
     * @param       string $pathToView
     *              Caminho completo até a view que deve ser usada.
     *
     * @return      string
     */
    static private function prepareXHTML(array $viewData, string $pathToView = "") : string
    {
        $str = "";

        if ($pathToView === "" || \file_exists($pathToView) === false) {
            $str = self::createNonStyleErrorPage($viewData);
        } else {
            $viewData = (object)$viewData;

            $viewData->http                 = (object)$viewData->http;
            $viewData->debugLog             = (object)$viewData->debugLog;
            $viewData->debugLog->traceLog   = (object)$viewData->debugLog->traceLog;

            \ob_start("mb_output_handler");
            require_once $pathToView;
            $str = \ob_get_contents();
            \ob_end_clean();
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
            $str = \json_encode($viewData["debugLog"]);
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
            $message = $viewData["debugLog"]["message"];
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
            $str .= '        <pre>' . PHP_EOL . \print_r($viewData["debugLog"], true) . '</pre>' . PHP_EOL;
        }

        $str .= '    </body>' . PHP_EOL;
        $str .= '</html>';

        return $str;
    }
}
