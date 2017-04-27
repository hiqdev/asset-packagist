<?php
/**
 * Asset Packagist.
 *
 * @see      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\console;

use hiqdev\assetpackagist\commands\PackageUpdateCommand;
use hiqdev\assetpackagist\components\StorageInterface;
use hiqdev\assetpackagist\models\AssetPackage;
use hiqdev\assetpackagist\repositories\PackageRepository;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Provides maintenance actions for the asset-packagist service.
 */
class MaintenanceController extends Controller
{
    /**
     * @var StorageInterface
     */
    protected $packageStorage;

    /**
     * @var PackageRepository
     */
    protected $packageRepository;

    /**
     * MaintenanceController constructor.
     * @param StorageInterface $packageStorage
     * @param PackageRepository $packageRepository
     * {@inheritdoc}
     */
    public function __construct($id, $module, StorageInterface $packageStorage, PackageRepository $packageRepository, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->packageStorage = $packageStorage;
        $this->packageRepository = $packageRepository;
    }

    /**
     * Synchronizes file system packages to the database.
     */
    public function actionSyncToDb()
    {
        $packages = $this->packageStorage->listPackages();

        foreach ($packages as $name => $data) {
            $message = "Package %N$name%n ";
            $package = AssetPackage::fromFullName($name);
            $package->load();

            $message .= $this->packageRepository->exists($package)
                ? 'already exists. %BUpdated.%n'
                : 'does not exist. %GCreated.%n';

            $this->packageRepository->save($package);

            $this->stdout(Console::renderColoredString($message . "\n"));
        }
    }

    /**
     * Updates expired packages.
     */
    public function actionUpdateExpired()
    {
        $packages = $this->packageRepository->getExpiredForUpdate();

        foreach ($packages as $package) {
            $package->load();
            Yii::$app->queue->push(Yii::createObject(PackageUpdateCommand::class, [$package]));

            $message = 'Package %N' . $package->getFullName() . '%n';
            $message .= ' was updated ' . Yii::$app->formatter->asRelativeTime($package->getUpdateTime());
            $message .= ". %GAdded to queue for update%n\n";
            $this->stdout(Console::renderColoredString($message));
        }
    }
}
