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
    'components' => [
        'config' => [
            'include' => [
                '@hiqdev/assetpackagist/config/goals.yml',
            ],
            'migrate' => [
                'class' => \yii\console\controllers\MigrateController::class,
                'migrationNamespaces' => [
                    'hiqdev\assetpackagist\migrations',
                ],
                'migrationPath' => null,
            ],
        ],
        'log' => [
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => \hiqdev\assetpackagist\log\StdoutTarget::class,
                    'categories' => ['hiqdev\assetpackagist\commands\*'],
                    'exportInterval' => 1,
                    'logVars' => []
                ],
            ],
        ],
    ],
];
