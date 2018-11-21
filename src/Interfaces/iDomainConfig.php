<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\Interfaces;










/**
 * Nesta interface estão as configurações básicas para o funcionamento
 * de um Domínio.
 * 
 * Todas as propriedades aqui descritas não devem poder ser alteradas
 * após serem definidas.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
interface iDomainConfig
{





    /**
     * Resgata a data e hora do momento em que a requisição 
     * chegou ao domínio.
     *
     * @return      \DateTime
     */
    function getNow() : \DateTime;



    /**
     * Resgata a versão atual do framework.
     *
     * @return      string
     */
    function getVersion() : string;
    /**
     * Define a versão atual do framework.
     * 
     * @param       string $version
     *              Indique a versão do framework.
     * 
     * @return      void
     */
    function setVersion(string $version) : void;



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
    function getEnvironmentType() : string;
    /**
     * Define o tipo de ambiente que o domínio está rodando no momento
     * 
     * @param       string $environmentType
     *              Tipo de ambiente.
     * 
     * @return      void
     */
    function setEnvironmentType(string $environmentType) : void;
  
  
  
    /**
     * Retorna "true" se o domínio está em modo de debug.
     *
     * @return      bool
     */
    function getIsDebugMode() : bool;
    /**
     * Define configuração para o modo de debug.
     * 
     * @param       bool $isDebugMode
     *              Indique "true" se o domínio estiver
     *              em modo de debug.
     * 
     * @return      void
     */
    function setIsDebugMode(bool $isDebugMode) : void;



    /**
     * Retorna "true" se for para a aplicação alvo atualizar suas
     * respectivas rotas.
     *
     * @return      bool
     */
    function getIsUpdateRoutes() : bool;
    /**
     * Define configuração que indica para a aplicação algo que ela
     * deve atualizar suas respectivas rotas.
     * 
     * @param       bool $isUpdateRoutes
     *              Indique "true" se for para a aplicação
     *              alvo atualizar suas rotas.
     * 
     * @return      void
     */
    function setIsUpdateRoutes(bool $isUpdateRoutes) : void;



    /**
     * Retorna o caminho completo até o diretório raiz do domínio.
     *
     * @return      string
     */
    function getRootPath() : string;
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
    function setRootPath(string $rootPath) : void;



    /**
     * Retorna a coleção de nomes de aplicações instaladas no domínio
     *
     * @return      array
     */
    function getHostedApps() : array;
    /**
     * Define a coleção de nomes das aplicações instaladas no domínio.
     * 
     * @param       array $hostedApps
     *              Array contendo o nome de cada uma das aplicações
     *              do domínio. Cada uma delas precisa necessariamente
     *              corresponder ao nome de um diretório que fique
     *              na raiz do domínio.
     * 
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function setHostedApps(array $hostedApps) : void;



    /**
     * Retorna o nome da aplicação padrão do domínio.
     *
     * @return      string
     */
    function getDefaultApp() : string;
    /**
     * Define a aplicação padrão para o domínio.
     * A aplicação apontada precisa estar definida em "hostedApps".
     * 
     * @param       ?string $defaultApp
     *              Nome da aplicação que será a padrão.
     *              Caso "null" ou "" será definida a primeira
     *              aplicação definida em "hostedApps".
     * 
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    function setDefaultApp(?string $defaultApp = null) : void;



    /**
     * Retorna o timezone do domínio.
     *
     * @return      string
     */
    function getDateTimeLocal() : string;
    /**
     * Define o timezone do domínio.
     * 
     * @param       string $dateTimeLocal
     *              Timezone que será definido.
     * 
     * @return      void
     */
    function setDateTimeLocal(string $dateTimeLocal) : void;



    /**
     * Retorna o tempo máximo (em segundos) para a execução das requisições.
     *
     * @return      int
     */
    function getTimeOut() : int;
    /**
     * Define o tempo máximo (em segundos) para a execução das requisições.
     *
     * @param       int $timeOut
     *              Timeout que será definido.
     * 
     * @return      void
     */
    function setTimeOut(int $timeOut) : void;



    /**
     * Valor máximo (em Mb) para o upload de um arquivo.
     *
     * @return      int
     */
    function getMaxFileSize() : int;
    /**
     * Define o valor máximo (em Mb) para o upload de um arquivo.
     *
     * @param       int $maxFileSize
     *              Tamanho máximo (em Mb).
     * 
     * @return      void
     */
    function setMaxFileSize(int $maxFileSize) : void;



    /**
     * Valor máximo (em Mb) para a postagem de dados.
     *
     * @return      int
     */
    function getMaxPostSize() : int;
    /**
     * Define o valor máximo (em Mb) para a postagem de dados.
     *
     * @param       int $maxPostSize
     *              Tamanho máximo (em Mb).
     * 
     * @return      void
     */
    function setMaxPostSize(int $maxPostSize) : void;



    /**
     * Resgata o caminho relativo até a view que deve ser enviada ao 
     * UA em caso de erros no domínio.
     *
     * @return      ?string
     */
    function getPathToErrorView() : ?string;
    /**
     * Resgata o caminho completo até a view que deve ser enviada ao 
     * UA em caso de erros no domínio.
     *
     * @return      ?string
     */
    function getFullPathToErrorView() : ?string;
    /**
     * Define o caminho relativo até a view que deve ser enviada ao 
     * UA em caso de erros no domínio.
     * 
     * O caminho deve ser definido a partir do diretório raiz do domínio.
     *
     * @param       ?string $pathToErrorView
     *              Caminho até a view de erro padrão.
     * 
     * @return      void
     */
    function setPathToErrorView(?string $pathToErrorView) : void;





    /**
     * Resgata o nome da classe responsável por iniciar a aplicação.
     *
     * @return      string
     */
    function getApplicationClassName() : string;
    /**
     * Define o nome da classe responsável por iniciar a aplicação.
     *
     * @param       string $applicationClassName
     *              Nome da classe.
     * 
     * @return      void
     */
    function setApplicationClassName(string $applicationClassName) : void;





    /**
     * A partir da URL que está sendo executada infere
     * qual das aplicações registradas para o domínio deve ser executada.
     * 
     * Infere também se o nome da aplicação foi omitido na URI.
     *
     * @param       string $uriRelativePath
     *              Parte relativa da URI que está sendo executada.
     * 
     * @return      void
     */
    function defineTargetApplication(string $uriRelativePath) : void;
    /**
     * A partir da URL que está sendo executada infere
     * qual das aplicações registradas para o domínio deve ser executada.
     * 
     * Infere também se o nome da aplicação foi omitido na URI.
     * 
     * Retorna o nome da aplicação que deve responder a requisição HTTP atual.
     *
     * @return      string
     */
    function getApplicationName() : string;
    /**
     * Indica quando na URI atual o nome da aplicação a ser executada
     * está omitida. Nestes casos a aplicação padrão deve ser executada.
     *
     * @return      bool
     */
    function isApplicationNameOmitted() : bool;
    /**
     * Retorna o nome completo da classe da aplicação que deve ser
     * instanciada para responder a requisição atual.
     *
     * @return      ?string
     */
    function retrieveApplicationNS() : ?string;



    /**
     * Pode retornar uma string para onde o UA deve ser redirecionado
     * caso alguma das configurações ou processamento dos presentes dados
     * indique que tal redirecionamento seja necessário.
     * 
     * Retorna "null" caso nenhum redirecionamento seja necessário.
     *
     * @return      ?string
     */
    function getNewLocationPath() : ?string;



    /**
     * Efetua configurações para o PHP conforme as 
     * propriedades definidas para esta classe.
     * 
     * Esta ação só tem efeito na primeira vez que é executada.
     * 
     * @throws      \RunTimeException
     *              Caso alguma propriedade obrigatória não 
     *              tenha sido definida ou seja um valor inválido.
     */
    function setPHPDomainConfiguration() : void;
}
