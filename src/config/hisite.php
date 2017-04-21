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
    'controllerNamespace' => 'hiqdev\assetpackagist\controllers',
    'components' => [
        'themeManager' => [
            'pathMap' => [
                '$themedViewPaths' => ['@hiqdev/assetpackagist/views'],
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
