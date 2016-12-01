<?php

namespace hiqdev\assetpackagist\components;

use hiqdev\assetpackagist\models\AssetPackage;

/**
 * Interface StorageInterface
 *
 * @package hiqdev\assetpackagist\components
 */
interface StorageInterface
{
    /**
     * Reads the $package information from the storage.
     *
     * @param AssetPackage $package
     * @return array|null array of two elements:
     *  0 - string sha256 hash of the package
     *  1 - array[] releases
     *
     * Returns null, when package does not exist.
     */
    public function readPackage(AssetPackage $package); // TODO: use interface instead

    /**
     * Writes the $package to the storage
     *
     * @param AssetPackage $package
     * @return string hash or the package on success
     */
    public function writePackage(AssetPackage $package); // TODO: use interface instead

    // TODO: PHPDoc
    public function getNextId();

    // TODO: PHPDoc
    public function listPackages();
}
