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

    /**
     * PackageRepository constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * @param AssetPackage $package
     * @return int
     */
    public function save(AssetPackage $package)
    {
        if ($this->exists($package)) {
            return $this->update($package);
        } else {
            return $this->insert($package);
        }
    }

    /**
     * @param AssetPackage $package
     * @return int
     */
    public function insert(AssetPackage $package) {
        return $this->db->createCommand()->insert('package', [
            'type' => $package->getType(),
            'name' => $package->getName(),
            'last_update' => $package->getUpdateTime(),
        ])->execute();
    }

    /**
     * @param AssetPackage $package
     * @return int
     */
    public function update(AssetPackage $package)
    {
        return $this->db->createCommand()->update('package', [
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

    /**
     * @return \hiqdev\assetpackagist\models\AssetPackage[]
     */
    public function getExpired()
    {
        $rows = (new Query())
            ->from('package')
            ->where(['<', 'last_update', time() - 60 * 60 * 24 * 7]) // Older than 7 days
            ->andWhere(['not', ['last_update' => null]])
            ->all();

        return $this->hydrate($rows);
    }

    /**
     * @param array $rows
     * @return AssetPackage[]
     */
    public function hydrate($rows)
    {
        $result = [];
        foreach ($rows as $row) {
            $result[] = new AssetPackage($row['type'], $row['name']);
        }

        return $result;
    }
}
