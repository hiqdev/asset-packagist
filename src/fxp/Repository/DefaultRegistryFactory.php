<?php

/*
 * This file is part of the Fxp Composer Asset Plugin package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace hiqdev\assetpackagist\fxp\Repository;

use hiqdev\assetpackagist\fxp\Assets;
use hiqdev\assetpackagist\fxp\Config\Config;
use hiqdev\assetpackagist\fxp\Util\AssetPlugin;

/**
 * Factory of default repository registries.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class DefaultRegistryFactory implements RegistryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create(AssetRepositoryManager $arm, VcsPackageFilter $filter, Config $config)
    {
        $rm = $arm->getRepositoryManager();

        foreach (Assets::getDefaultRegistries() as $assetType => $registryClass) {
            $repoConfig = AssetPlugin::createRepositoryConfig($arm, $filter, $config, $assetType);

            $rm->setRepositoryClass($assetType, $registryClass);
            $rm->addRepository($rm->createRepository($assetType, $repoConfig));
        }
    }
}
