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

/**
 * Bower repository.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class BowerRepository extends AbstractAssetsRepository
{
    /**
     * Loads Bower packages from their VCS repository.
     *
     * Unlike npm, the Bower registry response contains only a repository URL,
     * not a map of version metadata. Composer 2 calls this method instead of
     * the legacy Pool-aware whatProvides() hook, so recreate that VCS path
     * here and delegate filtering to the asset VCS repository.
     */
    public function loadPackages(array $packageNameMap, array $acceptableStabilities, array $stabilityFlags, array $alreadyLoaded = [])
    {
        $packages = [];
        $namesFound = [];

        foreach ($packageNameMap as $name => $constraint) {
            if ($this->findWhatProvides($name) === []) {
                continue;
            }

            $repositoryName = Util::convertAliasName($name);
            $packageName = Util::cleanPackageName($repositoryName);
            $packageUrl = $this->buildPackageUrl($packageName);
            $cacheName = $packageName . '-' . sha1($packageName) . '-package.json';
            $data = $this->fetchFile($packageUrl, $cacheName);
            $repositoryConfig = $this->createVcsRepositoryConfig($data, Util::cleanPackageName($name));
            $repositoryConfig['asset-repository-manager'] = $this->assetRepositoryManager;
            $repositoryConfig['vcs-package-filter'] = $this->packageFilter;

            $repository = $this->repositoryManager->createRepository($repositoryConfig['type'], $repositoryConfig);
            $result = $repository->loadPackages(
                [$name => $constraint],
                $acceptableStabilities,
                $stabilityFlags,
                $alreadyLoaded
            );

            $packages = array_merge($packages, $result['packages']);
            $namesFound = array_merge($namesFound, $result['namesFound']);
        }

        return [
            'namesFound' => array_values(array_unique($namesFound)),
            'packages' => $packages,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getType()
    {
        return 'bower';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUrl()
    {
        return 'https://registry.bower.io/packages';
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageUrl()
    {
        return $this->getUrl() . '/%package%';
    }

    /**
     * {@inheritdoc}
     */
    protected function getSearchUrl()
    {
        return $this->getUrl() . '/search/%query%';
    }

    /**
     * {@inheritdoc}
     */
    protected function createVcsRepositoryConfig(array $data, $registryName = null)
    {
        return array(
            'type' => $this->assetType->getName().'-vcs',
            'url' => $data['url'],
            'name' => $registryName,
        );
    }
}
