<?php
/**
 * Asset Packagist.
 *
 * @see      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

return [
    'controllerNamespace' => 'hiqdev\assetpackagist\controllers',
    'components' => [
        'themeManager' => [
            'pathMap' => [
                '$themedViewPaths' => ['@hiqdev/assetpackagist/views'],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                \hiqdev\assetpackagist\assets\AppAsset::class
            ],
        ],
    ],
    'container' => [
        'singletons' => [
            \hiqdev\thememanager\menus\AbstractMainMenu::class => [
                'class' => \hiqdev\assetpackagist\menus\MainMenu::class,
            ],
            \hiqdev\thememanager\menus\AbstractFooterMenu::class => [
                'class' => \hiqdev\assetpackagist\menus\FooterMenu::class,
            ],
        ],
    ],
];
