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
use yii\helpers\Json;

class DoController extends \yii\console\Controller
{
    protected $io;
    protected $composer;

    public function init()
    {
        $this->io = new NullIO();
        $this->composer = Factory::create($this->io);
    }

    public function actionUpdatePackage($type, $name)
    {
        $package = AssetPackage::findOrCreate($type, $name);
        echo "updated $package->hash $package->fullName\n";
    }

    public function actionOLD_UpdatePackage($type, $name)
    {
        if ($hash) {
            echo "updated $hash $fullName\n";
        }
    }

    public function actionTest()
    {
        var_dump(Yii::getAlias('@web'));
    }

}
