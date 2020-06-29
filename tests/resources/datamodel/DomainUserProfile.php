<?php return [
    'tableName' => 'DomainUserProfile',
    'alias' => 'secdup',
    'description' => 'Define um perfil de segurança para um conjunto de usuários',
    'executeAfterCreateTable' => [
        'ALTER TABLE DomainUserProfile ADD CONSTRAINT uc_col_Name_DomainApplication_Id UNIQUE (Name, DomainApplication_Id);',
        'ALTER TABLE secdup_to_secdu ADD CONSTRAINT uc_DomainUser_Id_DomainUserProfile_Id UNIQUE (DomainUser_Id, DomainUserProfile_Id);',
        'ALTER TABLE secdup_to_secdu ADD COLUMN ProfileDefault INT(1) DEFAULT 0 NOT NULL;',
        'ALTER TABLE secdup_to_secdu ADD COLUMN ProfileSelected INT(1) DEFAULT 0 NOT NULL;',
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
            'fkDescription' => 'DomainUserProfile em DomainUser',
            'fkLinkTable' => true,
            'fkAllowNull' => false,
        ],
        [
            'name' => 'RoutesPermissions',
            'description' => 'Coleção de rotas relacionadas a este perfil.',
            'fkTableName' => 'DomainRoute[]',
            'fkDescription' => 'DomainUserProfile em DomainRoute',
            'fkLinkTable' => true,
            'fkAllowNull' => false,
            'fkOnDelete' => 'CASCADE'
        ]
    ]
];
