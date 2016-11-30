<?php

namespace hiqdev\assetpackagist\commands;

use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\helpers\Console;

/**
 * Class CollectDependenciesCommand collects dependencies for a certain package
 * and publishes tasks to update them.
 *
 * @package hiqdev\assetpackagist\commands
 */
class CollectDependenciesCommand extends AbstractPackageCommand
{
    public function run()
    {
        $this->beforeRun();

        $package = $this->package;
        $requires = [];

        foreach ($package->getReleases() as $release) {
            if (!isset($release['require'])) {
                continue;
            }

            foreach ($release['require'] as $name => $version) {
                $requires[$name] = true;
            }
        }

        foreach (array_keys($requires) as $name) {
            $assetPackage = AssetPackage::fromFullName($name);

            if ($this->packageRepository->exists($assetPackage)) {
                Yii::trace(Console::renderColoredString('Package %N' . $assetPackage->getFullName() . "%n already exists. Skipping.\n"), __CLASS__);
                continue;
            }

            Yii::$app->queue->push('package', Yii::createObject(PackageUpdateCommand::class, [$assetPackage]));
            Yii::trace(Console::renderColoredString('Created update command for %Y' . $assetPackage->getFullName() . "%n package\n"), __CLASS__);
        }

        $this->afterRun();
    }
}
