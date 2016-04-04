<?php

namespace hiqdev\assetpackagist\controllers;

use Composer\Composer;
use Composer\Config;
use Composer\EventDispatcher\EventDispatcher;
use Composer\Factory;
use Composer\IO\NullIO;
use Fxp\Composer\AssetPlugin\Repository\AssetVcsRepository;
use Yii;
use yii\helpers\Json;

class DoController extends \yii\console\Controller
{
    public $remoteFilesystem;
    public $eventDispatcher;
    public $composer;
    public $config;
    public $io;

    public function init2()
    {
        $this->io = new NullIO;
        $this->config = new Config();
        $this->config->merge(array(
            'config' => array(
                'home' => Yii::getAlias('@runtime/composer_home'),
            ),
        ));
        $this->remoteFilesystem = Factory::createRemoteFilesystem($this->io, $this->config);
        $this->composer = new Composer;
        $this->composer->setConfig($this->config);
        $this->eventDispatcher = new EventDispatcher($this->composer, $this->io);
        $this->composer->setEventDispatcher($this->eventDispatcher);
        $this->composer->setPackage($package);
    }

    public function init()
    {
        $this->io = new NullIO;
        $this->composer = Factory::create($this->io);
        $this->remoteFilesystem = Factory::createRemoteFilesystem($this->io, $this->config);
    }

    protected function getContents($url)
    {
        return $this->remoteFilesystem->getContents($url, $url, false);
    }

    public function getApiUrl($type)
    {
        static $urls = [
            'bower' => 'https://bower.herokuapp.com/packages/',
            'npm'   => 'https://registry.npmjs.org/',
        ];

        return isset($urls[$type]) ? $urls[$type] : null;
    }

    public function actionUpdatePackage($type, $name)
    {
        $apiurl = $this->getApiUrl($type);
        if (!$apiurl) {
            die('Type: $type');
        }
        if (!$name) {
            die('Name!');
        }

        $full_name = $type . '-asset/' . $name;
        $regurl = $apiurl . $name;
        $data = Json::decode($this->getContents($regurl, $regurl));

        $url = $data['url'];
        $repo = new AssetVcsRepository(['url' => $url, 'type' => $type . '-assets'], $this->io, $this->composer->getConfig(), $this->composer->getEventDispatcher());
        $versions = [];
        foreach ($repo->getPackages() as $package) {
            if (!$package->getDistType()) {
                /// TODO investigate more why
                continue;
            }
            $versions[$package->getVersion()] = [
                'uid'       => rand(1000000, 2000000),
                'name'      => $full_name,
                'version'   => $package->getVersion(),
                'dist'      => [
                    'type' => $package->getDistType(),
                    'url'  => $package->getDistUrl(),
                ],
            ];
        }

        return $this->updatePackage($full_name, $versions);
    }

    static public function mkdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    protected function updatePackage($name, $versions)
    {
        $data = [
            'packages' => [
                $name => $versions
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
        $data = Json::decode(file_get_contents($latest_path) ?: '[]');
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
        $this->updateProviderLatest('sadfasd/sadfa');
    }
}
