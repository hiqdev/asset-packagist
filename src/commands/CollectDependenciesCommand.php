<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\commands;

use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\helpers\Console;

/**
 * Class CollectDependenciesCommand collects dependencies for a certain package
 * and publishes tasks to update them.
 */
class CollectDependenciesCommand extends AbstractPackageCommand
{
    public function execute($queue)
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

            $queue->push(Yii::createObject(PackageUpdateCommand::class, [$assetPackage]));
            Yii::trace(Console::renderColoredString('Created update command for %Y' . $assetPackage->getFullName() . "%n package\n"), __CLASS__);
        }

        $this->afterRun();
    }
}
