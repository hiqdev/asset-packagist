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

        if (!$this->package->canBeUpdated()) {
            if (!$this->packageRepository->exists($this->package)) {
                $this->packageRepository->insert($this->package);
            }
        } else {
            try {
                $this->package->update();
                $this->packageRepository->save($this->packages);
            } catch (\Exception $e) {
                Yii::error('Failed to update package "' . $this->package->getFullName() . '": ' . $e->getMessage(), __CLASS__);
                throw $e;
            }

            Yii::$app->queue->push('package', Yii::createObject(CollectDependenciesCommand::class, [$this->package]));
        }


        $this->afterRun();
    }
}
