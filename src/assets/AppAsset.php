<?php

/*
 * Asset Packagist
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@hiqdev/assetpackagist/assets';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
