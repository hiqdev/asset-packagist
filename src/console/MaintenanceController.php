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
use hiqdev\assetpackagist\components\StorageInterface;
use hiqdev\assetpackagist\models\AssetPackage;
use hiqdev\assetpackagist\repositories\PackageRepository;
use Yii;
use yii\console\Controller;
use yii\db\Query;
use yii\helpers\Console;
use yii\queue\db\Queue as DbQueue;

/**
 * Provides maintenance actions for the asset-packagist service.
 */
class MaintenanceController extends Controller
{
    /**
     * @var int `update-expired` fills the queue up to this many waiting jobs and no further,
     * so a backlog that outlives one run is not enqueued a second time
     */
    public $maxPending = 5000;

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
     * {@inheritdoc}
     */
    public function options($actionID)
    {
        $options = parent::options($actionID);
        if ($actionID === 'update-expired') {
            $options[] = 'maxPending';
        }

        return $options;
    }

    /**
     * Queues expired packages for update, least recently updated first,
     * until the queue holds `maxPending` waiting jobs.
     */
    public function actionUpdateExpired()
    {
        $queue = Yii::$app->queue;
        $pending = $this->countPendingJobs($queue);
        $room = $this->maxPending - $pending;
        if ($room <= 0) {
            $this->stdout("Skipped: $pending jobs are still waiting in the queue (--max-pending={$this->maxPending}).\n");

            return;
        }

        $packages = $this->packageRepository->getExpiredForUpdate($room);
        $queue->priority(10);

        foreach ($packages as $package) {
            $package->load();
            $queue->push(Yii::createObject(PackageUpdateCommand::class, [$package]));
            $package->unload();

            $message = 'Package %N' . $package->getFullName() . '%n';
            $message .= ' was updated ' . Yii::$app->formatter->asRelativeTime($package->getUpdateTime());
            $message .= ". %GAdded to queue for update%n\n";
            $this->stdout(Console::renderColoredString($message));
        }
    }

    /**
     * @param \yii\queue\Queue $queue
     * @return int number of jobs not yet taken by a worker, 0 when the driver cannot tell
     */
    protected function countPendingJobs($queue)
    {
        if (!$queue instanceof DbQueue) {
            return 0;
        }

        return (int) (new Query())
            ->from($queue->tableName)
            ->where(['channel' => $queue->channel, 'reserved_at' => null])
            ->count('*', $queue->db);
    }

    public function actionRegenerateProviderLatest()
    {
        $packages = $this->packageRepository->getAllActive();

        foreach ($packages as $package) {
            $package->load();
            $this->packageStorage->writePackage($package);
            $package->unload();
            $this->stdout("Package {$package->getFullName()} regenerated\n");
        }
    }

    /**
     * Removes provider map entries whose names are not normalized, such as mixed-case
     * names left by old versions. `regenerate-provider-latest` only adds entries, so it
     * can't remove them.
     */
    public function actionRemoveUnnormalizedProviders()
    {
        $removed = $this->packageStorage->removeUnnormalizedProviders();
        foreach ($removed as $name) {
            $this->stdout("Removed $name\n");
        }
        $this->stdout('Removed ' . count($removed) . " provider entries\n");
    }

    public function actionCheckHashes()
    {
        $hasUnresolvedCorruption = false;

        $providerLatestCheck = $this->packageStorage->checkProviderLatestIsSane();
        if (!$providerLatestCheck['sane']) {
            $hasUnresolvedCorruption = true;
            $message = '%RProvider-latest storage is corrupted%n';
            $message .= " (reason: {$providerLatestCheck['reason']}). ";
            $message .= "%GRun `maintenance/regenerate-provider-latest` to repair.%n\n";
            $this->stdout(Console::renderColoredString($message));
        }

        $packages = $this->packageStorage->listPackages();

        $i = 0;
        foreach ($packages as $name => $data) {
            if ($i++ % 10 === 0) { $this->stdout('.'); }
            if ($i % 1000 === 0) { $this->stdout(" [ $i ]\n"); }

            $package = AssetPackage::fromFullName($name);
            $check = $this->packageStorage->checkPackageIsSane($package);
            if ($check['sane']) {
                continue;
            }

            $needsUpdate = $check['activeCorrupted'] || $check['activeMissing'];

            if (!$needsUpdate) {
                $message = "\nPackage %N" . $package->getFullName() . '%n had ';
                $message .= $check['orphanedRemoved'] . " orphaned corrupted shard(s) removed.\n";
                $this->stdout(Console::renderColoredString($message));
                continue;
            }

            if ($this->packageRepository->isAvoided($package)) {
                $hasUnresolvedCorruption = true;
                $message = "\nPackage %R" . $package->getFullName() . '%n is actively corrupted but avoided. ';
                $message .= "%RNo auto-repair - needs manual attention.%n\n";
                $this->stdout(Console::renderColoredString($message));
                continue;
            }

            Yii::$app->queue->push(Yii::createObject(PackageUpdateCommand::class, [$package]));

            $message = "\nPackage %N" . $package->getFullName() . '%n is corrupted. ';
            $message .= "%GAdded to queue for update%n\n";
            $this->stdout(Console::renderColoredString($message));
        }

        return $hasUnresolvedCorruption ? 1 : 0;
    }
}
