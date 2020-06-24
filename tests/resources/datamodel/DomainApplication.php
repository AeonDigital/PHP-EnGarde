<?php return [
    'tableName' => 'DomainApplication',
    'alias' => 'secdapp',
    'description' => 'Aplicação disponível para este domínio',
    'executeAfterCreateTable' => [
        'INSERT INTO DomainApplication (Active, CommercialName, ApplicationName, Description) VALUES (1, "Site", "site", "Website");'
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
            'name' => 'CommercialName',
            'description' => 'Nome comercial da aplicação.',
            'type' => 'String',
            'length' => 32,
            'unique' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'ApplicationName',
            'description' => 'Nome da aplicação em seu formato "programático".',
            'type' => 'String',
            'length' => 32,
            'unique' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'Description',
            'description' => 'Breve descrição da aplicação.',
            'type' => 'String',
            'length' => 255,
            'default' => null,
            'allowNull' => true,
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
