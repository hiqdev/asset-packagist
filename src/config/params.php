<?php

/*
 * Asset Packagist
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

$params = [
    'logo-text' => 'Asset Packagist',
    'cookieValidationKey' => '345sdfsadf',
];

$local = __DIR__ . '/params-local.php';

return array_merge(
    $params,
    file_exists($local) ? require $local : []
);
