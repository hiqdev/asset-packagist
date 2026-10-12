<?php

namespace hiqdev\assetpackagist\tests\unit\registry;

use Composer\IO\NullIO;
use hiqdev\assetpackagist\fxp\Repository\VcsPackageFilter;
use hiqdev\assetpackagist\registry\RegistryFactory;
use PHPUnit\Framework\TestCase;

class RegistryFactoryTest extends TestCase
{
    private $cwd;
    private $dir;

    protected function setUp(): void
    {
        $this->cwd = getcwd();
        $this->dir = sys_get_temp_dir() . '/registry-factory-' . uniqid();
        mkdir($this->dir);
    }

    protected function tearDown(): void
    {
        chdir($this->cwd);
        rmdir($this->dir);
    }

    public function testInitsWithoutComposerJsonInTheWorkingDirectory()
    {
        // The web front controller runs in the web root, which has no composer.json
        chdir($this->dir);

        $factory = new RegistryFactory(['io' => new NullIO()]);

        $this->assertInstanceOf(VcsPackageFilter::class, $factory->packageFilter);
        $this->assertSame(['.', '..'], scandir($this->dir));
    }
}
