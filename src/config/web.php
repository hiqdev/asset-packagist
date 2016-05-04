<?php

/*
 * asset-packagist.hiqdev.com
 *
 * @link      http://asset-packagist.hiqdev.com/
 * @package   asset-packagist.hiqdev.com
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

$config = require __DIR__ . '/common.php';

$config['components']['urlManager'] = [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
];

if (YII_DEBUG) {
    $config['bootstrap']['debug'] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => isset($params['debug_allowedIPs']) ? $params['debug_allowedIPs'] : [],
    ];
}

return $config;
