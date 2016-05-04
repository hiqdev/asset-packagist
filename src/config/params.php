<?php

/*
 * asset-packagist.hiqdev.com
 *
 * @link      http://asset-packagist.hiqdev.com/
 * @package   asset-packagist.hiqdev.com
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

