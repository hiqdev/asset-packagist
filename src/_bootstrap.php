<?php

if (!defined('HISITE_VENDOR_DIR')) {
    foreach ([dirname(__DIR__) . '/vendor', dirname(dirname(dirname(__DIR__)))] as $dir) {
        if (file_exists($dir . '/autoload.php')) {
            define('HISITE_VENDOR_DIR', $dir);
            break;
        }
    }

    if (!defined('HISITE_VENDOR_DIR')) {
        fwrite(STDERR, "Run composer to set up dependencies!\n");
        exit(1);
    }

    require HISITE_VENDOR_DIR . '/autoload.php';
    require HISITE_VENDOR_DIR . '/yiisoft/yii2/Yii.php';
}
