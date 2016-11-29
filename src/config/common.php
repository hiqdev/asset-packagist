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
                'class' => \zhuravljov\yii\queue\sync\Driver::class,
                'db' => 'db', // ID подключения
                'tableName' => '{{%queue}}', // таблица
                'mutex' => \yii\mutex\MysqlMutex::class, // мьютекс для синхронизации запросов
            ],
        ],
    ]
];
