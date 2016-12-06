<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=asset_packagist',
            'username' => 'asset-packagist',
            'password' => $params['db.password'],
            'charset' => 'utf8'
        ],
        'queue' => [
            'class' => \zhuravljov\yii\queue\Queue::class,
            'driver' => [
                'class' => \zhuravljov\yii\queue\db\Driver::class,
                'db' => 'db',
                'tableName' => '{{%queue}}',
                'channel' => 'package',
                'mutex' => \yii\mutex\MysqlMutex::class,
            ],
        ],
    ]
];
