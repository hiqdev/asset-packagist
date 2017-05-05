<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\exceptions;

use Exception;
use hiqdev\assetpackagist\models\AssetPackage;

class AssetFileStorageException extends \Exception
{
    /**
     * @var AssetPackage
     */
    private $package;

    public function __construct($message = '', AssetPackage $package = null, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->package = $package;
    }

    /**
     * @return AssetPackage
     */
    public function getPackage()
    {
        return $this->package;
    }
}
