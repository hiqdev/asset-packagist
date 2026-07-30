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

    protected function acquireTopLevelLock()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        if (!$mutex->acquire('lock', 5)) {
            throw new \Exception('failed get lock');
        }
    }

    protected function releaseTopLevelLock()
    {
        /* @var $mutex \yii\mutex\Mutex */
        $mutex = Yii::$app->mutex;

        $mutex->release('lock');
    }

    protected function acquirePackageLock($packageName)
    {
        $mutex  = Yii::$app->mutex;
        $key    = 'package-lock-' . $packageName;

        if (!$mutex->acquire($key, 5)) {
            throw new \Exception('failed get package lock for package ' . $packageName);
        }
    }

    protected function releasePackageLock($packageName)
    {
        $mutex  = Yii::$app->mutex;
        $key    = 'package-lock-' . $packageName;

        $mutex->release($key);
    }

    /**
     * {@inheritdoc}
     */
    public function getNextId()
    {
        $this->acquireTopLevelLock();
        {
            $nextID = $this->readLastId() + 1;
            $this->writeLastId($nextID);
        }
        $this->releaseTopLevelLock();

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
        $this->acquirePackageLock($name);

        try {
            if ($this->shardNeedsWrite($path, $hash)) {
                if ($this->mkdir(dirname($path)) === false) {
                    throw new AssetFileStorageException('Failed to create a directory for asset-package', $package);
                }
                if (!$this->writeShardAtomic($path, $json)) {
                    throw new AssetFileStorageException('Failed to write package', $package);
                }
            }
            if (!$this->writeLatestAtomic($latestPath, $json)) {
                throw new AssetFileStorageException('Failed to write file "latest.json" for asset-packge', $package);
            }
        } finally {
            $this->releasePackageLock($name);
        }

        $this->writeProviderLatest($name, $hash);

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
        try {
            $data = Json::decode($json);
        } catch (\Exception $e) {
            return null;
        }
        $releases = isset($data['packages'][$name]) ? $data['packages'][$name] : [];

        return compact('hash', 'releases', 'updateTime');
    }

    protected function buildPath()
    {
        $args = func_get_args();
        array_unshift($args, $this->_path);

        return implode(DIRECTORY_SEPARATOR, $args);
    }

    protected function buildHashedPath($name, $hash = 'latest')
    {
        return $this->buildPath('p', $name, $hash . '.json');
    }

    /**
     * Atomically replaces $path's content with $json, so concurrent lock-free
     * readers (nginx, Composer, readPackage()) never observe a truncated file.
     * No-op (besides a mtime touch) when the content did not change.
     * @return bool whether the file was written
     */
    protected function writeLatestAtomic($path, $json)
    {
        $current = file_exists($path) ? file_get_contents($path) : null;
        if ($current === $json) {
            return touch($path);
        }

        return $this->writeShardAtomic($path, $json);
    }

    /**
     * Writes $json to $path via tmp-file-then-rename, so concurrent lock-free
     * readers never observe a truncated file.
     * @return bool whether the file was written
     */
    protected function writeShardAtomic($path, $json)
    {
        $tmpPath = $path . '.tmp.' . getmypid() . '.' . mt_rand();
        if (file_put_contents($tmpPath, $json) === false) {
            return false;
        }
        if (!rename($tmpPath, $path)) {
            @unlink($tmpPath);

            return false;
        }

        return true;
    }

    /**
     * Whether a content-addressed shard at $path still needs to be (re)written for $hash.
     * True when the file is missing, empty, or its content doesn't actually hash to
     * $hash - covering the case where a previously-corrupted shard happens to share a
     * filename with freshly-computed content (see #194: existence/size alone silently
     * resurrects stale corruption instead of overwriting it).
     */
    protected function shardNeedsWrite($path, $hash)
    {
        return !file_exists($path) || filesize($path) === 0 || hash_file('sha256', $path) !== $hash;
    }

    protected function writeProviderLatest($name, $hash)
    {
        $latestPath = $this->buildHashedPath('provider-latest');
        $this->acquireTopLevelLock();

        if (file_exists($latestPath)) {
            $data = Json::decode(file_get_contents($latestPath) ?: '[]');
        }
        if (!isset($data) || !is_array($data)) {
            $data = [];
        }
        if (!isset($data['providers'])) {
            $data['providers'] = [];
        }
        $data['providers'][$name] = ['sha256' => $hash];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = $this->buildHashedPath('provider-latest', $hash);

        try {
            if ($this->shardNeedsWrite($path, $hash)) {
                if ($this->mkdir(dirname($path)) === false) {
                    throw new AssetFileStorageException('Failed to create a directory for provider-latest storage');
                }
                if (!$this->writeShardAtomic($path, $json)) {
                    throw new AssetFileStorageException('Failed to write package to provider-latest storage for package "' . $name . '"');
                }
            }
            if (!$this->writeLatestAtomic($latestPath, $json)) {
                throw new AssetFileStorageException('Failed to write file "latest.json" to provider-latest storage for package "' . $name . '"');
            }

            $this->writePackagesJson($hash);
        } finally {
            $this->releaseTopLevelLock();
        }

        return $hash;
    }

    protected function writePackagesJson($hash)
    {
        $data = [
            'providers-url'     => '/p/%package%/%hash%.json',
            'provider-includes' => [
                'p/provider-latest/%hash%.json' => [
                    'sha256' => $hash,
                ],
            ],
            'available-package-patterns' => ['bower-asset/*', 'npm-asset/*'],
        ];
        $filename = $this->buildPath('packages.json');
        $json = Json::encode($data);
        if (!$this->writeLatestAtomic($filename, $json)) {
            throw new AssetFileStorageException('Failed to write main packages.json');
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

    /**
     * {@inheritdoc}
     */
    public function checkPackageIsSane(AssetPackage $package)
    {
        $name = $package->getNormalName();
        $result = [
            'sane' => true,
            'activeCorrupted' => false,
            'activeMissing' => false,
            'orphanedRemoved' => 0,
        ];

        $activeHash = null;
        $latestPath = $this->buildHashedPath($name);
        $latestContent = file_exists($latestPath) ? file_get_contents($latestPath) : false;
        $parsable = false;
        if ($latestContent !== false) {
            try {
                $parsable = Json::decode($latestContent) !== null;
            } catch (\Exception $e) {
                $parsable = false;
            }
        }
        if (!$parsable) {
            $result['activeCorrupted'] = true;
        } else {
            $activeHash = hash('sha256', $latestContent);
            if (!file_exists($this->buildHashedPath($name, $activeHash))) {
                $result['activeMissing'] = true;
            }
        }

        try {
            $directoryIterator = new \DirectoryIterator($this->buildPath('p', $name));
            $iterator = new \RegexIterator($directoryIterator, '/^.+\.json$/i', \RecursiveRegexIterator::GET_MATCH);

            foreach ($iterator as $match) {
                $filename = $match[0];
                $sha = basename($filename, '.json');
                if ($sha === 'latest') {
                    continue;
                }

                $path = $this->buildPath('p', $name, $filename);
                $fileHash = hash_file('sha256', $path);
                if ($sha !== $fileHash) {
                    unlink($path);
                    if ($activeHash !== null && $sha === $activeHash) {
                        $result['activeCorrupted'] = true;
                    } else {
                        ++$result['orphanedRemoved'];
                    }
                }
            }
        } catch (\UnexpectedValueException $e) {
            // package directory doesn't exist at all - already reflected via
            // activeCorrupted/activeMissing above, nothing left to iterate
        }

        $result['sane'] = !$result['activeCorrupted'] && !$result['activeMissing'] && $result['orphanedRemoved'] === 0;

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function checkProviderLatestIsSane()
    {
        $packagesJsonPath = $this->buildPath('packages.json');
        if (!file_exists($packagesJsonPath)) {
            return ['sane' => false, 'reason' => 'packages_json_unreadable', 'hash' => null];
        }

        try {
            $data = Json::decode(file_get_contents($packagesJsonPath));
        } catch (\Exception $e) {
            return ['sane' => false, 'reason' => 'packages_json_unreadable', 'hash' => null];
        }

        $providerIncludes = isset($data['provider-includes']) ? $data['provider-includes'] : null;
        if (!is_array($providerIncludes) || count($providerIncludes) !== 1) {
            return ['sane' => false, 'reason' => 'packages_json_malformed', 'hash' => null];
        }

        $pathTemplate = key($providerIncludes);
        $entry = reset($providerIncludes);
        $hash = isset($entry['sha256']) ? $entry['sha256'] : null;
        if (!is_string($hash) || $hash === '') {
            return ['sane' => false, 'reason' => 'packages_json_malformed', 'hash' => null];
        }

        $shardPath = $this->buildPath(strtr($pathTemplate, ['%hash%' => $hash]));
        if (!file_exists($shardPath) || hash_file('sha256', $shardPath) !== $hash) {
            return ['sane' => false, 'reason' => 'provider_latest_shard_missing_or_corrupted', 'hash' => $hash];
        }

        $latestPath = $this->buildHashedPath('provider-latest');
        $latestContent = file_exists($latestPath) ? file_get_contents($latestPath) : false;
        if ($latestContent === false || hash('sha256', $latestContent) !== $hash) {
            return ['sane' => false, 'reason' => 'provider_latest_pointer_diverged', 'hash' => $hash];
        }

        return ['sane' => true, 'reason' => null, 'hash' => $hash];
    }
}
