<?php

$config = [
    'id' => 'asset-packagist',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime',
    'controllerNamespace' => 'hiqdev\assetpackagist\controllers',
    'bootstrap' => ['log'],
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                'packages.json' => 'packages/packages',
                'p/provider-latest.json' => 'packages/provider',
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


if (YII_DEBUG) {
    $config['bootstrap']['debug'] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
