<?php return [
    'tableName' => 'DomainUserProfileRoute',
    'alias' => 'secdupr',
    'description' => 'Configuração de uma rota para um perfil de segurança',
    'executeAfterCreateTable' => [
        'ALTER TABLE DomainUserProfileRoute ADD CONSTRAINT uc_col_MethodHttp_RawRoute_DomainUserProfile_Id UNIQUE (MethodHttp, RawRoute, DomainUserProfile_Id);',
        'INSERT INTO DomainUserProfileRoute (ControllerName, ActionName, MethodHttp, RawRoute, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "home", "index", "GET", "/site/levelthree", 0, "/site/home", Id FROM DomainUserProfile WHERE Name="Desenvolvedor");',
        'INSERT INTO DomainUserProfileRoute (ControllerName, ActionName, MethodHttp, RawRoute, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "home", "dashboard", "GET", "/site/dashboard", 1, null, Id FROM DomainUserProfile WHERE Name="Administrador");',
        'INSERT INTO DomainUserProfileRoute (ControllerName, ActionName, MethodHttp, RawRoute, Allow, RedirectTo, DomainUserProfile_Id) (SELECT "home", "levelone", "GET", "/site/levelone", 1, null, Id FROM DomainUserProfile WHERE Name="Administrador");',
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
            'name' => 'ActionName',
            'description' => 'Nome da action que resolve esta rota.',
            'type' => 'String',
            'length' => 128,
            'readOnly' => true,
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
            'description' => 'Versão bruta da rota a qual esta regra corresponde (contendo o nome da aplicação).',
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
            'default' => false,
            'allowNull' => false,
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
        [
            'name' => 'Description',
            'description' => 'Breve descrição da rota.',
            'type' => 'String',
            'length' => 255,
            'default' => null,
            'allowNull' => true,
            'allowEmpty' => false,
        ],
    ]
];
