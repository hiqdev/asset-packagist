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
