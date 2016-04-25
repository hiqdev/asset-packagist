<?php

/*
 * asset-packagist.hiqdev.com
 *
 * @link      http://asset-packagist.hiqdev.com/
 * @package   asset-packagist.hiqdev.com
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

return [
    'id' => 'asset-packagist',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'controllerNamespace' => 'hiqdev\assetpackagist\controllers',
    'bootstrap' => ['log'],
    'aliases' => [
        'storage'   => dirname(dirname(__DIR__)) . '/web',
        'npm'       => '@vendor/npm-asset',
        'bower'     => '@vendor/bower-asset',
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                'default' => [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => '345sdfsadf',
        ],
    ],
    'modules' => [
    ],

    'params' => require(__DIR__ . '/params.php'),
];
