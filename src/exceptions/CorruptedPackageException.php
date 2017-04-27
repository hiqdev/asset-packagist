<?php
/**
 * Asset Packagist.
 *
 * @see      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\exceptions;

use yii\base\Exception;

class CorruptedPackageException extends Exception implements PermanentProblemExceptionInterface
{
    public function getName()
    {
        return 'The package is corrupted and can not be processed';
    }
}
