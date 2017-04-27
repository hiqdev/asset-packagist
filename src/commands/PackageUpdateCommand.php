<?php
/**
 * Asset Packagist.
 *
 * @see      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\commands;

use hiqdev\assetpackagist\exceptions\CorruptedPackageException;
use hiqdev\assetpackagist\exceptions\PackageNotExistsException;
use hiqdev\assetpackagist\exceptions\PermanentProblemExceptionInterface;
use Yii;

/**
 * Class PackageUpdateCommand runs package update command and creates tasks to
 * fetch its dependencies.
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
                $this->packageRepository->save($this->package);
            } catch (\Exception $e) {
                Yii::error('Failed to update package "' . $this->package->getFullName() . '": ' . $e->getMessage(), __CLASS__);
                $this->transformException($e);

                throw $e;
            }

            Yii::$app->queue->push(Yii::createObject(CollectDependenciesCommand::class, [$this->package]));
        }

        $this->afterRun();
    }

    private function transformException(\Exception $e)
    {
        $avoidMarkers = [
            'file could not be downloaded (HTTP/1.1 404 Not Found)' => PackageNotExistsException::class,
            'npm asset package must be present for create a VCS Repository' => CorruptedPackageException::class,
            'Could not parse version constraint' => CorruptedPackageException::class,
        ];

        foreach ($avoidMarkers as $marker => $exceptionClass) {
            if (!stripos($e->getMessage(), $marker)) {
                continue;
            }

            $newException = new $exceptionClass($e->getMessage(), 0, $e);

            if (
                $newException instanceof PermanentProblemExceptionInterface
                && $this->packageRepository->exists($this->package)
            ) {
                Yii::warning('Package ' . $this->package->getFullName() . ' is marked as avoided', __CLASS__);
                $this->packageRepository->markAvoided($this->package);
            }

            throw $newException;
        }

        return false;
    }
}
