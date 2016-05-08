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
    'id'            => 'asset-packagist',
    'name'          => 'Asset Packagist',
    'basePath'      => __DIR__,
    'vendorPath'    => '<base-dir>/vendor',
    'runtimePath'   => '<base-dir>/runtime',
    'controllerNamespace' => 'hiqdev\assetpackagist\controllers',
    'bootstrap' => ['log'],
    'aliases' => [
        '@storage' => '<base-dir>/web',
        '@npm'     => '@vendor/npm-asset',
        '@bower'   => '@vendor/bower-asset',
    ],
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
    ],
    'modules' => [],
];
