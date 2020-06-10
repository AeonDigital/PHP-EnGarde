<?php return [
    'tableName' => 'DomainUserBlockedAccess',
    'alias' => 'secduba',
    'description' => 'Registra o bloqueio de um usuário ou endereço IP.',
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
            'name' => 'UserAgentIP',
            'description' => 'Identificação do IP registrado no momento do bloqueio.',
            'type' => 'String',
            'length' => 64,
            'readOnly' => true,
            'allowNull' => false,
            'allowEmpty' => false,
            'index' => true,
        ],
        [
            'name' => 'BlockTimeOut',
            'description' => 'Data e hora para o fim de validade deste bloqueio.',
            'type' => 'DateTime',
            'readOnly' => true,
            'allowNull' => false,
        ],
    ]
];
