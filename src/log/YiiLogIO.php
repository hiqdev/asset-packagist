<?php
/**
 * Asset Packagist.
 *
 * @see      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\log;

use Composer\IO\NullIO;
use Yii;
use const YII_DEBUG;

class YiiLogIO extends NullIO {
    
    public function isVerbose() {
        return YII_ENV_TEST;
    }
    
    public function isVeryVerbose() {
        return YII_ENV_DEV;
    }
    
    public function isDebug() {
        return YII_DEBUG;
    }
    
    public function write($messages, $newline = true, $verbosity = self::NORMAL) {
        Yii::trace($messages, __METHOD__);
    }
    
    public function writeError($messages, $newline = true, $verbosity = self::NORMAL) {
        Yii::trace($messages, __METHOD__);
    }

    public function overwrite($messages, $newline = true, $size = 80, $verbosity = self::NORMAL) {
        Yii::trace($messages, __METHOD__);
    }
    
    public function overwriteError($messages, $newline = true, $size = 80, $verbosity = self::NORMAL) {
        Yii::trace($messages, __METHOD__);
    }

    public function log($level, $message, array $context = array()) {
        Yii::trace($message, __METHOD__);
    }

}
