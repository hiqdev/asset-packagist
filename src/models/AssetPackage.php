<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\models;

use Composer\Package\Link;
use Exception;
use hiqdev\assetpackagist\components\Storage;
use hiqdev\assetpackagist\registry\RegistryFactory;
use hiqdev\assetpackagist\repositories\PackageRepository;
use Yii;
use yii\base\BaseObject;

class AssetPackage extends BaseObject
{
    protected $_type;
    protected $_name;
    protected $_hash;
    /**
     * @var array
     */
    protected $_releases = [];
    protected $_saved;

    /**
     * @var integer UNIX Epoch timestamp of the latest package update
     */
    protected $_updateTime;

    public static function normalizeName($name)
    {
        return strtolower(static::normalizeScopedName($name));
    }

    public static function normalizeScopedName($name)
    {
        return preg_replace("#@(.+?)/#", '${1}--', $name);
    }

    /**
     * AssetPackage constructor.
     * @param string $type
     * @param string $name
     * @param array $config
     * @throws Exception
     */
    public function __construct($type, $name, $config = [])
    {
        parent::__construct($config);

        if (!$this->checkType($type)) {
            throw new Exception('wrong type');
        }
        if (!$this->checkName($name)) {
            throw new Exception('wrong name');
        }
        $this->_type = $type;
        $this->_name = $name;
    }

    /**
     * @return RegistryFactory
     */
    public function getRegistry()
    {
        return Yii::$app->get('registryFactory');
    }

    public function checkType($type)
    {
        return $type === 'bower' || $type === 'npm';
    }

    public function checkName($name)
    {
        return strlen($name) > 0;
    }

    public function getFullName()
    {
        return static::buildFullName($this->_type, $this->_name);
    }

    public static function buildNormalName($type, $name)
    {
        return static::buildFullName($type, static::normalizeName($name));
    }

    public static function buildFullName($type, $name)
    {
        return $type . '-asset/' . $name;
    }

    public static function splitFullName($full)
    {
        list($temp, $name) = explode('/', $full);
        list($type) = explode('-', $temp);

        return [$type, $name];
    }

    /**
     * @param string $full package name
     * @return static
     */
    public static function fromFullName($full)
    {
        list($type, $name) = static::splitFullName($full);
        return new static($type, $name);
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getNormalName()
    {
        return static::buildNormalName($this->_type, $this->_name);
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getHash()
    {
        return $this->_hash;
    }

    /**
     * findOne.
     *
     * @param string $type
     * @param string $name
     * @return static|null
     */
    public static function findOne($type, $name)
    {
        $package = new static($type, $name);
        $package->load();

        return $package;
    }

    public function load()
    {
        $data = $this->getStorage()->readPackage($this);
        if ($data !== null) {
            $this->_hash = $data['hash'];
            $this->_releases = $data['releases'];
            $this->_updateTime = $data['updateTime'];
        }
    }

    public function update()
    {
        $pool = $this->getRegistry()->getPool();
        $this->_releases = $this->prepareReleases($pool);
        $this->getStorage()->writePackage($this);
        $this->load();
    }

    /**
     * @param \Composer\DependencyResolver\Pool $pool
     * @return array
     */
    public function prepareReleases($pool)
    {
        $releases = [];

        foreach ($pool->whatProvides($this->getFullName()) as $package) {
            if ($package instanceof \Composer\Package\AliasPackage) {
                continue;
            }

            $version = $this->prepareVersion($package->getPrettyVersion());
            $require = $this->prepareRequire($package->getRequires());
            $release = [
                'uid' => $this->prepareUid($version),
                'name' => $this->getNormalName(),
                'version' => $version,
                'version_normalized' => $this->prepareVersion($package->getVersion()),
                'type' => $this->getType() . '-asset',
            ];
            if ($require) {
                $release['require'] = $require;
            }
            if ($package->getDistUrl()) {
                $release['dist'] = [
                    'type' => $package->getDistType(),
                    'url' => $package->getDistUrl(),
                    'reference' => $package->getDistReference(),
                ];
            }
            if ($package->getLicense()) {
                $release['license'] = $package->getLicense();
            }
            if ($package->getSourceUrl()) {
                $release['source'] = [
                    'type' => $package->getSourceType(),
                    'url' => $package->getSourceUrl(),
                    'reference' => $package->getSourceReference(),
                ];
            }
            if ((isset($release['dist']) && $release['dist']) || (isset($release['source']) && $release['source'])) {
                $releases[$version] = $release;
            }
        }

        //Sort before save
        \hiqdev\assetpackagist\components\PackageUtil::sort($releases);

        return $releases;
    }

    protected function prepareVersion($version)
    {
        if ($this->getNormalName() === 'bower-asset/angular') {
            return $this->convertPatchToRC($version);
        }

        return $version;
    }

    protected function convertPatchToRC($version)
    {
        return preg_replace('/-patch(.+)/', '-RC${1}', $version);
    }

    /**
     * Prepares array of requires: name => constraint.
     * @param Link[] array of package requires
     * @return array
     */
    public function prepareRequire(array $links)
    {
        $requires = [];
        foreach ($links as $name => $link) {
            /** @var Link $link */
            $requires[$name] = $link->getPrettyConstraint();
        }

        return $requires;
    }

    public function prepareUid($version)
    {
        $known = $this->getSaved()->getRelease($version);

        return isset($known['uid']) ? $known['uid'] : $this->getStorage()->getNextId();
    }

    /**
     * @return array
     */
    public function getReleases()
    {
        return $this->_releases;
    }

    /**
     * @param $version
     * @return array
     */
    public function getRelease($version)
    {
        return isset($this->_releases[$version]) ? $this->_releases[$version] : [];
    }

    public function getSaved()
    {
        if ($this->_saved === null) {
            $this->_saved = static::findOne($this->getType(), $this->getName());
        }

        return $this->_saved;
    }

    /**
     * @return Storage
     */
    public function getStorage()
    {
        return Yii::$app->get('packageStorage');
    }

    /**
     * Returns the latest update time (UNIX Epoch).
     * @return int|null
     */
    public function getUpdateTime()
    {
        return $this->_updateTime;
    }

    /**
     * Package can be updated not more often than once in 10 min.
     * @return bool
     */
    public function canBeUpdated()
    {
        return time() - $this->getUpdateTime() > 60 * 10; // 10 min
    }

    /**
     * Whether tha package should be auth-updated (if it is older than 1 day).
     * @return bool
     */
    public function canAutoUpdate()
    {
        return time() - $this->getUpdateTime() > 60 * 60 * 24; // 1 day
    }

    public function isAvailable()
    {
        $repository = Yii::createObject(PackageRepository::class, []);

        return $repository->exists($this);
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return ['_type', '_name', '_hash'];
    }
}
