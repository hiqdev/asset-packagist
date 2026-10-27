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

use Composer\DependencyResolver\Pool;
use Composer\Package\CompletePackage;
use hiqdev\assetpackagist\models\AssetPackage;

class AssetPackageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var AssetPackage
     */
    protected $object;

    protected $type = 'bower';
    protected $name = 'jquery';

    protected function setUp(): void
    {
        $this->object = new AssetPackage($this->type, $this->name);
    }

    protected function tearDown(): void
    {
    }

    public function testGetFullName()
    {
        $this->assertSame($this->type . '-asset/' . $this->name, $this->object->getFullName());
    }

    public function testGetRegistryNameUnscoped()
    {
        $this->assertSame($this->name, $this->object->getRegistryName());
    }

    public function testGetRegistryNameScoped()
    {
        $package = new AssetPackage('npm', 'ngneat--hot-toast');
        $this->assertSame('@ngneat/hot-toast', $package->getRegistryName());
    }

    public function testNormalizeAndDenormalizeScopedNameRoundTrip()
    {
        $this->assertSame(
            '@ngneat/hot-toast',
            AssetPackage::denormalizeScopedName(AssetPackage::normalizeScopedName('@ngneat/hot-toast'))
        );
    }

    public function testPrepareReleasesFindsMixedCaseName()
    {
        $release = new CompletePackage('bower-asset/jquery.marquee', '1.6.1.0', '1.6.1');
        $release->setSourceType('git');
        $release->setSourceUrl('https://github.com/aamirafridi/jQuery.Marquee.git');
        $release->setSourceReference('abc123');

        $package = new class('bower', 'JQuery.Marquee') extends AssetPackage {
            public function prepareUid($version)
            {
                return 1;
            }
        };
        $releases = $package->prepareReleases(new Pool([$release]));

        $this->assertSame(['1.6.1'], array_keys($releases));
        $this->assertSame('bower-asset/jquery.marquee', $releases['1.6.1']['name']);
    }

    public function testPrepareReleasesKeepsDistShasum()
    {
        $withSum = new CompletePackage('npm-asset/cropper', '4.1.0.0', '4.1.0');
        $withSum->setDistType('tar');
        $withSum->setDistUrl('https://registry.npmjs.org/cropper/-/cropper-4.1.0.tgz');
        $withSum->setDistSha1Checksum('3c2faaa78f730a3c71814cee61e17c7a674b943f');
        $withoutSum = new CompletePackage('npm-asset/cropper', '4.0.0.0', '4.0.0');
        $withoutSum->setDistType('tar');
        $withoutSum->setDistUrl('https://registry.npmjs.org/cropper/-/cropper-4.0.0.tgz');

        $package = new class('npm', 'cropper') extends AssetPackage {
            public function prepareUid($version)
            {
                return 1;
            }
        };
        $releases = $package->prepareReleases(new Pool([$withSum, $withoutSum]));

        $this->assertSame('3c2faaa78f730a3c71814cee61e17c7a674b943f', $releases['4.1.0']['dist']['shasum']);
        $this->assertArrayNotHasKey('shasum', $releases['4.0.0']['dist']);
    }
}
