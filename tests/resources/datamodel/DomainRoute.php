<?php return [
    'tableName' => 'DomainRoute',
    'alias' => 'secdr',
    'description' => 'Registro das rotas existentes no domínio.',
    'executeAfterCreateTable' => [
        'ALTER TABLE DomainRoute ADD CONSTRAINT uc_col_MethodHttp_RawRoute UNIQUE (MethodHttp, RawRoute);',
        'ALTER TABLE secdup_to_secdr ADD CONSTRAINT uc_DomainRoute_Id_DomainUserProfile_Id UNIQUE (DomainRoute_Id, DomainUserProfile_Id);',
        'ALTER TABLE secdup_to_secdr ADD COLUMN Allow INT(1) DEFAULT 0 NOT NULL;',
    ],
    'columns' => [
        [
            'name' => 'ControllerName',
            'description' => 'Nome do controller que resolve esta rota.',
            'type' => 'String',
            'length' => 128,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'ResourceId',
            'description' => 'Id do recurso que a rota representa.',
            'type' => 'String',
            'length' => 128,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'ActionName',
            'description' => 'Nome da action que resolve esta rota.',
            'type' => 'String',
            'length' => 128,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'MethodHttp',
            'description' => 'Método Http evocado na execução da requisição.',
            'type' => 'String',
            'length' => 8,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'RawRoute',
            'description' => 'Versão bruta da rota a qual esta regra corresponde (contendo o nome da aplicação e sem querystrings).',
            'type' => 'String',
            'length' => 255,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'Description',
            'description' => 'Breve descrição da rota.',
            'type' => 'String',
            'length' => 255,
            'default' => null,
            'allowNull' => true,
            'allowEmpty' => false,
        ],
        [
            'name' => 'Profiles',
            'description' => 'Coleção de perfis correlacionado a esta rota.',
            'fkTableName' => 'DomainUserProfile[]',
            'fkDescription' => 'DomainRoute em DomainUserProfile',
            'fkLinkTable' => true,
            'fkAllowNull' => false,
            'fkOnDelete' => 'CASCADE'
        ]
    ]
];
