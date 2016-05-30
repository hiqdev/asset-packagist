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

/**
 * Registry trait.
 * All this to use protected functions from fxp.
 * @property RepositoryManager $rm
 */
trait RegistryTrait
{
    public function fetchPackageData($name)
    {
        $packageUrl = str_replace('%package%', $name, $this->lazyProvidersUrl);
        $cacheName = $name . '-' . sha1($name) . '-package.json';

        return $this->fetchFile($packageUrl, $cacheName);
    }

    /**
     * @param $name
     * @return \Composer\Repository\RepositoryInterface
     */
    public function buildVcsRepository($name)
    {
        $data = $this->fetchPackageData($name);
        $conf = $this->createVcsRepositoryConfig($data, $name);

        return $this->rm->createRepository($conf['type'], $conf);
    }

    public function getPackageSearchUrl($name)
    {
        return $this->siteUrl . '/search/?q=' . $name;
    }

    public function buildPackageUrl($name)
    {
        return $this->getPackageSearchUrl($name);
    }
}
