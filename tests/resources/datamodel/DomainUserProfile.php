<?php return [
    'tableName' => 'DomainUserProfile',
    'alias' => 'secdup',
    'description' => 'Define um perfil de segurança para um conjunto de usuários',
    'executeAfterCreateTable' => [
        'ALTER TABLE DomainUserProfile ADD CONSTRAINT uc_col_ApplicationName_Name UNIQUE (ApplicationName, Name);',
        'INSERT INTO DomainUserProfile (ApplicationName, Name, Description) VALUES ("site", "Desenvolvedor", "Usuários desenvolvedores do sistema.");',
        'INSERT INTO DomainUserProfile (ApplicationName, Name, Description) VALUES ("site", "Administrador", "Usuários administradores do sistema.");',
        'ALTER TABLE secdup_to_secdu ADD COLUMN ProfileDefault INT(1) DEFAULT 0 NOT NULL;',
        'ALTER TABLE secdup_to_secdu ADD COLUMN ProfileSelected INT(1) DEFAULT 0 NOT NULL;',
        'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Desenvolvedor") FROM DomainUser;',
        'INSERT INTO secdup_to_secdu (DomainUser_Id, DomainUserProfile_Id) SELECT Id, (SELECT Id FROM DomainUserProfile WHERE Name="Administrador") FROM DomainUser;',
        'UPDATE secdup_to_secdu SET ProfileDefault=1 WHERE DomainUserProfile_Id=2;',
        'UPDATE secdup_to_secdu SET ProfileSelected=1 WHERE DomainUserProfile_Id=2 AND DomainUser_Id=5;'
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
            'name' => 'ApplicationName',
            'description' => 'Nome da aplicação para qual este perfil de segurança é utilizado.',
            'type' => 'String',
            'length' => 32,
            'allowNull' => false,
            'allowEmpty' => false,
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
            'name' => 'DomainUsers',
            'description' => 'Coleção de usuários para este perfil.',
            'fkTableName' => 'DomainUser[]',
            'fkDescription' => 'Perfil em Usuários',
            'fkLinkTable' => true,
            'fkAllowNull' => false,
        ]
    ]
];
