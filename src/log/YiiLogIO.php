<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\log;

use Composer\IO\NullIO;
use Yii;

class YiiLogIO extends NullIO
{
    public function isVerbose(): bool
    {
        return YII_ENV_TEST;
    }

    public function isVeryVerbose(): bool
    {
        return YII_ENV_DEV;
    }

    public function isDebug(): bool
    {
        return YII_DEBUG;
    }

    public function write($messages, bool $newline = true, int $verbosity = self::NORMAL): void
    {
        Yii::trace($messages, __METHOD__);
    }

    public function writeError($messages, bool $newline = true, int $verbosity = self::NORMAL): void
    {
        Yii::trace($messages, __METHOD__);
    }

    public function overwrite($messages, bool $newline = true, ?int $size = null, int $verbosity = self::NORMAL): void
    {
        Yii::trace($messages, __METHOD__);
    }

    public function overwriteError($messages, bool $newline = true, ?int $size = null, int $verbosity = self::NORMAL): void
    {
        Yii::trace($messages, __METHOD__);
    }

    public function log($level, $message, array $context = []): void
    {
        Yii::trace($message, __METHOD__);
    }
}
