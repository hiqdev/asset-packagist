<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

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
            'charset' => 'utf8',
        ],
        'mutex' => [
            'class' => \yii\mutex\MysqlMutex::class,
            'db' => 'db',
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'package',
            'mutex' => 'mutex',
            'deleteReleased' => true,
        ],
        'packageStorage' => [
            'class' => \hiqdev\assetpackagist\components\Storage::class,
        ],
        'registryFactory' => [
            'class' => hiqdev\assetpackagist\registry\RegistryFactory::class,
        ],
        'librariesio' => [
            'class' => \hiqdev\assetpackagist\librariesio\LibrariesioRepository::class,
            'apiKey' => $params['librariesio.api_key'],
        ],
    ],
    'container' => [
        'singletons' => [
            'db' => function () {
                return Yii::$app->get('db');
            },
            \hiqdev\assetpackagist\repositories\PackageRepository::class => function ($container) {
                return new \hiqdev\assetpackagist\repositories\PackageRepository($container->get('db'));
            },
            \hiqdev\assetpackagist\components\StorageInterface::class => function () {
                return Yii::$app->get('packageStorage');
            },
            \yii\queue\Queue::class => function () {
                return Yii::$app->get('queue');
            }
        ],
    ],
];
