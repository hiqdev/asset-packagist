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
    'viewPath'      => '@hiqdev/assetpackagist/views',
    'controllerNamespace' => 'hiqdev\assetpackagist\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'packageStorage' => [
            'class' => \hiqdev\assetpackagist\components\Storage::class,
        ],
        'menuManager' => [
            'menus' => [
                'main' => \hiqdev\assetpackagist\MainMenu::class,
                'footer' => \hiqdev\assetpackagist\FooterMenu::class,
            ],
        ],
        'themeManager' => [
            'viewPaths' => [
                'assetpackagist' => '@hiqdev/assetpackagist/views',
            ],
        ],
    ],
];
