<?php

namespace hiqdev\assetpackagist\commands;

use hiqdev\assetpackagist\models\AssetPackage;
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
     * @param array $config
     */
    public function __construct(AssetPackage $package, $config = [])
    {
        parent::__construct($config);

        $this->package = $package;
    }

    /**
     * Reloads package on wake up to ensure it is up to date
     *
     * @void
     */
    public function __wakeup()
    {
        $this->package->load();
    }

    /**
     * @return AssetPackage
     */
    public function getPackage()
    {
        return $this->package;
    }
}
