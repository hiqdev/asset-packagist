<?php

namespace hiqdev\assetpackagist\models;

use hiqdev\assetpackagist\registry\RegistryFactory;
use Composer\Factory;
use Composer\IO\NullIO;

class AssetPackage
{
    protected $_type;
    protected $_name;
    protected $_hash;
    protected $_data;

    protected $_io;
    protected $_composer;

    static protected $_commonComposer;

    static public function getCommonComposer()
    {
        if (static::$_commonComposer === null) {
            static::$_commonComposer = Factory::create($this->getIO());
        }

        return static::$_commonComposer;
    }

    public function setComposer($value)
    {
        $this->_composer = $value;
    }

    public function getComposer()
    {
        if ($this->_composer === null) {
            $this->_composer = static::getCommonComposer();
        }

        return $this->_composer;
    }

    public function getIO()
    {
        if ($this->_io === null) {
            $this->_io = new NullIO();
        }

        return $this->_io;
    }

    static public function buildFullName($type, $name)
    {
        return $type . '-asset/' . $name;
    }

    static public function buildPath($type, $name, $hash)
    {
        $two = substr($name, 0, 2);
        $dir = Yii::getAlias("@runtime/packages/$two/$type:$name");
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir . "/$hash.json";
    }

    /**
     * findOne 
     * 
     * @param string $type 
     * @param string $name 
     * @return static|null
     */
    static public function findOne($type, $name)
    {
    }

    static public function findOneOrCreate($type, $name)
    {
        return static::findOne($type, $name) ?: static::create($type, $name);
    }

    static protected function create($type, $name)
    {
        $registry   = RegistryFactory::getRegistry($type, $this->getComposer()->getRepositoryManager());
        $repo       = $registry->buildVcsRepository($name);
        $fullName   = static::buildFullName($type, $name);
        $versions   = static::buildVersions($repo, $fullName);
        $hash       = $this->updatePackage($fullName, $versions);
        $package = new static($type, $name, compact('versions'));
    }

    protected function _construct($type, $name, $data)
    {
        $this->_type = $type;
        $this->_name = $name;
        $this->_data = $data;
    }

    static public function buildVersions($repo, $fullName)
    {
        $versions = [];
        foreach ($repo->getPackages() as $package) {
            $version = [
                /// TODO XXX how to get uid properly ???
                'uid'       => rand(1000000, 2000000),
                'name'      => $fullName,
                'version'   => $package->getVersion(),
            ];
            if ($package->getDistUrl()) {
                $version['dist'] = [
                    'type'      => $package->getDistType(),
                    'url'       => $package->getDistUrl(),
                    'reference' => $package->getDistReference(),
                ];
            }
            if ($package->getSourceUrl()) {
                $version['source'] = [
                    'type'      => $package->getSourceType(),
                    'url'       => $package->getSourceUrl(),
                    'reference' => $package->getSourceReference(),
                ];
            }
            if ($version['dist'] || $version['source']) {
                $versions[$package->getVersion()] = $version;
            }
        }

        return $versions;
    }

}
