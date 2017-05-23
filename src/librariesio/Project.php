<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\librariesio;

use hiqdev\assetpackagist\models\AssetPackage;
use hiqdev\assetpackagist\repositories\PackageRepository;
use Yii;
use yii\base\Model;

/**
 * @property string $fullName Full name of package
 */
class Project extends Model
{
    public $name;
    public $platform;
    public $description;
    public $homepage;
    public $repository_url;
    public $normalized_licenses;
    public $rank;
    public $latest_release_published_at;
    public $latest_release_number;
    public $language;
    public $status;
    public $package_manager_url;
    public $stars;
    public $forks;
    public $keywords;

    public function rules()
    {
        return [
            ['name', 'string'],
            ['platform', 'string'],
            ['description', 'string'],
            ['homepage', 'url'],
            ['repository_url', 'url'],
            ['normalized_licenses', 'each', 'rule' => ['string']],
            ['rank', 'integer'],
            ['latest_release_published_at', 'datetime', 'timestampAttribute' => 'latest_release_published_at'],
            ['latest_release_number', 'string'],
            ['language', 'string'],
            ['status', 'string'],
            ['package_manager_url', 'url'],
            ['stars', 'integer'],
            ['forks', 'integer'],
            ['keywords', 'each', 'rule' => ['string']],
        ];
    }

    public function getFullName()
    {
        $fullname = AssetPackage::buildFullName($this->platform, $this->name);
        return AssetPackage::normalizeName($fullname);
    }

    /**
     * Check the package exists in Asset-Packagist.
     * @return boolean
     */
    public function isAvailable()
    {
        $package = AssetPackage::fromFullName($this->getFullName());

        $repository = Yii::createObject(PackageRepository::class, []);

        return $repository->exists($package);
    }
}
