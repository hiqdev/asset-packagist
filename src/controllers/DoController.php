<?php

/*
 * asset-packagist.hiqdev.com
 *
 * @link      http://asset-packagist.hiqdev.com/
 * @package   asset-packagist.hiqdev.com
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\controllers;

use Composer\Factory;
use Composer\IO\NullIO;
use Yii;
use yii\helpers\Json;
use hiqdev\assetpackagist\registry\RegistryFactory;

class DoController extends \yii\console\Controller
{
    protected $io;
    protected $composer;

    public function init()
    {
        $this->io = new NullIO();
        $this->composer = Factory::create($this->io);
    }

    public function actionUpdatePackage($type, $name)
    {
        $registry   = RegistryFactory::getRegistry($type, $this->composer->getRepositoryManager());
        $repo       = $registry->buildVcsRepository($name);
        $fullName   = $this->buildFullName($type, $name);
        $versions   = $this->prepareVersions($repo, $fullName);
        $hash       = $this->updatePackage($fullName, $versions);
        if ($hash) {
            echo "updated $hash $fullName\n";
        }
    }

    public function buildFullName($type, $name)
    {
        return $type . '-asset/' . $name;
    }

    public function prepareVersions($repo, $fullName)
    {
        $versions = [];
        foreach ($repo->getPackages() as $package) {
            $version = [
                /// TODO XXX how to get uid properly ???
                'uid'       => rand(1000000, 2000000),
                'name'      => $fullName,
                'version'   => $package->getVersion(),
            ];
            if ($package->getDistUrl()) {
                $version['dist'] = [
                    'type'      => $package->getDistType(),
                    'url'       => $package->getDistUrl(),
                    'reference' => $package->getDistReference(),
                ];
            }
            if ($package->getSourceUrl()) {
                $version['source'] = [
                    'type'      => $package->getSourceType(),
                    'url'       => $package->getSourceUrl(),
                    'reference' => $package->getSourceReference(),
                ];
            }
            if ($version['dist'] || $version['source']) {
                $versions[$package->getVersion()] = $version;
            }
        }

        return $versions;
    }

    public static function mkdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    protected function updatePackage($name, $versions)
    {
        $data = [
            'packages' => [
                $name => $versions,
            ],
        ];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = Yii::getAlias("@web/p/$name$$hash.json");
        if (!file_exists($path)) {
            static::mkdir(dirname($path));
            file_put_contents($path, $json);
            $this->updateProviderLatest($name, $hash);
        }

        return $hash;
    }

    protected function updateProviderLatest($name, $hash)
    {
        $latest_path = Yii::getAlias('@web/provider-latest.json');
        if (file_exists($latest_path)) {
            $data = Json::decode(file_get_contents($latest_path) ?: '[]');
        }
        if (!is_array($data)) {
            $data = [];
        }
        if (!isset($data['providers'])) {
            $data['providers'] = [];
        }
        $data['providers'][$name] = ['sha256' => $hash];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = Yii::getAlias("@web/p/provider-latest$$hash.json");
        if (!file_exists($path)) {
            file_put_contents($path, $json);
            /// TODO lock
            file_put_contents($latest_path, Json::encode($data));
            $this->updateIndex($hash);
        }

        return $hash;
    }

    protected function updateIndex($hash)
    {
        $data = [
            'providers-url'     => '/p/%package%$%hash%.json',
            'search'            => '/search.json?q=%query%',
            'provider-includes' => [
                'p/provider-latest$%hash%.json' => [
                    'sha256' => $hash,
                ],
            ],
        ];
        /// TODO lock
        file_put_contents(Yii::getAlias('@web/packages.json'), Json::encode($data));
    }

    public function getPath($type, $name, $hash)
    {
        $two = substr($name, 0, 2);
        $dir = Yii::getAlias("@runtime/packages/$two/$type:$name");
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir . "/$hash.json";
    }

    public function actionTest()
    {
        var_dump(Yii::getAlias('@web'));
    }
}
