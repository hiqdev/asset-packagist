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
use hiqdev\assetpackagist\models\Storage;
use Yii;

class AssetPackageController extends \yii\console\Controller
{
    public function actionUpdate($type, $name)
    {
        $package = new AssetPackage($type, $name);
        $package->update();
        echo "updated " . $package->getHash() . ' ' . $package->getFullName() . "\n";
    }

    public function actionUpdateList()
    {
        while ($line = fgets(STDIN)) {
            list($full,) = preg_split('/\s+/', trim($line));
            list($type, $name) = AssetPackage::splitFullName($full);
            $this->actionUpdate($type, $name);
        }
    }

    public function actionList()
    {
        $packages = Storage::getInstance()->listPackages();
        ksort($packages);
        foreach ($packages as $name => $data) {
            echo "$name\n";
        }
    }

    public function actionTest()
    {
        $dir = Yii::getAlias('@storage');
        $msg = file_exists($dir) ? 'exists' : 'DOES NOT EXIST';
        echo  "$dir - $msg\n";
    }

}
