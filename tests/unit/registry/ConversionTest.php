<?php

namespace hiqdev\assetpackagist\tests\unit\registry;

use hiqdev\assetpackagist\fxp\Converter\BowerPackageConverter;
use hiqdev\assetpackagist\fxp\Converter\NpmPackageConverter;
use hiqdev\assetpackagist\fxp\Type\BowerAssetType;
use hiqdev\assetpackagist\fxp\Type\NpmAssetType;
use yii\helpers\Json;

class ConversionTest extends \PHPUnit\Framework\TestCase
{
    public function testConvertsScopedNpmMetadataToStableComposerJson()
    {
        $converted = (new NpmPackageConverter(new NpmAssetType()))->convert([
            'name' => '@scope/widget',
            'version' => '1.2.3',
            'description' => 'fixture package',
            'dependencies' => ['left-pad' => '^1.3.0'],
            'dist' => ['tarball' => 'https://registry.example/widget-1.2.3.tgz', 'shasum' => 'deadbeef'],
        ]);

        $this->assertSame('npm-asset/scope--widget', $converted['name']);
        $this->assertSame('npm-asset-library', $converted['type']);
        $this->assertSame('>=1.3.0,<2.0.0', $converted['require']['npm-asset/left-pad']);
        $this->assertSame(
            '{"name":"npm-asset/scope--widget","type":"npm-asset-library","version":"1.2.3","description":"fixture package","bin":[],"dist":{"type":"tar","url":"https://registry.example/widget-1.2.3.tgz","shasum":"deadbeef"},"require":{"npm-asset/left-pad":">=1.3.0,<2.0.0"}}',
            Json::encode($converted)
        );
    }

    public function testConvertsBowerDependenciesAndMetadata()
    {
        $converted = (new BowerPackageConverter(new BowerAssetType()))->convert([
            'name' => 'widget',
            'version' => '2.0.0',
            'main' => ['dist/widget.js'],
            'dependencies' => ['jquery' => '~3.7.0'],
        ]);

        $this->assertSame('bower-asset/widget', $converted['name']);
        $this->assertSame('~3.7.0', $converted['require']['bower-asset/jquery']);
        $this->assertSame(['bower-asset-main' => ['dist/widget.js']], $converted['extra']);
    }

    public function testConvertsBowerUrlDependenciesWithoutAliasingTheUrl()
    {
        $vcsRepos = [];
        $converted = (new BowerPackageConverter(new BowerAssetType()))->convert([
            'name' => 'widget',
            'version' => '2.0.0',
            'dependencies' => [
                'shorthand' => 'owner/shorthand#1.2.3',
                'full' => 'https://github.com/owner/full.git#1.2.3',
            ],
        ], $vcsRepos);

        $this->assertSame('1.2.3', $converted['require']['bower-asset/shorthand']);
        $this->assertSame('1.2.3', $converted['require']['bower-asset/full']);
        $this->assertSame([
            ['type' => 'bower-vcs', 'url' => 'https://github.com/owner/shorthand.git', 'name' => 'bower-asset/shorthand'],
            ['type' => 'bower-vcs', 'url' => 'https://github.com/owner/full.git', 'name' => 'bower-asset/full'],
        ], $vcsRepos);
    }
}
