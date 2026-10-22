<?php

namespace hiqdev\assetpackagist\tests\unit\fxp;

use Composer\Downloader\TransportException;
use Composer\IO\NullIO;
use Composer\Package\Loader\LoaderInterface;
use Composer\Repository\Vcs\VcsDriverInterface;
use hiqdev\assetpackagist\fxp\Package\LazyPackageInterface;
use hiqdev\assetpackagist\fxp\Package\Loader\LazyAssetPackageLoader;
use hiqdev\assetpackagist\fxp\Type\AssetTypeInterface;
use PHPUnit\Framework\TestCase;

class LazyAssetPackageLoaderTest extends TestCase
{
    public function testFailedFetchIsNotSkipped()
    {
        $loader = $this->createLoader(new TransportException('Could not authenticate against github.com', 401));

        $this->expectException(TransportException::class);
        $loader->load($this->createPackage());
    }

    public function testInvalidVersionIsSkipped()
    {
        $loader = $this->createLoader(new \UnexpectedValueException('Invalid version string'));

        $this->assertFalse($loader->load($this->createPackage()));
    }

    private function createLoader(\Exception $driverException)
    {
        $driver = $this->createStub(VcsDriverInterface::class);
        $driver->method('getComposerInformation')->willThrowException($driverException);
        $assetType = $this->createStub(AssetTypeInterface::class);
        $assetType->method('getFilename')->willReturn('bower.json');

        $loader = new LazyAssetPackageLoader('tag', 'v1.0.0', []);
        $loader->setAssetType($assetType);
        $loader->setLoader($this->createStub(LoaderInterface::class));
        $loader->setDriver($driver);
        $loader->setIO(new NullIO());

        return $loader;
    }

    private function createPackage()
    {
        $package = $this->createStub(LazyPackageInterface::class);
        $package->method('getUniqueName')->willReturn('bower-asset/a-1.0.0.0');
        $package->method('getName')->willReturn('bower-asset/a');
        $package->method('getPrettyVersion')->willReturn('v1.0.0');

        return $package;
    }
}
