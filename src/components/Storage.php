<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\components;

use hiqdev\assetpackagist\exceptions\AssetFileStorageException;
use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\base\Component;
use yii\helpers\Json;

class Storage extends Component implements StorageInterface
{
    protected $_path;
    protected $_locker;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->_path = Yii::getAlias('@storage', false);
    }

    protected function acquireLock()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        if (!$mutex->acquire('lock', 5)) {
            throw new \Exception('failed get lock');
        }
    }

    protected function releaseLock()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        $mutex->release('lock');
    }

    /**
     * {@inheritdoc}
     */
    public function getNextId()
    {
        $this->acquireLock();
        {
            $nextID = $this->readLastId() + 1;
            $this->writeLastId($nextID);
        }
        $this->releaseLock();

        return $nextID;
    }

    protected function readLastId()
    {
        $path = $this->getLastIdPath();

        return (file_exists($path) ? (int) file_get_contents($path) : 0) ?: 1000000;
    }

    protected function writeLastId($value)
    {
        if (file_put_contents($this->getLastIdPath(), $value) === false) {
            throw new AssetFileStorageException('Filed to write lastId to the storage');
        }
    }

    protected function getLastIdPath()
    {
        return $this->buildPath('lastid');
    }

    /**
     * {@inheritdoc}
     */
    public function writePackage(AssetPackage $package)
    {
        $name = $package->getNormalName();
        $data = [
            'packages' => [
                $name => $package->getReleases(),
            ],
        ];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = $this->buildHashedPath($name, $hash);
        $latestPath = $this->buildHashedPath($name);
        if (!file_exists($path)) {
            $this->acquireLock();
            try {
                if ($this->mkdir(dirname($path)) === false) {
                    throw new AssetFileStorageException('Failed to create a directory for asset-package', $package);
                }
                if (file_put_contents($path, $json) === false) {
                    throw new AssetFileStorageException('Failed to write package', $package);
                }
                if (file_put_contents($latestPath, $json) === false) {
                    throw new AssetFileStorageException('Failed to write file "latest.json" for asset-packge', $package);
                }
            } finally {
                $this->releaseLock();
            }
        } else {
            touch($latestPath);
        }

        $this->buildHashFile($name, $hash);

        $this->writeProviderList();

        return $hash;
    }

    /**
     * {@inheritdoc}
     */
    public function readPackage(AssetPackage $package)
    {
        $name = $package->getNormalName();
        $path = $this->buildHashedPath($name);
        clearstatcache(false, $path);
        if (!file_exists($path)) {
            return null;
        }
        $json = file_get_contents($path);
        $updateTime = filemtime($path);
        $hash = hash('sha256', $json);
        $data = Json::decode($json);
        $releases = isset($data['packages'][$name]) ? $data['packages'][$name] : [];

        return compact('hash', 'releases', 'updateTime');
    }

    protected function buildPath()
    {
        $args = func_get_args();
        array_unshift($args, $this->_path);

        return implode(DIRECTORY_SEPARATOR, $args);
    }

    protected function buildHashedPath($name, $hash = 'latest', $ext = '.json')
    {
        return $this->buildPath('p', $name, $hash . $ext);
    }

    /**
     * Generate a "latest.hash" containing last valid hash for provider.
     */
    protected function buildHashFile($name, $hash = null)
    {
        if ($hash === null) {
            $file = $this->buildHashedPath($name);
            $hash = hash_file('sha256', $file);
        }

        $lastHash = $this->buildHashedPath($name, 'latest', '.hash');

        $json = Json::encode([$name => ['sha256' => $hash]]);

        file_put_contents($lastHash, $json);

        $hashFile = $this->buildHashedPath($name, $hash);

        //Set the real last update of package
        if (file_exists($hashFile)) {
            $last_hash = $this->buildPath('p', $name, 'latest.hash');
            touch($last_hash, filemtime($hashFile));
            clearstatcache(false, $last_hash);
        }
    }

    /**
     * Gerente the name of block for provider, using the real update time.
     * @param string $hashFile The "latest.hash" file path
     * @return string The block name
     */
    protected function buildBlockNameProvider($hashFile)
    {
        $timestamp = filemtime($hashFile);

        if ($timestamp >= strtotime(date('Y-m-d 00:00:00'))) {
            return 'today';
        }

        if ($timestamp >= strtotime('monday last week')) {
            return 'this-week';
        }

        return date('Y-m', $timestamp);
    }

    /**
     * Generate all providers.
     */
    public function writeProviderList()
    {
        /**
         * Find all "latest.json" files in "p/*-asset/*".
         */
        $dir = new \RecursiveDirectoryIterator($this->_path);
        $ite = new \RecursiveIteratorIterator($dir);
        $files = new \RegexIterator($ite, '/.*\w+\-asset.*latest\.json$/', \RegexIterator::GET_MATCH);
        $fileList = [];
        foreach ($files as $file) {
            $fileList = array_merge($fileList, $file);
        }

        /**
         * Generate provider content.
         */
        $providers = [];
        foreach ($fileList as $file) {
            /**
             * Generate "latest.hash" for old files.
             */
            $hashFile = dirname($file) . DIRECTORY_SEPARATOR . 'latest.hash';
            if (!file_exists($hashFile)) {
                $this->buildHashFile(basename(dirname($file, 2)) . '/' . basename(dirname($file)));
            }

            $block = $this->buildBlockNameProvider($hashFile);

            if (!isset($providers[$block])) {
                $providers[$block] = [
                    'providers' => [],
                ];
            }

            $hashData = Json::decode(file_get_contents($hashFile) ?: '[]');

            if (empty($hashData)) {
                continue;
            }

            $providers[$block]['providers'][key($hashData)] = reset($hashData);
        }

        $includes = [];

        // Save the content of provider to file.
        foreach ($providers as $block => $data) {
            $name = 'provider-' . $block;

            $json = Json::encode($data);
            $hash = hash('sha256', $json);

            $includes[$block] = $hash;

            $latestPath = $this->buildHashedPath($name);
            $path = $this->buildHashedPath($name, $hash);

            if (!file_exists($path)) {
                $this->acquireLock();

                try {
                    if ($this->mkdir(dirname($path)) === false) {
                        throw new AssetFileStorageException('Failed to create a directory for provider-latest storage');
                    }
                    if (file_put_contents($path, $json) === false) {
                        throw new AssetFileStorageException('Failed to write package to provider-latest storage for package "' . $name . '"');
                    }
                    if (file_put_contents($latestPath, $json) === false) {
                        throw new AssetFileStorageException('Failed to write file "latest.json" to provider-latest storage for package "' . $name . '"');
                    }
                } finally {
                    $this->releaseLock();
                }
            } else {
                touch($latestPath);
            }
            //Build "latest.hash" for provider
            $this->buildHashFile($name, $hash);
        }

        $this->writePackagesJson($includes);
    }

    /**
     * Update the "packages.json" file, with all providers.
     * @param array $includes The providers with hash
     * @throws AssetFileStorageException
     */
    protected function writePackagesJson($includes)
    {
        $data = [
            'providers-url'     => '/p/%package%/%hash%.json',
            'provider-includes' => [],
        ];

        ksort($includes);

        foreach ($includes as $block => $hash) {
            $name = 'p/provider-' . $block . '/%hash%.json';

            $data['provider-includes'][$name] = [
                'sha256' => $hash,
            ];
        }

        $this->acquireLock();
        $filename = $this->buildPath('packages.json');
        try {
            if (file_put_contents($filename, Json::encode($data)) === false) {
                throw new AssetFileStorageException('Failed to write main packages.json');
            }
            touch($filename);
        } finally {
            $this->releaseLock();
        }

        $this->clearOldFiles();
    }

    /**
     * Remove all olds files.
     * @param integer $ttl Time to live comparing with "latest.hash"
     */
    public function clearOldFiles($ttl = 300)
    {
        $dir = new \RecursiveDirectoryIterator($this->_path . DIRECTORY_SEPARATOR . 'p');
        $ite = new \RecursiveIteratorIterator($dir);
        $filesIterator = new \RegexIterator($ite, '/.*\.json$/', \RegexIterator::GET_MATCH);
        $fileList = [];
        foreach ($filesIterator as $files) {
            foreach ($files as $file) {
                //Ignore "latest.json" files
                if (preg_match('/latest\.json$/', $file)) {
                    continue;
                }

                $hash_file = dirname($file) . DIRECTORY_SEPARATOR . 'latest.hash';

                if (!file_exists($hash_file)) {
                    continue;
                }

                if (filemtime($file) < filemtime($hash_file) - $ttl) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Creates directory $dir and sets chmod 777.
     * @param string $dir
     * @return bool whether the directory was created successfully
     */
    protected function mkdir($dir)
    {
        if (!file_exists($dir)) {
            return @mkdir($dir, 0777, true);
        }

        return true;
    }

    public function readJson($path)
    {
        return Json::decode(file_get_contents($this->buildPath($path)));
    }

    protected function readPackagesJson()
    {
        $data = $this->readJson('packages.json');

        return $data['provider-includes'];
    }

    protected function readProvider($path)
    {
        $data = $this->readJson($path);

        return $data['providers'];
    }

    /**
     * {@inheritdoc}
     */
    public function listPackages()
    {
        $packages = [];
        $providers = $this->readPackagesJson();
        foreach ($providers as $path => $data) {
            $path = strtr($path, ['%hash%' => $data['sha256']]);
            $packages = array_merge($packages, $this->readProvider($path));
        }

        return $packages;
    }
}
