<?php return [
    'tableName' => 'DomainApplication',
    'alias' => 'secapp',
    'description' => 'Aplicação disponível para este domínio',
    'executeAfterCreateTable' => [
        'INSERT INTO DomainApplication (Active, Name) VALUES (1, "Site");'
    ],
    'columns' => [
        [
            'name' => 'Active',
            'description' => 'Indica se a aplicação está ativa.',
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
            'description' => 'Nome da aplicação.',
            'type' => 'String',
            'length' => 32,
            'unique' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'UserProfiles',
            'description' => 'Coleção de perfis de segurança que esta aplicação disponibiliza para seus usuários.',
            'fkTableName' => 'DomainUserProfile[]',
            'fkDescription' => 'Perfil de usuários em aplicações',
            'fkAllowNull' => false,
            'fkOnDelete' => 'CASCADE'
        ],
    ]
];
