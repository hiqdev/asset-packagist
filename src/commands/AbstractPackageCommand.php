<?php

namespace hiqdev\assetpackagist\commands;

use hiqdev\assetpackagist\models\AssetPackage;
use hiqdev\assetpackagist\repositories\PackageRepository;
use Yii;
use yii\base\Component;
use zhuravljov\yii\queue\Job;

abstract class AbstractPackageCommand extends Component implements Job
{
    const EVENT_BEFORE_RUN = 'beforeRun';
    const EVENT_AFTER_RUN = 'afterRun';

    /**
     * @var AssetPackage
     */
    protected $package;

    /**
     * @var PackageRepository
     */
    protected $packageRepository;

    /**
     * Triggers event before run
     */
    public function beforeRun()
    {
        $this->trigger(self::EVENT_BEFORE_RUN);
    }

    /**
     * Triggers event after run
     */
    public function afterRun()
    {
        $this->trigger(self::EVENT_AFTER_RUN);
    }

    /**
     * CollectDependenciesCommand constructor.
     * @param AssetPackage $package
     * @param PackageRepository $packageRepository
     * @param array $config
     */
    public function __construct(AssetPackage $package, PackageRepository $packageRepository, $config = [])
    {
        parent::__construct($config);

        $this->package = $package;
        $this->packageRepository = $packageRepository;
    }

    /**
     * Reloads package on wake up to ensure it is up to date
     *
     * @void
     */
    public function __wakeup()
    {
        $this->package->load();
        $this->packageRepository = Yii::createObject(PackageRepository::class);
    }

    /**
     * @return AssetPackage
     */
    public function getPackage()
    {
        return $this->package;
    }
}
