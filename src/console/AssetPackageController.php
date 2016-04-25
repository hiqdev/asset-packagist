<?php

/*
 * asset-packagist.hiqdev.com
 *
 * @link      http://asset-packagist.hiqdev.com/
 * @package   asset-packagist.hiqdev.com
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\console;

use hiqdev\assetpackagist\models\AssetPackage;
use Yii;

class AssetPackageController extends \yii\console\Controller
{
    public function actionUpdate($type, $name)
    {
        $package = new AssetPackage($type, $name);
        $package->update();
        echo "updated " . $package->getHash() . ' ' . $package->getFullName() . "\n";
    }

    public function actionTest()
    {
        var_dump(Yii::getAlias('@web'));
    }

}
