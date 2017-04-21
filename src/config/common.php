<?php

return [
    'id'    => 'asset-packagist',
    'name'  => 'Asset Packagist',
    'aliases' => [
        '@storage'  => '<<<base-dir>>>/web',
        '@runtime'  => '<<<base-dir>>>/runtime',
        '@composer' => '<<<base-dir>>>',
    ],
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=' . $params['db.name'],
            'username' => $params['db.username'],
            'password' => $params['db.password'],
            'charset' => 'utf8'
        ],
        'queue' => [
            'class' => \zhuravljov\yii\queue\db\Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'package',
            'mutex' => \yii\mutex\MysqlMutex::class,
            'deleteReleased' => true,
        ],
        'packageStorage' => [
            'class' => \hiqdev\assetpackagist\components\Storage::class,
        ],
    ],
    'container' => [
        'singletons' => [
            'db' => function () {
                return Yii::$app->get('db');
            },
            \hiqdev\assetpackagist\repositories\PackageRepository::class => function ($container) {
                return (new \hiqdev\assetpackagist\repositories\PackageRepository($container->get('db')));
            },
            \hiqdev\assetpackagist\components\StorageInterface::class => function () {
                return Yii::$app->get('packageStorage');
            },
        ],
    ],
];
