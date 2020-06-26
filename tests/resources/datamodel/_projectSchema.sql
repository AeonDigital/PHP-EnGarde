/*
 * Main Schema definition
 * Generated in 2020-06-25-23-59-04
*/

/*--INI CREATE TABLE--*/
CREATE TABLE DomainApplication (
    Id BIGINT NOT NULL AUTO_INCREMENT, 
    Active TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Indica se a aplicação está ativa.', 
    RegisterDate DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data e hora da criação deste registro.', 
    CommercialName VARCHAR(32) NOT NULL COMMENT 'Nome comercial da aplicação.', 
    ApplicationName VARCHAR(32) NOT NULL COMMENT 'Nome da aplicação em seu formato "programático".', 
    Description VARCHAR(255) COMMENT 'Breve descrição da aplicação.', 
    PRIMARY KEY (Id)
) COMMENT 'Aplicação disponível para este domínio';
/*--END CREATE TABLE--*/



/*--INI CREATE TABLE--*/
CREATE TABLE DomainUser (
    Id BIGINT NOT NULL AUTO_INCREMENT, 
    Active TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Indica se a conta do usuário está ativa para o domínio.', 
    RegisterDate DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data e hora da criação deste registro.', 
    Name VARCHAR(128) NOT NULL COMMENT 'Nome do usuário.', 
    Gender VARCHAR(32) NOT NULL COMMENT 'Gênero do usuário.', 
    Login VARCHAR(64) NOT NULL COMMENT 'Login do usuário (email).', 
    ShortLogin VARCHAR(32) NOT NULL COMMENT 'Login curto.', 
    Password VARCHAR(40) NOT NULL COMMENT 'Senha de acesso.', 
    PRIMARY KEY (Id)
) COMMENT 'Conta de um usuário que pode efetuar login em aplicações do domínio';
/*--END CREATE TABLE--*/



/*--INI CREATE TABLE--*/
CREATE TABLE DomainUserBlockedAccess (
    Id BIGINT NOT NULL AUTO_INCREMENT, 
    RegisterDate DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data e hora da criação deste registro.', 
    UserAgentIP VARCHAR(64) NOT NULL COMMENT 'Identificação do IP registrado no momento do bloqueio.', 
    BlockTimeOut DATETIME NOT NULL COMMENT 'Data e hora para o fim de validade deste bloqueio.', 
    DomainUser_Id BIGINT NOT NULL COMMENT 'Usuário relacionado com este perfil.', 
    PRIMARY KEY (Id)
) COMMENT 'Registra o bloqueio de um usuário ou endereço IP.';
/*--END CREATE TABLE--*/



/*--INI CREATE TABLE--*/
CREATE TABLE DomainUserProfile (
    Id BIGINT NOT NULL AUTO_INCREMENT, 
    Active TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Indica se este perfil de segurança está ativo ou não.', 
    RegisterDate DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data e hora da criação deste registro.', 
    Name VARCHAR(64) NOT NULL COMMENT 'Nome deste perfil de segurança.', 
    Description VARCHAR(255) NOT NULL COMMENT 'Descrição deste grupo de segurança.', 
    AllowAll TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Indica se a política de acesso para este perfil é permissiva.', 
    HomeURL VARCHAR(255) NOT NULL COMMENT 'Indica a home para onde este perfil deve ser direcionado ao efetuar login.', 
    DomainApplication_Id BIGINT NOT NULL COMMENT 'Perfil de usuários em aplicações', 
    PRIMARY KEY (Id)
) COMMENT 'Define um perfil de segurança para um conjunto de usuários';
/*--END CREATE TABLE--*/



/*--INI CREATE TABLE--*/
CREATE TABLE DomainUserProfileRoute (
    Id BIGINT NOT NULL AUTO_INCREMENT, 
    ControllerName VARCHAR(128) NOT NULL COMMENT 'Nome do controller que resolve esta rota.', 
    ActionName VARCHAR(128) NOT NULL COMMENT 'Nome da action que resolve esta rota.', 
    MethodHttp VARCHAR(8) NOT NULL COMMENT 'Método Http evocado na execução da requisição.', 
    RawRoute VARCHAR(255) NOT NULL COMMENT 'Versão bruta da rota a qual esta regra corresponde (contendo o nome da aplicação).', 
    Allow TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Permissão para esta rota.', 
    RedirectTo VARCHAR(255) COMMENT 'URL para onde o usuário deve ser redirecionado caso não possa visitar esta rota.', 
    Description VARCHAR(255) COMMENT 'Breve descrição da rota.', 
    DomainUserProfile_Id BIGINT NOT NULL COMMENT 'Perfil relacionado a esta rota', 
    PRIMARY KEY (Id)
) COMMENT 'Configuração de uma rota para um perfil de segurança';
/*--END CREATE TABLE--*/



