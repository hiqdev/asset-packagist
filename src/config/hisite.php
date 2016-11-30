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
    'controllerNamespace' => 'hiqdev\assetpackagist\controllers',
    'bootstrap' => ['log', \hiqdev\assetpackagist\Bootstrap::class],
    'components' => [
        'packageStorage' => [
            'class' => \hiqdev\assetpackagist\components\Storage::class,
        ],
        'menuManager' => [
            'items' => [
                'main' => \hiqdev\assetpackagist\menus\MainMenu::class,
                'footer' => \hiqdev\assetpackagist\menus\FooterMenu::class,
            ],
        ],
        'themeManager' => [
            'pathMap' => [
                '$themedViewPaths' => ['@hiqdev/assetpackagist/views'],
            ],
        ],
    ],
];
