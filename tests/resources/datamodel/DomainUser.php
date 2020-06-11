<?php return [
    'tableName' => 'DomainUser',
    'alias' => 'secdu',
    'description' => 'Conta de um usuário que pode efetuar login em aplicações do domínio',
    'executeAfterCreateTable' => [
        'INSERT INTO DomainUser (Active, Name, Gender, Login, ShortLogin, Password) VALUES (0, "Anonimo", "-", "anonimo@anonimo", "anonimo", "anonimo");',
        'INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Adriano Santos", "Masculino", "adriano@dna.com.br", "adriano", SHA1("senhateste"));',
        'INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Eliane Somavilla", "Feminino", "eliane@dna.com.br", "eliane", SHA1("senhateste"));',
        'INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Geraldo Bilefete", "Masculino", "geraldo@dna.com.br", "geraldo", SHA1("senhateste"));',
        'INSERT INTO DomainUser (Name, Gender, Login, ShortLogin, Password) VALUES ("Rianna Cantarelli", "Feminino", "rianna@dna.com.br", "rianna", SHA1("senhateste"));',
    ],
    'columns' => [
        [
            'name' => 'Active',
            'description' => 'Indica se a conta do usuário está ativa para o domínio.',
            'type' => 'Bool',
            'default' => true,
            'allowNull' => false,
        ],
        [
            'name' => 'RegisterDate',
            'description' => 'Data e hora da criação deste registro.',
            'type' => 'DateTime',
            'readOnly' => true,
            'default' => 'NOW()',
            'allowNull' => false,
        ],
        [
            'name' => 'Name',
            'description' => 'Nome do usuário.',
            'type' => 'String',
            'length' => 128,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'Gender',
            'description' => 'Gênero do usuário.',
            'type' => 'String',
            'length' => 32,
            'allowNull' => false,
        ],
        [
            'name' => 'Login',
            'description' => 'Login do usuário (email).',
            'type' => 'String',
            'inputFormat' => 'World.Email',
            'length' => 64,
            'readOnly' => true,
            'unique' => true,
            'allowNull' => false,
            'index' => true,
        ],
        [
            'name' => 'ShortLogin',
            'description' => 'Login curto.',
            'type' => 'String',
            'inputFormat' => 'Lower',
            'length' => 32,
            'unique' => true,
            'allowNull' => false,
            'index' => true,
        ],
        [
            'name' => 'Password',
            'description' => 'Senha de acesso.',
            'type' => 'String',
            'inputFormat' => 'World.Password',
            'length' => 255,
            'allowNull' => false,
        ],
        [
            'name' => 'Session',
            'description' => 'Sessão do usuário que está autenticada para o domínio atual.',
            'fkTableName' => 'DomainUserSession[]',
            'fkDescription' => 'Usuário dono desta sessão',
            'fkAllowNull' => false,
            'fkOnDelete' => 'CASCADE'
        ],
        [
            'name' => 'Profiles',
            'description' => 'Coleção de Perfis deste usuário.',
            'fkTableName' => 'DomainUserProfile[]',
            'fkDescription' => 'Usuários em Perfis.',
            'fkLinkTable' => true,
            'fkAllowNull' => false
        ],
        [
            'name' => 'BlockedAccess',
            'description' => 'Coleção de registros de bloqueio para este usuário.',
            'fkTableName' => 'DomainUserBlockedAccess[]',
            'fkDescription' => 'Usuário relacionado com este perfil.',
            'fkAllowNull' => false
        ],
        [
            'name' => 'RequestLog',
            'description' => 'Coleção de logs das requisições deste usuário.',
            'fkTableName' => 'DomainUserRequestLog[]',
            'fkDescription' => 'Usuário deste log.',
            'fkAllowNull' => false
        ],
    ]
];
