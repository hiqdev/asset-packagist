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
    'aliases' => require __DIR__ . '/aliases.php',
    'params'  => require __DIR__ . '/params.php',
    'components' => [
        'config' => [
            'include' => '@hiqdev/assetpackagist/config/goals.yml',
        ],
    ],
];
