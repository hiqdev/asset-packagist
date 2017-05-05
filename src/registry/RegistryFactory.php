<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\registry;

use Composer\IO\NullIO;
use Composer\Repository\RepositoryManager;
use Fxp\Composer\AssetPlugin\Config\Config;
use Fxp\Composer\AssetPlugin\Repository\AbstractAssetsRepository;
use Fxp\Composer\AssetPlugin\Repository\AssetRepositoryManager;
use Fxp\Composer\AssetPlugin\Repository\VcsPackageFilter;

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
        $class = static::$classes[$type];
        $rm->setRepositoryClass($type, $class);

        $config = [
            'asset-repository-manager' => self::createAssetRepositoryManager($rm),
            'asset-options'      => [],
        ];

        return $rm->createRepository($type, $config);
    }

    public static function createAssetRepositoryManager($repositoryManager)
    {
        $filter = (new \ReflectionClass(VcsPackageFilter::class))->newInstanceWithoutConstructor();

        return new AssetRepositoryManager(new NullIO(), $repositoryManager, new Config([]), $filter);
    }
}
