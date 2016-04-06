<?php

namespace hiqdev\assetpackagist\registry;

/**
 * Registry trait.
 * All this to use protected functions from fxp.
 */
trait RegistryTrait
{
    public function fetchPackageData($name)
    {
        $packageUrl = str_replace('%package%', $name, $this->lazyProvidersUrl);
        $cacheName = $name . '-' . sha1($name) . '-package.json';

        return $this->fetchFile($packageUrl, $cacheName);
    }

    public function buildVcsRepository($name)
    {
        $data = $this->fetchPackageData($name);
        $conf = $this->createVcsRepositoryConfig($data, $name);

        return $this->rm->createRepository($conf['type'], $conf);
    }
}
