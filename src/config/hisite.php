<?php

/*
 * Asset Packagist
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

$common = require __DIR__ . '/common.php';

$config = [
    'id'            => 'asset-packagist',
    'name'          => 'Asset Packagist',
    'basePath'      => dirname(__DIR__),
    'vendorPath'    => '<base-dir>/vendor',
    'runtimePath'   => '<base-dir>/runtime',
    'controllerNamespace' => 'hiqdev\assetpackagist\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'log' => [
            'traceLevel' => 0,
            'targets'    => [
                'default' => [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\\caching\\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
        ],
    ],
];

return yii\helpers\ArrayHelper::merge($common, $config);
