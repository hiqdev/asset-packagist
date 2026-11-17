<?php

namespace hiqdev\assetpackagist\tests\unit\fxp;

use hiqdev\assetpackagist\fxp\Exception\UnpublishedPackageException;
use hiqdev\assetpackagist\fxp\Repository\NpmRepository;
use PHPUnit\Framework\TestCase;

class NpmRepositoryTest extends TestCase
{
    public function testUnpublishedStubIsRejected()
    {
        // The shape npm serves for an unscoped package after all of its versions were unpublished
        $stub = [
            '_id' => 'tinyphp-bootstrap',
            'name' => 'tinyphp-bootstrap',
            'time' => [
                'created' => '2021-05-24T08:29:33.153Z',
                'modified' => '2026-11-05T14:02:58.233Z',
                '1.0.0' => '2021-05-20T04:17:04.263Z',
                '1.0.1' => '2021-05-24T08:29:33.332Z',
                'unpublished' => ['time' => '2026-11-05T14:02:58.233Z', 'versions' => ['1.0.1']],
            ],
        ];

        $this->expectException(UnpublishedPackageException::class);
        $this->expectExceptionMessage('Package "tinyphp-bootstrap" was unpublished from the npm registry at 2026-11-05T14:02:58.233Z');
        $this->assertPackageIsPublished($stub, 'tinyphp-bootstrap');
    }

    public function testUnpublishedStubWithoutTimeIsRejected()
    {
        $this->expectException(UnpublishedPackageException::class);
        $this->expectExceptionMessage('Package "x" was unpublished from the npm registry');
        $this->assertPackageIsPublished(['name' => 'x', 'time' => ['unpublished' => true]], 'x');
    }

    public function testPublishedPackagesAreAccepted()
    {
        // republished after an unpublish: versions win over the leftover marker
        $this->assertPackageIsPublished([
            'versions' => ['2.0.0' => ['name' => 'x', 'version' => '2.0.0']],
            'time' => ['unpublished' => ['time' => '2026-01-01T00:00:00.000Z']],
        ], 'x');
        // no versions, but not unpublished either: leave it to the empty-release-set guard
        $this->assertPackageIsPublished(['name' => 'x', 'time' => ['created' => '2026-01-01T00:00:00.000Z']], 'x');
        $this->assertPackageIsPublished(['name' => 'x'], 'x');

        $this->addToAssertionCount(1);
    }

    private function assertPackageIsPublished(array $data, $packageName)
    {
        $repository = (new \ReflectionClass(NpmRepository::class))->newInstanceWithoutConstructor();
        (new \ReflectionMethod(NpmRepository::class, 'assertPackageIsPublished'))->invoke($repository, $data, $packageName);
    }
}
