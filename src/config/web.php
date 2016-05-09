<?php

$config = require HISITE_VENDOR_DIR . '/hiqdev/hisite-config.php';

if (YII_DEBUG) {
    $config['bootstrap']['debug'] = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        'allowedIPs' => $config['params']['debug_allowed_ips'],
    ];
}

return $config;
