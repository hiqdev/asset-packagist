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

use Composer\Repository\RepositoryManager;
use Fxp\Composer\AssetPlugin\Repository\AbstractAssetsRepository;

class RegistryFactory
{
    /**
     * @var array
     */
    protected static $classes = [
        'bower' => BowerRegistry::class,
        'npm'   => NpmRegistry::class,
    ];

    /**
     * @var AbstractAssetsRepository[]
     */
    public static $registries = [];

    /**
     * @param string $type
     * @param RepositoryManager $rm
     * @return AbstractAssetsRepository|BowerRegistry|NpmRegistry
     */
    public static function getRegistry($type, $rm)
    {
        if (!isset(static::$registries[$type])) {
            static::$registries[$type] = static::buildRegistry($type, $rm);
        }

        return static::$registries[$type];
    }

    /**
     * @param string $type
     * @param RepositoryManager $rm
     * @return mixed
     */
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
