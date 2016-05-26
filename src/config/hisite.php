<?php

/*
 * Asset Packagist
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

return [
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
        'request' => [
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@hiqdev/assetpackagist/views' => '@hisite/views',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
        ],
        'packageStorage' => [
            'class' => \hiqdev\assetpackagist\components\Storage::class
        ]
    ],
    'modules' => [],
];
