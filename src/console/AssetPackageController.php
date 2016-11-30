<?php

/*
 * Asset Packagist
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\console;

use hiqdev\assetpackagist\commands\CollectDependenciesCommand;
use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\helpers\Console;

class AssetPackageController extends \yii\console\Controller
{
    /**
     * @param string $type the package type. Can be either `bower` or `npm`
     * @param string $name the package name
     * @return boolean Whether the update was successful
     */
    public function actionUpdate($type, $name)
    {
        try {
            $package = new AssetPackage($type, $name);
            $package->update();
            echo 'updated ' . $package->getHash() . ' ' . $package->getFullName() . "\n";

            Yii::$app->queue->push('package', new CollectDependenciesCommand($package));

            return true;
        } catch (\Exception $e) {
            echo Console::renderColoredString("%Rfailed%N $type/$name:%n {$e->getMessage()}\n");

            return false;
        }
    }

    public function actionUpdateList($file = STDIN)
    {
        $handler = is_resource($file) ? $file : fopen($file, 'r');

        $errorPackages = [];

        while ($line = fgets($handler)) {
            list($full) = preg_split('/\s+/', trim($line));
            list($type, $name) = AssetPackage::splitFullName($full);
            if (!$this->actionUpdate($type, $name)) {
                $errorPackages[] = $full;
            }
        }

        if (!is_resource($file)) {
            fclose($handler);
        }

        if (!empty($errorPackages)) {
            echo Console::renderColoredString("%RThe following packages were not updated due to unrecoverable errors:%n\n");
            echo implode("\n", $errorPackages);
        }
        echo "\n";
    }

    public function actionUpdateAll()
    {
        $this->actionUpdateList(Yii::getAlias('@hiqdev/assetpackagist/config/packages.list'));
    }

    public function actionList()
    {
        $packages = Yii::$app->get('packageStorage')->listPackages();
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
