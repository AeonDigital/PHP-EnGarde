<?php return [
    'tableName' => 'DomainUserRequestLog',
    'alias' => 'secdurl',
    'description' => 'Log de requisições realizadas pelos usuários de domínio',
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
            'name' => 'MethodHttp',
            'description' => 'Método Http evocado na execução da requisição.',
            'type' => 'String',
            'length' => 8,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'FullURL',
            'description' => 'Url completa que foi evocada (junto com eventuais parametros querystring).',
            'type' => 'String',
            'length' => 2048,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'PostData',
            'description' => 'Informação postada em conjunto com a requisição.',
            'type' => 'String',
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'ApplicationName',
            'description' => 'Nome da aplicação que resolveu esta requisição.',
            'type' => 'String',
            'length' => 32,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'ControllerName',
            'description' => 'Nome do controller que deve/deveria resolver esta requisição.',
            'type' => 'String',
            'length' => 128,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'ActionName',
            'description' => 'Nome da action que deve/deveria resolver esta requisição.',
            'type' => 'String',
            'length' => 128,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'Activity',
            'description' => 'Descrição breve da ação que está sendo registrada.',
            'type' => 'String',
            'length' => 32,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'Note',
            'description' => 'Descrição mais completa da ação registrada.',
            'type' => 'String',
            'length' => 255,
            'readOnly' => true,
            'allowNull' => true,
            'allowEmpty' => false,
        ],
    ]
];
