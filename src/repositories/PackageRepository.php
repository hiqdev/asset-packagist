<?php

namespace hiqdev\assetpackagist\repositories;

use hiqdev\assetpackagist\models\AssetPackage;
use yii\db\Connection;
use yii\db\Query;

class PackageRepository
{
    /**
     * @var Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function save(AssetPackage $package)
    {
        if ($this->exists($package)) {
            $this->update($package);
        } else {
            $this->insert($package);
        }
    }

    public function insert(AssetPackage $package) {
        $this->db->createCommand()->insert('package', [
            'type' => $package->getType(),
            'name' => $package->getName(),
            'last_update' => $package->getUpdateTime(),
        ])->execute();
    }

    public function update(AssetPackage $package)
    {
        $this->db->createCommand()->update('package', [
            'last_update' => $package->getUpdateTime()
        ], [
            'type' => $package->getType(),
            'name' => $package->getName(),
        ])->execute();
    }

    /**
     * @param AssetPackage $package
     * @return bool
     */
    public function exists(AssetPackage $package)
    {
        return (new Query())
            ->from('package')
            ->where(['type' => $package->getType(), 'name' => $package->getName()])
            ->exists($this->db);
    }
}
