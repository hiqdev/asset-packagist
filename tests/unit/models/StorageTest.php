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

class StorageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Storage
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new Storage();
    }

    protected function tearDown()
    {
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Storage::class, $this->object);
    }
}
