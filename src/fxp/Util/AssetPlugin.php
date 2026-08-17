<?php

/*
 * This file is part of the Fxp Composer Asset Plugin package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace hiqdev\assetpackagist\fxp\Util;

use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Repository\RepositoryManager;
use hiqdev\assetpackagist\fxp\Assets;
use hiqdev\assetpackagist\fxp\Config\Config;
use hiqdev\assetpackagist\fxp\Repository\AssetRepositoryManager;
use hiqdev\assetpackagist\fxp\Repository\VcsPackageFilter;

/**
 * Helper for FxpAssetPlugin.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class AssetPlugin
{
    /**
     * Creates the asset options.
     *
     * @param array  $config    The composer config section of asset options
     * @param string $assetType The asset type
     *
     * @return array The asset registry options
     */
    public static function createAssetOptions(array $config, $assetType)
    {
        $options = array();

        foreach ($config as $key => $value) {
            if (0 === strpos($key, $assetType.'-')) {
                $key = substr($key, strlen($assetType) + 1);
                $options[$key] = $value;
            }
        }

        return $options;
    }

    /**
     * Create the repository config.
     *
     * @param AssetRepositoryManager $arm       The asset repository manager
     * @param VcsPackageFilter       $filter    The vcs package filter
     * @param Config                 $config    The plugin config
     * @param string                 $assetType The asset type
     *
     * @return array
     */
    public static function createRepositoryConfig(AssetRepositoryManager $arm, VcsPackageFilter $filter, Config $config, $assetType)
    {
        return array(
            'asset-repository-manager' => $arm,
            'vcs-package-filter' => $filter,
            'asset-options' => static::createAssetOptions($config->getArray('registry-options'), $assetType),
            'vcs-driver-options' => $config->getArray('vcs-driver-options'),
        );
    }

    /**
     * Adds asset registry repositories.
     *
     * @param AssetRepositoryManager $arm
     * @param VcsPackageFilter       $filter
     * @param Config                 $config
     */
    public static function addRegistryRepositories(AssetRepositoryManager $arm, VcsPackageFilter $filter, Config $config)
    {
        foreach (Assets::getRegistryFactories() as $registryType => $factoryClass) {
            $ref = new \ReflectionClass($factoryClass);

            if ($ref->implementsInterface('hiqdev\assetpackagist\fxp\Repository\RegistryFactoryInterface')) {
                call_user_func(array($factoryClass, 'create'), $arm, $filter, $config);
            }
        }
    }

    /**
     * Sets vcs type repositories.
     *
     * @param RepositoryManager $rm
     */
    public static function setVcsTypeRepositories(RepositoryManager $rm)
    {
        foreach (Assets::getTypes() as $assetType) {
            foreach (Assets::getVcsRepositoryDrivers() as $driverType => $repositoryClass) {
                $rm->setRepositoryClass($assetType.'-'.$driverType, $repositoryClass);
            }
        }
    }

    /**
     * Adds the main file definitions from the root package.
     *
     * @param Config           $config
     * @param PackageInterface $package
     * @param string           $section
     *
     * @return PackageInterface
     */
    public static function addMainFiles(Config $config, PackageInterface $package, $section = 'main-files')
    {
        if ($package instanceof Package) {
            $packageExtra = $package->getExtra();
            $rootMainFiles = $config->getArray($section);

            foreach ($rootMainFiles as $packageName => $files) {
                if ($packageName === $package->getName()) {
                    $packageExtra['bower-asset-main'] = $files;
                    break;
                }
            }

            $package->setExtra($packageExtra);
        }

        return $package;
    }
}