/*--INI CREATE TABLE--*/
CREATE TABLE DomainUserRequestLog (
    Id BIGINT NOT NULL AUTO_INCREMENT, 
    RegisterDate DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data e hora da criação deste registro.', 
    UserAgent VARCHAR(255) NOT NULL COMMENT 'Identificação do UA no momento em que a autenticação foi criada.', 
    UserAgentIP VARCHAR(64) NOT NULL COMMENT 'Identificação do IP do UA no momento em que a autenticação foi criada.', 
    MethodHttp VARCHAR(8) NOT NULL COMMENT 'Método Http evocado na execução da requisição.', 
    FullURL VARCHAR(2048) NOT NULL COMMENT 'Url completa que foi evocada (junto com eventuais parametros querystring).', 
    PostData LONGTEXT NOT NULL COMMENT 'Informação postada em conjunto com a requisição.', 
    ApplicationName VARCHAR(32) NOT NULL COMMENT 'Nome da aplicação que resolveu esta requisição.', 
    ControllerName VARCHAR(128) NOT NULL COMMENT 'Nome do controller que deve/deveria resolver esta requisição.', 
    ActionName VARCHAR(128) NOT NULL COMMENT 'Nome da action que deve/deveria resolver esta requisição.', 
    Activity VARCHAR(32) NOT NULL COMMENT 'Descrição breve da ação que está sendo registrada.', 
    Note VARCHAR(255) COMMENT 'Descrição mais completa da ação registrada.', 
    DomainUser_Id BIGINT NOT NULL COMMENT 'Usuário deste log.', 
    PRIMARY KEY (Id)
) COMMENT 'Log de requisições realizadas pelos usuários de domínio';
/*--END CREATE TABLE--*/



/*--INI CREATE TABLE--*/
CREATE TABLE DomainUserSession (
    Id BIGINT NOT NULL AUTO_INCREMENT, 
    RegisterDate DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data e hora da criação deste registro.', 
    SessionHash VARCHAR(40) NOT NULL COMMENT 'Hash de segurança.', 
    SessionTimeOut DATETIME NOT NULL COMMENT 'Data e hora para o fim desta sessão caso não seja renovada antes.', 
    UserAgent VARCHAR(255) NOT NULL COMMENT 'Identificação do UA no momento em que a autenticação foi criada.', 
    UserAgentIP VARCHAR(64) NOT NULL COMMENT 'Identificação do IP do UA no momento em que a autenticação foi criada.', 
    GrantPermission VARCHAR(255) COMMENT 'Permissão especial concedida por um outro usuário.', 
    DomainUser_Id BIGINT NOT NULL COMMENT 'Usuário dono desta sessão', 
    PRIMARY KEY (Id)
) COMMENT 'Define uma sessão de acesso para um usuário que efetuou login';
/*--END CREATE TABLE--*/



/*--INI CREATE TABLE--*/
CREATE TABLE secdup_to_secdu (
    DomainUser_Id BIGINT NOT NULL COMMENT 'Usuários em Perfis.', 
    DomainUserProfile_Id BIGINT NOT NULL COMMENT 'Perfil em Usuários'
) COMMENT 'LinkTable : DomainUser <-> DomainUserProfile';
/*--END CREATE TABLE--*/






/*
 * Constraints definition
*/

