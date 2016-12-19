<?php

namespace hiqdev\assetpackagist\exceptions;

use Exception;
use hiqdev\assetpackagist\models\AssetPackage;

class AssetFileStorageException extends \Exception
{
    /**
     * @var AssetPackage
     */
    private $package;

    public function __construct($message = "", AssetPackage $package = null, $code = 0, Exception $previous = null)
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
