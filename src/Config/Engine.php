<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\Config;

use AeonDigital\BObject as BObject;
use AeonDigital\EnGarde\Interfaces\Config\iEngine as iEngine;
use AeonDigital\EnGarde\Interfaces\Config\iApplication as iApplicationConfig;






/**
 * Implementação de "Config\iEngine".
 *
 * @package     AeonDigital\EnGarde
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     ADPL-v1.0
 */
final class Engine extends BObject implements iEngine
{





    /**
     * Versão do framework.
     *
     * @var         string
     */
    private string $version = "v0.5.0-beta";
    /**
     * Resgata a versão atual do framework.
     *
     * @return      string
     */
    public function getVersion() : string
    {
        return $this->version;
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
     * Valores comuns:
     *  - "production"  :   Indica que trata-se de um ambiente de produção.
     *  - "development" :   Indica um ambiente de desenvolvimento e homologação.
     *  - "local"       :   Trata-se de um ambiente local; Máquina local de um programador.
     *  - "test"        :   Quando estiver efetuando testes unitários.
     *  - "testview"    :   Para testes unitários que efetuam validação de retorno de Views.
     *  - "localtest"   :   Deve funcionar tal qual "local" mas indica uma configuração para testes unitários.
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
     */
    public function setEnvironmentType(string $environmentType) : void
    {
        if ($this->environmentType === "") {
            $this->environmentType = $environmentType;
        }
    }





    /**
     * Indica se o domínio está em modo de debug.
     *
     * @var         ?bool
     */
    private ?bool $isDebugMode = null;
    /**
     * Retorna ``true`` se o domínio está em modo de debug.
     *
     * @return      bool
     */
    public function getIsDebugMode() : bool
    {
        return (($this->isDebugMode === null) ? false : $this->isDebugMode);
    }
    /**
     * Define configuração para o modo de debug.
     *
     * @param       bool $isDebugMode
     *              Indique ``true`` se o domínio estiver em modo de debug.
     *
     * @return      void
     */
    public function setIsDebugMode(bool $isDebugMode) : void
    {
        if ($this->isDebugMode === null) {
            $this->isDebugMode = $isDebugMode;
        }
    }





    /**
     * Indica se a aplicação alvo da requisição deve atualizar suas respectivas rotas.
     *
     * @var         ?bool
     */
    private ?bool $isUpdateRoutes = null;
    /**
     * Retorna ``true`` se for para a aplicação alvo atualizar suas respectivas rotas.
     *
     * @return      bool
     */
    public function getIsUpdateRoutes() : bool
    {
        return (($this->isUpdateRoutes === null) ? false : $this->isUpdateRoutes);
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
    public function setIsUpdateRoutes(bool $isUpdateRoutes) : void
    {
        if ($this->isUpdateRoutes === null) {
            $this->isUpdateRoutes = $isUpdateRoutes;
        }
    }





    /**
     * Caminho completo até o diretório raiz do domínio.
     *
     * @var         string
     */
    private string $rootPath = "";
    /**
     * Retorna o caminho completo até o diretório raiz do domínio.
     *
     * @return      string
     */
    public function getRootPath() : string
    {
        return $this->rootPath;
    }
    /**
     * Define o caminho completo até o diretório raiz do domínio.
     *
     * @param       string $rootPath
     *              Caminho completo até a raiz do domínio.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function setRootPath(string $rootPath) : void
    {
        if ($this->rootPath === "") {
            $err = null;
            // Se nenhum caminho foi definido para o caminho da raiz do domínio
            if ($rootPath === "") {
                $err = "The path to the root directory is invalid. Empty string received.";
            } else {
                // Verifica o diretório raiz da aplicação
                $rootPath = \to_system_path($rootPath) . DS;
                if (\file_exists($rootPath) === false) {
                    $err = "The path to the root directory does not exist [ \"" . \trim($rootPath, DS) . "\" ].";
                }
            }


            if ($err === null) {
                $this->rootPath = $rootPath;
            } else {
                throw new \InvalidArgumentException($err);
            }
        }
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
    public function setHostedApps(array $hostedApps) : void
    {
        if ($this->hostedApps === []) {
            $err = null;
            if (\count($hostedApps) === 0) {
                $err = "No application was set for engine configuration.";
            } else {
                foreach ($hostedApps as $app) {
                    $appPath = $this->rootPath . (string)$app;
                    if (\file_exists($appPath) === false) {
                        $err = "The main directory of the application \"" . (string)$app . "\" does not exist.";
                    }
                }
            }

            if ($err === null) {
                $this->hostedApps = $hostedApps;
            } else {
                throw new \InvalidArgumentException($err);
            }
        }
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
    public function setDefaultApp(string $defaultApp) : void
    {
        if ($this->defaultApp === "") {
            if ($defaultApp === "") {
                $defaultApp = $this->hostedApps[0];
            }

            if (\in_array($defaultApp, $this->hostedApps) === true) {
                $this->defaultApp = $defaultApp;
            } else {
                $err = "The application \"" . $defaultApp . "\" does not exist between hosted applications.";
                throw new \InvalidArgumentException($err);
            }
        }
    }





    /**
     * Define o timezone do domínio.
     *
     * @var         string
     */
    private string $dateTimeLocal = "";
    /**
     * Retorna o timezone do domínio.
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
    public function setDateTimeLocal(string $dateTimeLocal) : void
    {
        if ($this->dateTimeLocal === "") {
            $this->dateTimeLocal = $dateTimeLocal;
        }
    }





    /**
     * Valor máximo (em segundos) para a execução das requisições.
     *
     * @var         int
     */
    private int $timeOut = 0;
    /**
     * Retorna o tempo máximo (em segundos) para a execução das requisições.
     *
     * @return      int
     */
    public function getTimeOut() : int
    {
        return $this->timeOut;
    }
    /**
     * Define o tempo máximo (em segundos) para a execução das requisições.
     *
     * @param       int $timeOut
     *              Timeout que será definido.
     *
     * @return      void
     */
    public function setTimeOut(int $timeOut) : void
    {
        if ($this->timeOut === 0) {
            $this->timeOut = $timeOut;
        }
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
     */
    public function setMaxFileSize(int $maxFileSize) : void
    {
        if ($this->maxFileSize === 0) {
            $this->maxFileSize = $maxFileSize;
        }
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
     */
    public function setMaxPostSize(int $maxPostSize) : void
    {
        if ($this->maxPostSize === 0) {
            $this->maxPostSize = $maxPostSize;
        }
    }





    /**
     * Caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros no domínio.
     *
     * @var         string
     */
    private string $pathToErrorView = "";
    /**
     * Resgata o caminho relativo até a view que deve ser enviada ao ``UA`` em caso de erros no
     * domínio.
     *
     * @return      string
     */
    public function getPathToErrorView() : string
    {
        return $this->pathToErrorView;
    }
    /**
     * Resgata o caminho completo até a view que deve ser enviada ao ``UA`` em caso de erros no
     * domínio.
     *
     * @return      ?string
     */
    public function getFullPathToErrorView() : string
    {
        return (($this->pathToErrorView === "") ? "" : $this->rootPath . $this->pathToErrorView);
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
     */
    public function setPathToErrorView(string $pathToErrorView) : void
    {
        if ($this->pathToErrorView === "") {
            $this->pathToErrorView = \to_system_path(\trim($pathToErrorView, "/\\"));
        }
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
    public function setApplicationClassName(string $applicationClassName) : void
    {
        if ($this->applicationClassName === "") {
            $this->applicationClassName = $applicationClassName;
        }
    }










    /**
     * A partir da ``URL`` que está sendo executada infere qual das aplicações registradas para
     * o domínio deve ser executada.
     *
     * Infere também se o nome da aplicação foi omitido na ``URI``.
     *
     * @param       string $uriRelativePath
     *              Parte relativa da URI que está sendo executada.
     *
     * @return      void
     */
    public function defineTargetApplicationName(string $uriRelativePath) : void
    {
        if ($this->applicationName === "") {
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
    }



    /**
     * Nome da aplicação que irá responder a requisição.
     *
     * @var         string
     */
    private string $applicationName = "";
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
     * Indica se o nome da aplicação foi omitido na ``URI`` da requisição.
     *
     * @var         bool
     */
    private bool $applicationNameOmitted = false;
    /**
     * Indica quando na ``URI`` atual o nome da aplicação a ser executada está omitida. Nestes
     * casos a aplicação padrão deve ser executada.
     *
     * @return      bool
     */
    public function isApplicationNameOmitted() : bool
    {
        return $this->applicationNameOmitted;
    }



    /**
     * Retorna o nome completo da classe da aplicação que deve ser instanciada para responder
     * a requisição atual.
     *
     * @return      string
     */
    public function retrieveApplicationNS() : string
    {
        $r = "";
        if ($this->applicationName !== "" && $this->applicationClassName !== "") {
            $r = "\\" . $this->applicationName . "\\" . $this->applicationClassName;
        }
        return $r;
    }





    /**
     * Local para onde o ``UA`` deve ser redirecionado.
     *
     * @var         string
     */
    private string $newLocationPath = "";
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
     * Indica quando a configuração do domínio já foi executada.
     *
     * @var         bool
     */
    private bool $isSetConfig = false;
    /**
     * Efetua configurações para o ``PHP`` conforme as propriedades definidas para esta classe.
     *
     * Esta ação só tem efeito na primeira vez que é executada.
     *
     * @throws      \RunTimeException
     *              Caso alguma propriedade obrigatória não tenha sido definida ou seja um valor
     *              inválido.
     */
    public function setPHPConfiguration() : void
    {
        if ($this->isSetConfig === false) {
            $this->isSetConfig = true;



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
            \ini_set("max_execution_time", (string)$this->getTimeOut());

            // - Define os limites aceitáveis para o upload e a postagem de dados vindos do cliente.
            \ini_set("upload_max_filesize", (string)$this->getMaxFileSize());
            \ini_set("post_max_size", (string)$this->getMaxPostSize());
        }
    }







    /**
     * Instância ``Config\iApplication`` a ser usada.
     *
     * @var         iApplicationConfig
     */
    private iApplicationConfig $applicationConfig;
    /**
     * Retorna a instância ``Config\iApplication``.
     *
     * @codeCoverageIgnore
     *
     * @return      iApplicationConfig
     */
    public function getApplicationConfig() : iApplicationConfig
    {
        $this->initiApplicationConfig();
        return $this->applicationConfig;
    }
    /**
     * Inicia a instância ``Config\iApplication`` a ser usada.
     *
     * @codeCoverageIgnore
     *
     * @return      void
     */
    public function initiApplicationConfig() : void
    {
        if (isset($this->applicationConfig) === false) {
            $this->applicationConfig = new \AeonDigital\EnGarde\Config\Application(
                $this->getApplicationName(),
                $this->getRootPath()
            );
        }
    }
}