/*--INI CONSTRAINT INSTRUCTIONS--*/
ALTER TABLE DomainApplication ADD CONSTRAINT uc_secdapp_CommercialName UNIQUE (CommercialName);
ALTER TABLE DomainApplication ADD CONSTRAINT uc_secdapp_ApplicationName UNIQUE (ApplicationName);
INSERT INTO DomainApplication (Active, CommercialName, ApplicationName, Description) VALUES (1, "Site", "site", "Website");
ALTER TABLE DomainUser ADD CONSTRAINT uc_secdu_Login UNIQUE (Login);
CREATE INDEX idx_secdu_Login ON DomainUser (Login);
ALTER TABLE DomainUser ADD CONSTRAINT uc_secdu_ShortLogin UNIQUE (ShortLogin);
CREATE INDEX idx_secdu_ShortLogin ON DomainUser (ShortLogin);
INSERT INTO DomainUser (Active, Name, Gender, Login, ShortLogin, Password) VALUES (0, "Anonimo", "-", "anonimo@anonimo", "anonimo", "anonimo");
INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Adriano Santos", "Masculino", "adriano@dna.com.br", "adriano", SHA1("senhateste"));
INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Eliane Somavilla", "Feminino", "eliane@dna.com.br", "eliane", SHA1("senhateste"));
INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Geraldo Bilefete", "Masculino", "geraldo@dna.com.br", "geraldo", SHA1("senhateste"));
INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Rianna Cantarelli", "Feminino", "rianna@dna.com.br", "rianna", SHA1("senhateste"));
CREATE INDEX idx_secduba_UserAgentIP ON DomainUserBlockedAccess (UserAgentIP);
ALTER TABLE DomainUserBlockedAccess ADD CONSTRAINT fk_secduba_to_secdu_DomainUser_Id FOREIGN KEY (DomainUser_Id) REFERENCES DomainUser(Id) ON DELETE CASCADE;
ALTER TABLE DomainUserProfile ADD CONSTRAINT fk_secdup_to_secdapp_DomainApplication_Id FOREIGN KEY (DomainApplication_Id) REFERENCES DomainApplication(Id) ON DELETE CASCADE;
ALTER TABLE DomainUserProfile ADD CONSTRAINT uc_col_Name_DomainApplication_Id UNIQUE (Name, DomainApplication_Id);
INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Desenvolvedor", "Usuários desenvolvedores do sistema.", 1, "/site", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));
INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Administrador", "Usuários administradores do sistema.", 0, "/site", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));
INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Publicador", "Usuários publicadores de conteúdo.", 0, "/site", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));
ALTER TABLE secdup_to_secdu ADD COLUMN ProfileDefault INT(1) DEFAULT 0 NOT NULL;
ALTER TABLE secdup_to_secdu ADD COLUMN ProfileSelected INT(1) DEFAULT 0 NOT NULL;
INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Desenvolvedor") FROM DomainUser;
INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Administrador") FROM DomainUser;
INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Publicador") FROM DomainUser;
UPDATE secdup_to_secdu SET ProfileDefault=1 WHERE DomainUserProfile_Id=1;
UPDATE secdup_to_secdu SET ProfileSelected=1 WHERE DomainUserProfile_Id=1 AND DomainUser_Id=5;
ALTER TABLE DomainUserProfileRoute ADD CONSTRAINT fk_secdupr_to_secdup_DomainUserProfile_Id FOREIGN KEY (DomainUserProfile_Id) REFERENCES DomainUserProfile(Id) ON DELETE CASCADE;
ALTER TABLE DomainUserProfileRoute ADD CONSTRAINT uc_col_MethodHttp_RawRoute_DomainUserProfile_Id UNIQUE (MethodHttp, RawRoute, DomainUserProfile_Id);
INSERT INTO DomainUserProfileRoute (ControllerName, ActionName, MethodHttp, RawRoute, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "home", "index", "GET", "/site/levelthree", 0, "/site/home", Id FROM DomainUserProfile WHERE Name="Desenvolvedor");
INSERT INTO DomainUserProfileRoute (ControllerName, ActionName, MethodHttp, RawRoute, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "home", "dashboard", "GET", "/site/dashboard", 1, null, Id FROM DomainUserProfile WHERE Name="Administrador");
INSERT INTO DomainUserProfileRoute (ControllerName, ActionName, MethodHttp, RawRoute, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "home", "levelone", "GET", "/site/levelone", 1, null, Id FROM DomainUserProfile WHERE Name="Administrador");
ALTER TABLE DomainUserRequestLog ADD CONSTRAINT fk_secdurl_to_secdu_DomainUser_Id FOREIGN KEY (DomainUser_Id) REFERENCES DomainUser(Id) ON DELETE CASCADE;
ALTER TABLE DomainUserSession ADD CONSTRAINT uc_secdus_SessionHash UNIQUE (SessionHash);
CREATE INDEX idx_secdus_SessionHash ON DomainUserSession (SessionHash);
ALTER TABLE DomainUserSession ADD CONSTRAINT fk_secdus_to_secdu_DomainUser_Id FOREIGN KEY (DomainUser_Id) REFERENCES DomainUser(Id) ON DELETE CASCADE;
ALTER TABLE DomainUserSession ADD CONSTRAINT uc_col_DomainUser_Id UNIQUE (DomainUser_Id);
ALTER TABLE secdup_to_secdu ADD CONSTRAINT fk_secdup_secdu_to_secdu_DomainUser_Id FOREIGN KEY (DomainUser_Id) REFERENCES DomainUser(Id) ON DELETE CASCADE;
ALTER TABLE secdup_to_secdu ADD CONSTRAINT fk_secdup_secdu_to_secdup_DomainUserProfile_Id FOREIGN KEY (DomainUserProfile_Id) REFERENCES DomainUserProfile(Id) ON DELETE CASCADE;
/*--END CONSTRAINT INSTRUCTIONS--*/




/*
 * End of Main Schema definition
 * Generated in 2020-06-25-23-59-04
*/
