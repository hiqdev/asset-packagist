<?php

namespace hiqdev\assetpackagist\models;

use Exception;
use Yii;
use yii\helpers\Json;

class Storage
{
    protected static $_instance;
    protected static $_lockHandle;
    protected static $_lockCount = 0;

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
        $this->getLock();
        $nextID = $this->readLastID() + 1;
        $this->writeLastID($nextID);
        $this->releaseLock();

        return $nextID;
    }

    protected function readLastId()
    {
        $path = $this->getLastIDPath();

        return file_exists($path) ? (int)file_get_contents($path) : 1000000;
    }

    protected function writeLastId($value)
    {
        file_put_contents($this->getLastIDPath(), $value);
    }

    protected function getLastIDPath()
    {
        return Yii::getAlias('@web/lastid');
    }

    protected function getLockHandle()
    {
        if (static::$_lockHandle === null) {
            $path = Yii::getAlias('@web/lock');
            if (!file_exists($path)) {
                file_put_contents($path, 'lock');
            }
            static::$_lockHandle = fopen($path, 'r+');
        }

        return static::$_lockHandle;
    }

    public function hasLock()
    {
        return (bool)static::$_lockCount;
    }

    protected function getLock()
    {
        if (!$this->hasLock()) {
            if (!flock($this->getLockHandle(), LOCK_EX)) {
                throw new Exception('failed get lock');
            }
        }
        ++$this->_lockCount;
    }

    protected function releaseLock()
    {
        if ($this->_lockCount<1) {
            throw new Exception('no lock to release');
        }
        if ($this->_lockCount === 1) {
            if (!flock($this->getLockHandle(), LOCK_UN)) {
                throw new Exception('failed release lock');
            }
        }
        --$this->_lockCount;
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
            $this->getLock();
            {
                static::mkdir(dirname($path));
                file_put_contents($path, $json);
                file_put_contents(static::buildPath($name), $json);
                $this->writeProviderLatest($name, $hash);
            }
            $this->releaseLock();
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
            $this->getLock();
            {
                file_put_contents($path, $json);
                file_put_contents($latest_path, Json::encode($data));
                $this->writePackagesJson($hash);
            }
            $this->releaseLock();
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
        $this->getLock();
        {
            file_put_contents(Yii::getAlias('@web/packages.json'), Json::encode($data));
        }
        $this->releaseLock();
    }

    public static function mkdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

}
