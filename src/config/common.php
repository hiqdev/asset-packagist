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
    'components' => [],
    'modules'    => [],
    'params'     => require __DIR__ . '/params.php',
    'aliases'    => [
        '@storage' => '<base-dir>/web',
        '@bower'   => '@vendor/bower-asset',
        '@npm'     => '@vendor/npm-asset',
    ],
];
