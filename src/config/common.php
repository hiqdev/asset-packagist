<?php

/*
 * Asset Packagist
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

$params = require __DIR__ . '/params.php';

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
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
    ],
    'modules' => [
    ],

    'params' => $params,
];
