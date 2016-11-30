<?php

namespace hiqdev\assetpackagist\commands;

use Yii;

/**
 * Class PackageUpdateCommand runs package update command and creates tasks to
 * fetch its dependencies.
 *
 * @package hiqdev\assetpackagist\commands
 */
class PackageUpdateCommand extends AbstractPackageCommand
{
    public function run()
    {
        $this->beforeRun();

        if ($this->package->canBeUpdated()) {
            $this->package->update();
        }

        Yii::$app->queue->push('package', new CollectDependenciesCommand($this->package));

        $this->afterRun();
    }
}
