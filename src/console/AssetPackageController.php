<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\console;

use hiqdev\assetpackagist\commands\PackageUpdateCommand;
use hiqdev\assetpackagist\models\AssetPackage;
use hiqdev\assetpackagist\repositories\PackageRepository;
use Yii;
use yii\helpers\Console;

class AssetPackageController extends \yii\console\Controller
{
    /**
     * @var PackageRepository
     */
    protected $packageRepository;

    /**
     * MaintenanceController constructor.
     * @param PackageRepository $packageRepository
     * {@inheritdoc}
     */
    public function __construct($id, $module, PackageRepository $packageRepository, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->packageRepository = $packageRepository;
    }

    /**
     * @param string $type the package type. Can be either `bower` or `npm`
     * @param string $name the package name
     * @return boolean Whether the update was successful
     */
    public function actionUpdate($type, $name)
    {
        try {
            $package = new AssetPackage($type, $name);
            Yii::createObject(PackageUpdateCommand::class, [$package])->execute(Yii::$app->queue);
            echo 'updated ' . $package->getHash() . ' ' . $package->getFullName() . "\n";

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

    public function actionAddUpdateCommand($type, $name)
    {
        $package = new AssetPackage($type, $name);
        Yii::$app->queue->push(Yii::createObject(PackageUpdateCommand::class, [$package]));
        echo Console::renderColoredString("%GAdded%N $type/$name%n\n");
    }

    public function actionUpdateAll()
    {
        $this->actionUpdateList(Yii::getAlias('@hiqdev/assetpackagist/config/packages.list'));
    }

    public function actionAvoid($type, $name)
    {
        $package = new AssetPackage($type, $name);
        $this->packageRepository->markAvoided($package);

        echo Console::renderColoredString("Package %N$type/$name%n is %Ravoided%n now\n");
    }

    public function actionList()
    {
        $packages = Yii::$app->get('packageStorage')->listPackages();
        ksort($packages);
        foreach ($packages as $name => $data) {
            echo "$name\n";
        }
    }
}
