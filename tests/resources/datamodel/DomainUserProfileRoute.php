<?php return [
    'tableName' => 'DomainUserProfileRoute',
    'alias' => 'secdupr',
    'description' => 'Configuração de uma rota para um perfil de segurança',
    'executeAfterCreateTable' => [
        'ALTER TABLE DomainUserProfileRoute ADD CONSTRAINT uc_col_MethodHTTP_RawURL_DomainUserProfile_Id UNIQUE (MethodHTTP, RawURL, DomainUserProfile_Id);',
        'INSERT INTO DomainUserProfileRoute (MethodHTTP, RawURL, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "GET", "/site/dashboard", 1, "/site/home", Id FROM DomainUserProfile);',
        'INSERT INTO DomainUserProfileRoute (MethodHTTP, RawURL, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "GET", "/site/forbiden", 1, "/site/home", Id FROM DomainUserProfile WHERE Name="Desenvolvedor");',
        'INSERT INTO DomainUserProfileRoute (MethodHTTP, RawURL, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "GET", "/site/forbiden", 0, "/site/home", Id FROM DomainUserProfile WHERE Name="Administrador");',
    ],
    'columns' => [
        [
            'name' => 'MethodHTTP',
            'description' => 'Método HTTP evocado na execução da requisição.',
            'type' => 'String',
            'length' => 8,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'RawURL',
            'description' => 'URI da rota a qual esta regra corresponde.',
            'type' => 'String',
            'length' => 255,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'Allow',
            'description' => 'Permissão para esta rota.',
            'type' => 'Bool',
            'default' => 0,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'RedirectTo',
            'description' => 'URL para onde o usuário deve ser redirecionado caso não possa visitar esta rota.',
            'type' => 'String',
            'length' => 255,
            'default' => null,
            'allowNull' => true,
            'allowEmpty' => false,
        ],
    ]
];
