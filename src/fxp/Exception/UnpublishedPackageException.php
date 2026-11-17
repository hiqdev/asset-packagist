<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\fxp\Exception;

/**
 * The registry still knows the package, but all of its versions were unpublished.
 */
class UnpublishedPackageException extends \RuntimeException implements ExceptionInterface
{
    /**
     * Part of every message, so that a failure can be recognised from its message alone.
     */
    const MARKER = 'was unpublished from the npm registry';

    /**
     * @param string $packageName
     * @param string|null $time when it was unpublished, as the registry reports it
     * @return static
     */
    public static function create($packageName, $time = null)
    {
        return new static(sprintf('Package "%s" %s', $packageName, self::MARKER) . ($time ? " at $time" : ''));
    }
}
