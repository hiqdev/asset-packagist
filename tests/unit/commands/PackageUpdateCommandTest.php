<?php

namespace hiqdev\assetpackagist\tests\unit\commands;

use hiqdev\assetpackagist\commands\PackageUpdateCommand;
use hiqdev\assetpackagist\exceptions\CorruptedPackageException;
use hiqdev\assetpackagist\exceptions\PackageNotExistsException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PackageUpdateCommandTest extends TestCase
{
    #[DataProvider('failureMessages')]
    public function testClassifiesUpdateFailures($message, $expected)
    {
        $this->assertSame($expected, PackageUpdateCommand::permanentProblemClass($message));
    }

    public function testDetectsInvalidNames()
    {
        $npm405 = 'The "https://registry.npmjs.org/@a%2Fb-c%2Fd-file" file could not be downloaded (HTTP/2 405 ):' . "\n"
            . '{"code":"MethodNotAllowedError","message":"GET is not allowed"}';
        $this->assertTrue(PackageUpdateCommand::isInvalidName($npm405));
        $this->assertFalse(PackageUpdateCommand::isInvalidName('The "https://registry.npmjs.org/x" file could not be downloaded (HTTP/2 404 )'));
        $this->assertFalse(PackageUpdateCommand::isInvalidName('The "https://registry.npmjs.org/x" file could not be downloaded (HTTP/2 405 )'));
        $this->assertFalse(PackageUpdateCommand::isInvalidName(str_replace('registry.npmjs.org', 'example.com', $npm405)));
    }

    public function testDetectsGonePackages()
    {
        $this->assertTrue(PackageUpdateCommand::isGone('Package "x" was unpublished from the npm registry'));
        $this->assertTrue(PackageUpdateCommand::isGone('The "https://registry.npmjs.org/a-b-file" file could not be downloaded (HTTP/2 405 ):' . "\n" . '{"code":"MethodNotAllowedError"}'));
        // a 404 still avoids a recorded package, but does not record an unknown one
        $this->assertFalse(PackageUpdateCommand::isGone('The "https://registry.npmjs.org/x" file could not be downloaded (HTTP/2 404 )'));
    }

    public static function failureMessages()
    {
        return [
            'composer 2 registry 404' => [
                'The "https://registry.bower.io/packages/double-scroll" file could not be downloaded (HTTP/2 404 )',
                PackageNotExistsException::class,
            ],
            'composer 1 registry 404' => [
                'The "https://registry.bower.io/packages/x" file could not be downloaded (HTTP/1.1 404 Not Found)',
                PackageNotExistsException::class,
            ],
            'composer 2 npm invalid name' => [
                'The "https://registry.npmjs.org/@dfinity%2Fagent-dfinity%2Fidentity-provider-file" file could not be downloaded (HTTP/2 405 ):' . "\n" . '{"code":"MethodNotAllowedError","message":"GET is not allowed"}',
                PackageNotExistsException::class,
            ],
            'npm unpublished stub' => [
                'Package "tinyphp-bootstrap" was unpublished from the npm registry at 2026-11-05T14:02:58.233Z',
                PackageNotExistsException::class,
            ],
            '405 from another host is temporary' => [
                'The "https://registry.bower.io/packages/x" file could not be downloaded (HTTP/2 405 )',
                null,
            ],
            'server error is temporary' => [
                'The "https://registry.npmjs.org/x" file could not be downloaded (HTTP/2 503 )',
                null,
            ],
            'marker at the start of the message' => [
                'No valid bower.json was found in any branch or tag of https://github.com/a/b.git',
                CorruptedPackageException::class,
            ],
            'unknown failure is temporary' => [
                'Invalid stability string "bridge", expected one of stable, RC, beta, alpha or dev',
                null,
            ],
        ];
    }
}
