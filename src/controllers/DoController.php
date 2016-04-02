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

        $regurl = $apiurl . $name;
        $data = Json::decode($this->getContents($regurl, $regurl));

        $url = $data['url'];
        $repo = new AssetVcsRepository(['url' => $url, 'type' => $type . '-assets'], $this->io, $this->composer->getConfig(), $this->composer->getEventDispatcher());
        $packages = [];
        $full_name = $type . '-asset/' . $name;
        foreach ($repo->getPackages() as $package) {
            $packages[$package->getVersion()] = [
                'name'      => $full_name,
                'version'   => $package->getVersion(),
                'dist'      => [
                    'type' => $package->getDistType(),
                    'url'  => $package->getDistUrl(),
                ],
            ];
        }
        $json = Json::encode($packages);
        var_dump($json);
        $hash = hash('sha256', $json);
        var_dump($hash);
        $path = $this->getPath($name, $hash);
        var_dump($path);
        file_put_contents($path, $json);

        return $hash;
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
}
