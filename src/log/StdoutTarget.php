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

use yii\helpers\Console;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\log\Target;

class StdoutTarget extends Target
{
    /**
     * Exports log [[messages]] to a specific destination.
     * Child classes must implement this method.
     */
    public function export()
    {
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            if (!is_string($text)) {
                // exceptions may not be serializable if in the call stack somewhere is a Closure
                if ($text instanceof \Throwable || $text instanceof \Exception) {
                    $text = (string) $text;
                } else {
                    $text = VarDumper::export($text);
                }
            }

            $string = "[$level][$category] $text";

            if ($level === Logger::LEVEL_ERROR) {
                Console::stderr($string);
            } else {
                Console::stdout($string);
            }
        }
    }
}
