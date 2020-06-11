<?php return [
    'tableName' => 'DomainUserSession',
    'alias' => 'secdus',
    'description' => 'Define uma sessão de acesso para um usuário que efetuou login',
    'executeAfterCreateTable' => [
        'ALTER TABLE DomainUserSession ADD CONSTRAINT uc_col_DomainUser_Id UNIQUE (DomainUser_Id);',
    ],
    'columns' => [
        [
            'name' => 'RegisterDate',
            'description' => 'Data e hora da criação deste registro.',
            'type' => 'DateTime',
            'readOnly' => true,
            'default' => 'NOW()',
            'allowNull' => false,
        ],
        [
            'name' => 'SessionHash',
            'description' => 'Hash de segurança.',
            'type' => 'String',
            'length' => 40,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
            'index' => true,
            'unique' => true,
        ],
        [
            'name' => 'SessionTimeOut',
            'description' => 'Data e hora para o fim desta sessão caso não seja renovada antes.',
            'type' => 'DateTime',
            'readOnly' => true,
            'allowNull' => false,
        ],
        [
            'name' => 'UserAgent',
            'description' => 'Identificação do UA no momento em que a autenticação foi criada.',
            'type' => 'String',
            'length' => 255,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'UserAgentIP',
            'description' => 'Identificação do IP do UA no momento em que a autenticação foi criada.',
            'type' => 'String',
            'length' => 64,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'GrantPermission',
            'description' => 'Permissão especial concedida por um outro usuário.',
            'type' => 'String',
            'length' => 255,
            'default' => null,
            'allowNull' => true,
            'allowEmpty' => false
        ]
    ]
];
