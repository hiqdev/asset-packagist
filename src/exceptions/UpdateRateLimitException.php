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

use yii\base\Exception;

class UpdateRateLimitException extends Exception
{
    public function getName()
    {
        return 'The package can not be update too often';
    }
}
