<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\tests\unit\models;

use hiqdev\assetpackagist\components\Storage;
use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Json;

class StorageProviderMapTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Storage
     */
    protected $object;

    /**
     * @var string
     */
    protected $storageDir;

    /**
     * @var string[] names passed to the mutex, prefixed with `acquire:` or `release:`
     */
    protected $mutexCalls = [];

    protected function setUp(): void
    {
        $this->storageDir = sys_get_temp_dir() . '/asset-packagist-storage-test-' . uniqid();
        mkdir($this->storageDir, 0777, true);
        Yii::setAlias('@storage', $this->storageDir);

        Yii::$app = new class() {
            public $mutex;
        };
        $calls = &$this->mutexCalls;
        Yii::$app->mutex = new class($calls) {
            private $calls;

            public function __construct(&$calls)
            {
                $this->calls = &$calls;
            }

            public function acquire($name, $timeout = 0)
            {
                $this->calls[] = 'acquire:' . $name;

                return true;
            }

            public function release($name)
            {
                $this->calls[] = 'release:' . $name;

                return true;
            }
        };

        $this->object = new Storage();
    }

    protected function tearDown(): void
    {
        $this->removeDir($this->storageDir);
    }

    protected function removeDir($dir)
    {
        if (!is_dir($dir)) {
            return;
        }
        foreach (scandir($dir) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $path = $dir . '/' . $entry;
            is_dir($path) ? $this->removeDir($path) : unlink($path);
        }
        rmdir($dir);
    }

    protected function writeFixturePackage($name, $version)
    {
        $package = new class('npm', $name) extends AssetPackage {
            public $fixtureReleases;

            public function getReleases()
            {
                return $this->fixtureReleases;
            }
        };
        $package->fixtureReleases = [
            $version => ['name' => $package->getNormalName(), 'version' => $version],
        ];

        return $this->object->writePackage($package);
    }

    protected function providerLatestPath()
    {
        return $this->storageDir . '/p/provider-latest/latest.json';
    }

    protected function liveProviderHash()
    {
        return hash_file('sha256', $this->providerLatestPath());
    }

    public function testWriteProviderLatestSkipsAnUnchangedPackage()
    {
        $this->writeFixturePackage('first', '1.0.0');
        $hash = $this->liveProviderHash();

        $this->mutexCalls = [];
        $this->writeFixturePackage('first', '1.0.0');
        $this->assertNotContains('acquire:lock', $this->mutexCalls);
        $this->assertSame($hash, $this->liveProviderHash());

        $this->writeFixturePackage('first', '2.0.0');
        $this->assertContains('acquire:lock', $this->mutexCalls);
        $this->assertNotSame($hash, $this->liveProviderHash());
        $this->assertTrue($this->object->checkProviderLatestIsSane()['sane']);
    }

    public function testWriteProviderLatestReleasesTheLockWhenTheMapIsUnreadable()
    {
        mkdir(dirname($this->providerLatestPath()), 0777, true);
        file_put_contents($this->providerLatestPath(), '{broken');

        try {
            $this->writeFixturePackage('first', '1.0.0');
            $this->fail('An unreadable provider map must not be overwritten');
        } catch (InvalidArgumentException $e) {
        }

        $this->assertContains('release:lock', $this->mutexCalls);
        $this->assertSame('{broken', file_get_contents($this->providerLatestPath()));
    }

    public function testRemoveUnnormalizedProviders()
    {
        $this->writeFixturePackage('first', '1.0.0');
        $data = Json::decode(file_get_contents($this->providerLatestPath()));
        $data['providers']['bower-asset/Chart.js'] = ['sha256' => str_repeat('a', 64)];
        $data['providers']['npm-asset/Second'] = ['sha256' => str_repeat('b', 64)];
        file_put_contents($this->providerLatestPath(), Json::encode($data));

        $removed = $this->object->removeUnnormalizedProviders();

        $this->assertSame(['bower-asset/Chart.js', 'npm-asset/Second'], $removed);
        $providers = Json::decode(file_get_contents($this->providerLatestPath()))['providers'];
        $this->assertSame(['npm-asset/first'], array_keys($providers));
        $this->assertTrue($this->object->checkProviderLatestIsSane()['sane']);
    }
}
