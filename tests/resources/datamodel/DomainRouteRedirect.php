<?php return [
    'tableName' => 'DomainRouteRedirect',
    'alias' => 'secdrr',
    'description' => 'Configuração de redirecionamentos do domínio',
    'executeAfterCreateTable' => [
        'ALTER TABLE DomainRouteRedirect ADD CONSTRAINT uc_col_OriginURL UNIQUE (OriginURL(255));',
    ],
    'columns' => [
        [
            'name' => 'OriginURL',
            'description' => 'URL que, ao ser evocada redirecionará o UA para outro local.',
            'type' => 'String',
            'length' => 1024,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'DestinyURL',
            'description' => 'URL para onde o UA será redirecionado ou que deverá responder a esta requisição.',
            'type' => 'String',
            'length' => 1024,
            'allowNull' => false,
            'allowEmpty' => false,
        ],
        [
            'name' => 'IsPregReplace',
            'description' => 'Indica quando a URL de Origem deve ser tratada com a função "preg_replace" do PHP. Neste caso a URL de Destino deve ser montada a partir da função "preg_replace(OriginURL, DestinyURL, RequestURL);"',
            'type' => 'Bool',
            'default' => false,
            'allowNull' => false,
        ],
        [
            'name' => 'KeepQuerystrings',
            'description' => 'Indica quando os parametros querystrings existentes na URL da requisição original devem ser mantidos na URL de destino.',
            'type' => 'Bool',
            'default' => false,
            'allowNull' => false,
        ],
        [
            'name' => 'HTTPCode',
            'description' => 'Código HTTP para este redirecionamento.',
            'type' => 'Short',
            'allowNull' => false,
            'default' => 302,
            'min' => 300,
            'max' => 399,
        ],
        [
            'name' => 'HTTPMessage',
            'description' => 'Mensagem HTTP para este redirecionamento.',
            'type' => 'String',
            'length' => 255,
            'allowNull' => false,
            'allowEmpty' => false,
            'default' => 'Found',
        ],
    ]
];
