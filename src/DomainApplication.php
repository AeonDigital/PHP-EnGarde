<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde;

use AeonDigital\EnGarde\Interfaces\iApplication as iApplication;
use AeonDigital\Http\Tools\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Interfaces\iRouteConfig as iRouteConfig;




/**
 * Classe abstrata que deve ser herdada pelas classes
 * concretas em cada Aplicações *EnGarde*.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
abstract class DomainApplication implements iApplication
{





    /**
     * Objeto de configuração do servidor.
     *
     * @var         iServerConfig
     */
    protected $serverConfig = null;
    /**
     * Retorna o objeto de configuração do Servidor.
     * 
     * @return      iServerConfig
     */
    public function getServerConfig() : iServerConfig
    {
        return $this->serverConfig;
    }
    /**
     * Define o objeto de configuração do servidor.
     *
     * @param       iServerConfig $serverConfig
     *              Configuração do Servidor.
     * 
     * @return      void
     */
    public function setServerConfig(iServerConfig $serverConfig) : void
    {
        if ($this->serverConfig === null) {
            $this->serverConfig = $serverConfig;
        }
    }





    /**
     * Instância das configurações do domínio.
     *
     * @var         iDomainConfig
     */
    protected $domainConfig = null;
    /**
     * Retorna o objeto de configuração do domínio.
     * 
     * @return      iDomainConfig
     */
    public function getDomainConfig() : iDomainConfig
    {
        return $this->domainConfig;
    }
    /**
     * Define a configuração para o Domínio.
     *
     * @param       iDomainConfig $domainConfig
     *              Configuração do Domínio.
     * 
     * @return      void
     */
    public function setDomainConfig(iDomainConfig $domainConfig) : void
    {
        if ($this->domainConfig === null) {
            $this->domainConfig = $domainConfig;
        }
    }





    /**
     * Configuraçõs para a aplicação corrente.
     *
     * @var         iApplicationConfig
     */
    protected $applicationConfig = null;
    /**
     * Retorna o objeto de configuração para a aplicação corrente.
     * 
     * @return      iApplicationConfig
     */
    public function getApplicationConfig() : iApplicationConfig
    {
        return $this->applicationConfig;
    }
    /**
     * Define a configuração para esta Aplicação.
     *
     * @param       iDomainConfig $applicationConfig
     *              Configuração da Aplicação.
     * 
     * @return      void
     */
    public function setApplicationConfig(iApplicationConfig $applicationConfig) : void
    {
        // Se presente, define as propriedades padrões
        // para as rotas da aplicação.
        $const = static::class . "::defaultRouteConfig";
        if (defined($const) === true) {
            $applicationConfig->setDefaultRouteConfig(static::defaultRouteConfig);
        }
        $this->applicationConfig = $applicationConfig;
    }






    /**
     * Objeto que representa a configuração da rota alvo.
     *
     * @var         iRouteConfig
     */
    protected $routeConfig = null;
    /**
     * Retorna o objeto de configuração para a rota que deve ser
     * executada por esta aplicação.
     * Será retornado "null" caso nenhuma rota tenha sido identificada.
     *
     * @return      ?iRouteConfig
     */
    public function getRouteConfig() : ?iRouteConfig
    {
        return $this->routeConfig;
    }
    /**
     * Define a configuração para esta Aplicação.
     *
     * @param       ?iRouteConfig $routeConfig
     *              Configuração da rota a ser executada.
     * 
     * @return      void
     */
    public function setRouteConfig(?iRouteConfig $routeConfig) : void
    {
        if ($this->routeConfig === null) {
            $this->routeConfig = $routeConfig;
        }
    }






    /**
     * Objeto que representa a configuração bruta da rota alvo.
     *
     * @var         ?array
     */
    protected $rawRouteConfig = null;
    /**
     * Retorna um array associativo que traz as configurações
     * brutas para a rota que deve ser executada pela aplicação.
     *
     * @return      ?array
     */
    public function getRawRouteConfig() : ?array
    {
        return $this->rawRouteConfig;
    }
    /**
     * Define a configuração em estado bruto para a rota como um todo,
     * incluindo todas as opções relativa a seus métodos HTTP aceitos.
     *
     * @param       ?array $rawRouteConfig
     *              Configuração bruta da rota a ser executada.
     * 
     * @return      void
     */
    public function setRawRouteConfig(?array $rawRouteConfig) : void
    {
        $this->rawRouteConfig = $rawRouteConfig;
    }





    /**
     * Permite configurar ou redefinir o objeto de configuração
     * da aplicação na classe concreta da mesma.
     */
    abstract public function configureApplication() : void;





    /**
     * Inicia o processamento da rota dentro da aplicação.
     *
     * @return      void
     */
    public function run() : void
    {
        /*
        $this->initiRouter();
        $this->initiServerRequest();
        $this->initiRouteConfig();

        // Ocultará qualquer saida de dados dos middlewares
        // ou das actions quando estiver em um
        // ambiente de produção
        // OU
        // quando o debug mode estiver ativo
        $hideAllOutputs = ( $this->domainConfig->getEnvironmentType() === "production" ||
                            $this->domainConfig->getIsDebugMode() === false);



        // Não sendo possível encontrar a configuração para a rota
        // dispara o erro encontrado.
        if ($this->routeConfig === null) {
            $requestMethod = $this->serverRequest->getMethod();
            
            switch ($requestMethod) {
                case "OPTIONS":
                    $this->routeConfig  = $this->router->createRouteConfig();
                    $this->response     = $this->serverConfig->getHttpFactory()->createResponse();


                    // Inicia o manipulador responsável por gerar
                    // a view a ser devolvida ao UA.
                    $responseHandler = new ResponseHandler(
                        $this->domainConfig,
                        $this->appConfig,
                        $this->routeConfig,
                        $this->serverRequest, 
                        $this->response
                    );

                    $responseHandler->prepareResponseToOPTIONS($this->rawRouteConfigs);
                    $responseHandler->sendResponse();
                    break;

                default:
                    $err = $this->router->getErrorOnSelectRoute();
                    ErrorListening::throwHTTPError($err["code"], $err["message"]);
                    break;
            }

        } else {
            // Inicia um manipulador principal para os middlewares e 
            // para a rota selecionada.
            $mainHandler = new MainHandler(new RouteHandler($this));


            // Registra os Middlewares a serem executados
            $middlewares = $this->getRouteConfig()->getMiddlewares();
            foreach ($middlewares as $midName) {
                $mainHandler->add(static::{$midName}());
            }


            // Caso necessário, onicia o buffer
            // Com isso, esconderá todas as saídas explicitas originarias
            // dos middlewares e da action.
            if ($hideAllOutputs === true) { ob_start(); }

            // Executa os middlewares e action alvo retornando 
            // um objeto "iResponse" contendo as informações 
            // "viewData" e "routeConfig" devidamente processadas 
            // A partir deste objeto e dos dados retornados a view
            // será produzida e entregue ao UA.
            $this->response = $mainHandler->handle($this->serverRequest);

            // Caso necessário, esvazia o buffer e encerra-o
            if ($hideAllOutputs === true) { ob_end_clean(); }


            // Efetua a atualização das propriedades de "routeConfig" que
            // podem ser redefinidas pela action.
            $this->routeConfig->setValues($this->response->getRouteConfig()->toArray());




            // Inicia o manipulador responsável por gerar
            // a view a ser devolvida ao UA.
            $responseHandler = new ResponseHandler(
                $this->domainConfig,
                $this->appConfig,
                $this->routeConfig,
                $this->serverRequest, 
                $this->response
            );

            // Efetua a negociação do conteúdo.
            $responseHandler->executeContentNegotiation();

            // Envia a resposta para o UA.
            $responseHandler->sendResponse();
        }*/
    }
}
