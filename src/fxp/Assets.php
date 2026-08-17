<?php

/*
 * This file is part of the Fxp Composer Asset Plugin package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace hiqdev\assetpackagist\fxp;

use hiqdev\assetpackagist\fxp\Exception\InvalidArgumentException;
use hiqdev\assetpackagist\fxp\Type\AssetTypeInterface;

/**
 * Assets definition.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class Assets
{
    /**
     * @var array
     */
    protected static $typeClasses = array(
        'npm' => 'hiqdev\assetpackagist\fxp\Type\NpmAssetType',
        'bower' => 'hiqdev\assetpackagist\fxp\Type\BowerAssetType',
    );

    /**
     * @var array
     */
    protected static $registryFactoryClasses = array(
        'default' => 'hiqdev\assetpackagist\fxp\Repository\DefaultRegistryFactory',
    );

    /**
     * @var array
     */
    protected static $defaultRegistryClasses = array(
        'npm' => 'hiqdev\assetpackagist\fxp\Repository\NpmRepository',
        'bower' => 'hiqdev\assetpackagist\fxp\Repository\BowerRepository',
    );

    /**
     * @var array
     */
    protected static $vcsRepositoryDrivers = array(
        'vcs' => 'hiqdev\assetpackagist\fxp\Repository\AssetVcsRepository',
        'github' => 'hiqdev\assetpackagist\fxp\Repository\AssetVcsRepository',
        'git-bitbucket' => 'hiqdev\assetpackagist\fxp\Repository\AssetVcsRepository',
        'git' => 'hiqdev\assetpackagist\fxp\Repository\AssetVcsRepository',
        'hg-bitbucket' => 'hiqdev\assetpackagist\fxp\Repository\AssetVcsRepository',
        'hg' => 'hiqdev\assetpackagist\fxp\Repository\AssetVcsRepository',
        'perforce' => 'hiqdev\assetpackagist\fxp\Repository\AssetVcsRepository',
        'svn' => 'hiqdev\assetpackagist\fxp\Repository\AssetVcsRepository',
    );

    /**
     * @var array
     */
    protected static $vcsDrivers = array(
        'github' => 'hiqdev\assetpackagist\fxp\Repository\Vcs\GitHubDriver',
        'git-bitbucket' => 'hiqdev\assetpackagist\fxp\Repository\Vcs\GitBitbucketDriver',
        'git' => 'hiqdev\assetpackagist\fxp\Repository\Vcs\GitDriver',
        'hg-bitbucket' => 'hiqdev\assetpackagist\fxp\Repository\Vcs\HgBitbucketDriver',
        'hg' => 'hiqdev\assetpackagist\fxp\Repository\Vcs\HgDriver',
        'perforce' => 'hiqdev\assetpackagist\fxp\Repository\Vcs\PerforceDriver',
        // svn must be last because identifying a subversion server for sure is practically impossible
        'svn' => 'hiqdev\assetpackagist\fxp\Repository\Vcs\SvnDriver',
    );

    /**
     * Creates asset type.
     *
     * @param string $type
     *
     * @return AssetTypeInterface
     *
     * @throws InvalidArgumentException When the asset type does not exist
     */
    public static function createType($type)
    {
        if (!isset(static::$typeClasses[$type])) {
            throw new InvalidArgumentException('The asset type "'.$type.'" does not exist, only "'.implode('", "', static::getTypes()).'" are accepted');
        }

        $class = static::$typeClasses[$type];

        return new $class();
    }

    /**
     * Gets the asset types.
     *
     * @return array
     */
    public static function getTypes()
    {
        return array_keys(static::$typeClasses);
    }

    /**
     * Gets the asset registry repository factories.
     *
     * @return array
     */
    public static function getRegistryFactories()
    {
        return static::$registryFactoryClasses;
    }

    /**
     * Gets the asset registry repositories.
     *
     * @return array
     */
    public static function getDefaultRegistries()
    {
        return static::$defaultRegistryClasses;
    }

    /**
     * Gets the asset vcs repository drivers.
     *
     * @return array
     */
    public static function getVcsRepositoryDrivers()
    {
        return static::$vcsRepositoryDrivers;
    }

    /**
     * Gets the asset vcs drivers.
     *
     * @return array
     */
    public static function getVcsDrivers()
    {
        return static::$vcsDrivers;
    }
}
