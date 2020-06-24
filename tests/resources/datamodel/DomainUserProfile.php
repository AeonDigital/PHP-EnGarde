<?php return [
    'tableName' => 'DomainUserProfile',
    'alias' => 'secdup',
    'description' => 'Define um perfil de segurança para um conjunto de usuários',
    'executeAfterCreateTable' => [
        'ALTER TABLE DomainUserProfile ADD CONSTRAINT uc_col_Name_DomainApplication_Id UNIQUE (Name, DomainApplication_Id);',
        'INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Desenvolvedor", "Usuários desenvolvedores do sistema.", 1, "/", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));',
        'INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Administrador", "Usuários administradores do sistema.", 0, "/", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));',
        'INSERT INTO DomainUserProfile (Name, Description, AllowAll, HomeURL, DomainApplication_Id) VALUES ("Publicador", "Usuários publicadores de conteúdo.", 0, "/", (SELECT Id FROM DomainApplication WHERE ApplicationName="site"));',
        'ALTER TABLE secdup_to_secdu ADD COLUMN ProfileDefault INT(1) DEFAULT 0 NOT NULL;',
        'ALTER TABLE secdup_to_secdu ADD COLUMN ProfileSelected INT(1) DEFAULT 0 NOT NULL;',
        'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Desenvolvedor") FROM DomainUser;',
        'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Administrador") FROM DomainUser;',
        'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Publicador") FROM DomainUser;',
        'UPDATE secdup_to_secdu SET ProfileDefault=1 WHERE DomainUserProfile_Id=1;',
        'UPDATE secdup_to_secdu SET ProfileSelected=1 WHERE DomainUserProfile_Id=1 AND DomainUser_Id=5;'
    ],
    'columns' => [
        [
            'name' => 'Active',
            'description' => 'Indica se este perfil de segurança está ativo ou não.',
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
            'description' => 'Nome deste perfil de segurança.',
            'type' => 'String',
            'length' => 64,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'Description',
            'description' => 'Descrição deste grupo de segurança.',
            'type' => 'String',
            'length' => 255,
            'allowNull' => false,
        ],
        [
            'name' => 'AllowAll',
            'description' => 'Indica se a política de acesso para este perfil é permissiva.',
            'type' => 'Bool',
            'default' => false,
            'allowNull' => false,
        ],
        [
            'name' => 'HomeURL',
            'description' => 'Indica a home para onde este perfil deve ser direcionado ao efetuar login.',
            'type' => 'String',
            'length' => 255,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'DomainUsers',
            'description' => 'Coleção de usuários para este perfil.',
            'fkTableName' => 'DomainUser[]',
            'fkDescription' => 'Perfil em Usuários',
            'fkLinkTable' => true,
            'fkAllowNull' => false,
        ],
        [
            'name' => 'RoutesPermissions',
            'description' => 'Coleção de configurações para as rotas relacionadas a este perfil.',
            'fkTableName' => 'DomainUserProfileRoute[]',
            'fkDescription' => 'Perfil relacionado a esta rota',
            'fkAllowNull' => false,
            'fkOnDelete' => 'CASCADE'
        ]
    ]
];
