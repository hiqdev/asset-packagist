<?php

/*
 * Asset Packagist
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\registry;

class RegistryFactory
{
    protected static $classes = [
        'bower' => BowerRegistry::class,
        'npm'   => NpmRegistry::class,
    ];

    public static $registries = [];

    public static function getRegistry($type, $rm)
    {
        if (!isset(static::$registries[$type])) {
            static::$registries[$type] = static::buildRegistry($type, $rm);
        }

        return static::$registries[$type];
    }

    protected static function buildRegistry($type, $rm)
    {
        $config = [
            'repository-manager' => $rm,
            'asset-options'      => [],
        ];
        $rm->setRepositoryClass($type, static::$classes[$type]);

        return $rm->createRepository($type, $config);
    }
}
