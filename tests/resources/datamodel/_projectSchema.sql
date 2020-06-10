/*
 * Main Schema definition
 * Generated in 2020-06-10-16-05-29
*/

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
CREATE TABLE DomainUserProfile (
    Id BIGINT NOT NULL AUTO_INCREMENT, 
    Active TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Indica se este perfil de segurança está ativo ou não.', 
    RegisterDate DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data e hora da criação deste registro.', 
    ApplicationName VARCHAR(32) NOT NULL COMMENT 'Nome da aplicação para qual este perfil de segurança é utilizado.', 
    Name VARCHAR(32) NOT NULL COMMENT 'Nome deste perfil de segurança.', 
    Description VARCHAR(255) NOT NULL COMMENT 'Descrição deste grupo de segurança.', 
    PRIMARY KEY (Id)
) COMMENT 'Define um perfil de segurança para um conjunto de usuários';
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
ALTER TABLE DomainUser ADD CONSTRAINT uc_secdu_Login UNIQUE (Login);
CREATE INDEX idx_secdu_Login ON DomainUser (Login);
ALTER TABLE DomainUser ADD CONSTRAINT uc_secdu_ShortLogin UNIQUE (ShortLogin);
CREATE INDEX idx_secdu_ShortLogin ON DomainUser (ShortLogin);
INSERT INTO DomainUser (Active, Name, Gender, Login, ShortLogin, Password) VALUES (0, "Anonimo", "-", "anonimo@anonimo", "anonimo", "anonimo");
INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Adriano Santos", "Masculino", "adriano@dna.com.br", "adriano", SHA1("senhateste"));
INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Eliane Somavilla", "Feminino", "eliane@dna.com.br", "eliane", SHA1("senhateste"));
INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Geraldo Bilefete", "Masculino", "geraldo@dna.com.br", "geraldo", SHA1("senhateste"));
INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Rianna Cantarelli", "Feminino", "rianna@dna.com.br", "rianna", SHA1("senhateste"));
ALTER TABLE DomainUserProfile ADD CONSTRAINT uc_col_ApplicationName_Name UNIQUE (ApplicationName, Name);
INSERT INTO DomainUserProfile (ApplicationName, Name, Description) VALUES ("site", "Desenvolvedor", "Usuários desenvolvedores do sistema.");
INSERT INTO DomainUserProfile (ApplicationName, Name, Description) VALUES ("site", "Administrador", "Usuários administradores do sistema.");
INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Desenvolvedor") FROM DomainUser;
INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Administrador") FROM DomainUser;
ALTER TABLE secdup_to_secdu ADD CONSTRAINT fk_secdup_secdu_to_secdu_DomainUser_Id FOREIGN KEY (DomainUser_Id) REFERENCES DomainUser(Id) ON DELETE CASCADE;
ALTER TABLE secdup_to_secdu ADD CONSTRAINT fk_secdup_secdu_to_secdup_DomainUserProfile_Id FOREIGN KEY (DomainUserProfile_Id) REFERENCES DomainUserProfile(Id) ON DELETE CASCADE;
/*--END CONSTRAINT INSTRUCTIONS--*/




/*
 * End of Main Schema definition
 * Generated in 2020-06-10-16-05-29
*/
