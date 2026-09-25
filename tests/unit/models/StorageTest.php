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
use hiqdev\assetpackagist\exceptions\AssetFileStorageException;
use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\helpers\Json;

class StorageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Storage
     */
    protected $object;

    /**
     * @var string
     */
    protected $storageDir;

    protected function setUp(): void
    {
        $this->storageDir = sys_get_temp_dir() . '/asset-packagist-storage-test-' . uniqid();
        mkdir($this->storageDir, 0777, true);
        Yii::setAlias('@storage', $this->storageDir);

        Yii::$app = new class() {
            public $mutex;
        };
        Yii::$app->mutex = new class() {
            public function acquire($name, $timeout = 0)
            {
                return true;
            }

            public function release($name)
            {
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

    protected function writeShard($relativePath, $content)
    {
        $path = $this->storageDir . '/' . $relativePath;
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }
        file_put_contents($path, $content);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Storage::class, $this->object);
    }

    public function testCheckPackageIsSaneWhenEverythingMatches()
    {
        $package = new AssetPackage('bower', 'jquery');
        $json = Json::encode(['packages' => ['bower-asset/jquery' => []]]);
        $hash = hash('sha256', $json);

        $this->writeShard('p/bower-asset/jquery/latest.json', $json);
        $this->writeShard("p/bower-asset/jquery/{$hash}.json", $json);

        $result = $this->object->checkPackageIsSane($package);

        $this->assertTrue($result['sane']);
        $this->assertFalse($result['activeCorrupted']);
        $this->assertFalse($result['activeMissing']);
        $this->assertSame(0, $result['orphanedRemoved']);
    }

    public function testCheckPackageIsSaneDetectsActiveShardCorruption()
    {
        $package = new AssetPackage('bower', 'jquery');
        $json = Json::encode(['packages' => ['bower-asset/jquery' => []]]);
        $hash = hash('sha256', $json);

        $this->writeShard('p/bower-asset/jquery/latest.json', $json);
        $this->writeShard("p/bower-asset/jquery/{$hash}.json", $json . 'CORRUPTED');

        $result = $this->object->checkPackageIsSane($package);

        $this->assertFalse($result['sane']);
        $this->assertTrue($result['activeCorrupted']);
        $this->assertFalse($result['activeMissing']);
        $this->assertSame(0, $result['orphanedRemoved']);
        $this->assertFileDoesNotExist($this->storageDir . "/p/bower-asset/jquery/{$hash}.json");
    }

    public function testCheckPackageIsSaneDetectsActiveShardMissing()
    {
        $package = new AssetPackage('bower', 'jquery');
        $json = Json::encode(['packages' => ['bower-asset/jquery' => []]]);

        $this->writeShard('p/bower-asset/jquery/latest.json', $json);
        // deliberately never create the {hash}.json shard latest.json points at

        $result = $this->object->checkPackageIsSane($package);

        $this->assertFalse($result['sane']);
        $this->assertFalse($result['activeCorrupted']);
        $this->assertTrue($result['activeMissing']);
        $this->assertSame(0, $result['orphanedRemoved']);
    }

    public function testCheckPackageIsSaneClassifiesOrphanedCorruptionSeparately()
    {
        $package = new AssetPackage('bower', 'jquery');
        $json = Json::encode(['packages' => ['bower-asset/jquery' => []]]);
        $hash = hash('sha256', $json);

        $this->writeShard('p/bower-asset/jquery/latest.json', $json);
        $this->writeShard("p/bower-asset/jquery/{$hash}.json", $json);
        // an unrelated historical shard whose content doesn't match its own filename
        $this->writeShard('p/bower-asset/jquery/deadbeefdeadbeefdeadbeefdeadbeefdeadbeefdeadbeefdeadbeefdeadbeef.json', 'garbage');

        $result = $this->object->checkPackageIsSane($package);

        $this->assertFalse($result['sane']);
        $this->assertFalse($result['activeCorrupted']);
        $this->assertFalse($result['activeMissing']);
        $this->assertSame(1, $result['orphanedRemoved']);
        $this->assertFileDoesNotExist(
            $this->storageDir . '/p/bower-asset/jquery/deadbeefdeadbeefdeadbeefdeadbeefdeadbeefdeadbeefdeadbeefdeadbeef.json'
        );
    }

    public function testCheckPackageIsSaneDetectsUnparsableLatest()
    {
        $package = new AssetPackage('bower', 'jquery');

        $this->writeShard('p/bower-asset/jquery/latest.json', 'not { valid json');

        $result = $this->object->checkPackageIsSane($package);

        $this->assertFalse($result['sane']);
        $this->assertTrue($result['activeCorrupted']);
    }

    public function testCheckProviderLatestIsSaneWhenEverythingMatches()
    {
        $json = Json::encode(['providers' => ['bower-asset/jquery' => ['sha256' => 'x']]]);
        $hash = hash('sha256', $json);

        $this->writeShard("p/provider-latest/{$hash}.json", $json);
        $this->writeShard('p/provider-latest/latest.json', $json);
        $this->writePackagesJsonFixture($hash);

        $result = $this->object->checkProviderLatestIsSane();

        $this->assertTrue($result['sane']);
        $this->assertSame($hash, $result['hash']);
    }

    public function testCheckProviderLatestIsSaneDetectsMissingPackagesJson()
    {
        $result = $this->object->checkProviderLatestIsSane();

        $this->assertFalse($result['sane']);
        $this->assertSame('packages_json_unreadable', $result['reason']);
    }

    public function testCheckProviderLatestIsSaneDetectsCorruptedLiveShard()
    {
        $json = Json::encode(['providers' => ['bower-asset/jquery' => ['sha256' => 'x']]]);
        $hash = hash('sha256', $json);

        $this->writeShard("p/provider-latest/{$hash}.json", $json . 'CORRUPTED');
        $this->writePackagesJsonFixture($hash);

        $result = $this->object->checkProviderLatestIsSane();

        $this->assertFalse($result['sane']);
        $this->assertSame('provider_latest_shard_missing_or_corrupted', $result['reason']);
    }

    public function testCheckProviderLatestIsSaneDetectsDivergedPointer()
    {
        $json = Json::encode(['providers' => ['bower-asset/jquery' => ['sha256' => 'x']]]);
        $hash = hash('sha256', $json);

        $this->writeShard("p/provider-latest/{$hash}.json", $json);
        $this->writeShard('p/provider-latest/latest.json', $json . 'DIVERGED');
        $this->writePackagesJsonFixture($hash);

        $result = $this->object->checkProviderLatestIsSane();

        $this->assertFalse($result['sane']);
        $this->assertSame('provider_latest_pointer_diverged', $result['reason']);
    }

    protected function writePackagesJsonFixture($hash)
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
        file_put_contents($this->storageDir . '/packages.json', Json::encode($data));
    }

    public function testWritePackageDoesNotResurrectAnAlreadyCorruptedShard()
    {
        $package = new AssetPackage('bower', 'jquery');
        $json = Json::encode(['packages' => ['bower-asset/jquery' => []]]);
        $hash = hash('sha256', $json);

        // simulate a pre-existing torn/corrupted shard sitting exactly at the path
        // this write is about to target
        $this->writeShard("p/bower-asset/jquery/{$hash}.json", $json . 'CORRUPTED');

        $this->object->writePackage($package);

        $this->assertSame(
            $json,
            file_get_contents($this->storageDir . "/p/bower-asset/jquery/{$hash}.json")
        );
    }

    public function testWritePackageRefusesToBlankExistingReleases()
    {
        $existingJson = Json::encode([
            'packages' => [
                'bower-asset/jquery' => [
                    '3.6.0' => ['name' => 'bower-asset/jquery', 'version' => '3.6.0'],
                ],
            ],
        ]);
        $existingHash = hash('sha256', $existingJson);

        $this->writeShard('p/bower-asset/jquery/latest.json', $existingJson);
        $this->writeShard("p/bower-asset/jquery/{$existingHash}.json", $existingJson);

        // freshly constructed, never loaded/updated -> getReleases() is empty,
        // simulating a fetch that resolved to nothing (case mismatch, registry hiccup, ...)
        $package = new AssetPackage('bower', 'jquery');

        $this->expectException(AssetFileStorageException::class);

        try {
            $this->object->writePackage($package);
        } finally {
            $this->assertSame(
                $existingJson,
                file_get_contents($this->storageDir . '/p/bower-asset/jquery/latest.json'),
                'existing releases must survive an empty-release write attempt'
            );
        }
    }

    public function testWritePackageAllowsEmptyReleasesWhenNothingExistedBefore()
    {
        $package = new AssetPackage('bower', 'new-package');

        $this->object->writePackage($package);

        $expectedJson = Json::encode(['packages' => ['bower-asset/new-package' => []]]);
        $this->assertSame(
            $expectedJson,
            file_get_contents($this->storageDir . '/p/bower-asset/new-package/latest.json')
        );
    }

    /**
     * @dataProvider assetTypes
     */
    public function testWritePackageKeepsTheCompleteComposerHashChain($type, $name)
    {
        $package = new class($type, $name) extends AssetPackage {
            public $fixtureReleases;

            public function getReleases()
            {
                return $this->fixtureReleases;
            }
        };
        $package->fixtureReleases = [
            '1.0.0' => [
                'uid' => 1000001,
                'name' => $package->getNormalName(),
                'version' => '1.0.0',
                'version_normalized' => '1.0.0.0',
                'type' => $type . '-asset',
                'dist' => ['type' => 'tar', 'url' => 'https://example.test/package.tgz'],
            ],
        ];

        $packageHash = $this->object->writePackage($package);
        $packageJson = file_get_contents($this->storageDir . '/p/' . $package->getNormalName() . '/latest.json');
        $this->assertSame($packageHash, hash('sha256', $packageJson));
        $this->assertSame($packageJson, file_get_contents($this->storageDir . '/p/' . $package->getNormalName() . '/' . $packageHash . '.json'));

        $providerJson = file_get_contents($this->storageDir . '/p/provider-latest/latest.json');
        $providerHash = hash('sha256', $providerJson);
        $this->assertSame($providerJson, file_get_contents($this->storageDir . '/p/provider-latest/' . $providerHash . '.json'));
        $this->assertSame($packageHash, Json::decode($providerJson)['providers'][$package->getNormalName()]['sha256']);
        $this->assertSame(
            $providerHash,
            Json::decode(file_get_contents($this->storageDir . '/packages.json'))['provider-includes']['p/provider-latest/%hash%.json']['sha256']
        );
    }

    public function assetTypes()
    {
        return [
            ['bower', 'fixture-bower'],
            ['npm', 'fixture-npm'],
        ];
    }
}
