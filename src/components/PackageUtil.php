<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\components;

use Composer\Semver\Comparator;
use Composer\Semver\VersionParser;

class PackageUtil
{
    public static function sort(&$releases)
    {
        uasort($releases, function ($a, $b) {
            if ($a['version'] === $b['version']) {
                return 0;
            }

            $stability_a = VersionParser::parseStability($a['version_normalized']);
            $stability_b = VersionParser::parseStability($b['version_normalized']);

            // DEV versions to LAST
            if ($stability_a === 'dev' && $stability_b !== 'dev') {
                return 1;
            } elseif ($stability_a !== 'dev' && $stability_b === 'dev') {
                return -1;
            }

            if (Comparator::lessThan($a['version_normalized'], $b['version_normalized'])) {
                return 1;
            }

            return -1;
        });
    }
}
