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
    public function execute($queue)
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

            $queue->priority(20);
            $queue->push(Yii::createObject(CollectDependenciesCommand::class, [$this->package]));
        }

        $this->afterRun();
    }

    /**
     * Returns the permanent-problem exception class for an update failure message,
     * or null when the failure may be temporary.
     *
     * @param string $message
     * @return string|null
     */
    public static function permanentProblemClass($message)
    {
        // Composer 2 reports e.g. `(HTTP/2 404 )`, Composer 1 reported `(HTTP/1.1 404 Not Found)`
        if (preg_match('{file could not be downloaded \(HTTP/[\d.]+ 404\b}i', $message)) {
            return PackageNotExistsException::class;
        }

        $markers = [
            'npm asset package must be present for create a VCS Repository' => CorruptedPackageException::class,
            'Could not parse version constraint' => CorruptedPackageException::class,
            'No valid bower.json was found in any branch or tag' => CorruptedPackageException::class,
            'No valid package.json was found in any branch or tag' => CorruptedPackageException::class,
        ];
        foreach ($markers as $marker => $exceptionClass) {
            if (stripos($message, $marker) !== false) {
                return $exceptionClass;
            }
        }

        return null;
    }

    private function transformException(\Exception $e)
    {
        $exceptionClass = static::permanentProblemClass($e->getMessage());
        if ($exceptionClass === null) {
            return false;
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
}
