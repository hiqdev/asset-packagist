<?php

namespace hiqdev\assetpackagist\models;

use Yii;
use yii\helpers\Json;

class Storage
{
    protected static $_instance;

    protected function __construct()
    {
    }

    static public function getInstance()
    {
        if (static::$_instance === null) {
            static::$_instance = new Storage();
        }

        return static::$_instance;
    }

    public function getNextID()
    {
        return rand(1000000, 2000000);
    }

    public function writePackage(AssetPackage $package)
    {
        $name = $package->getFullName();
        $data = [
            'packages' => [
                $name => $package->getReleases(),
            ],
        ];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = static::buildPath($name, $hash);
        if (!file_exists($path)) {
            static::mkdir(dirname($path));
            file_put_contents($path, $json);
            file_put_contents(static::buildPath($name), $json);
            $this->writeProviderLatest($name, $hash);
        }

        return $hash;
    }

    public function readPackage(AssetPackage $package)
    {
        $name = $package->getFullName();
        $path = static::buildPath($name);
        if (!file_exists($path)) {
            return [];
        }
        $json = file_get_contents($path);
        $hash = hash('sha256', $json);
        $data = Json::decode($json);
        $releases = isset($data['packages'][$name]) ? $data['packages'][$name] : [];

        return compact('hash', 'releases');
    }

    public static function buildPath($name, $hash = 'latest')
    {
        return Yii::getAlias("@web/p/$name/$hash.json");
    }

    protected function writeProviderLatest($name, $hash)
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
            $this->writePackagesJson($hash);
        }

        return $hash;
    }

    protected function writePackagesJson($hash)
    {
        $data = [
            'search'            => '/search.json?q=%query%',
            'providers-url'     => '/p/%package%/%hash%.json',
            'provider-includes' => [
                'p/provider-latest$%hash%.json' => [
                    'sha256' => $hash,
                ],
            ],
        ];
        /// TODO lock
        file_put_contents(Yii::getAlias('@web/packages.json'), Json::encode($data));
    }

    public static function mkdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

}
