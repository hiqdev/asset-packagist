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
            Yii::$app->queue->push('package', new PackageUpdateCommand(AssetPackage::fromFullName($name)));
        }

        Yii::trace(Console::renderColoredString('Created update command for %y' . count($requires) . "%n packages\n"), __CLASS__);

        $this->afterRun();
    }
}
