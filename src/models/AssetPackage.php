<?php

namespace hiqdev\assetpackagist\models;

use Exception;
use Composer\Factory;
use Composer\IO\NullIO;
use hiqdev\assetpackagist\registry\RegistryFactory;

class AssetPackage
{
    protected $_type;
    protected $_name;
    protected $_hash;
    protected $_releases = [];
    protected $_saved;

    protected $_io;
    protected $_composer;
    protected $_storage;

    static protected $_commonComposer;

    public function __construct($type, $name)
    {
        if (!$this->checkType($type)) {
            throw new Exception('wrong type');
        }
        if (!$this->checkName($name)) {
            throw new Exception('wrong name');
        }
        $this->_type = $type;
        $this->_name = $name;
    }

    public function checkType($type)
    {
        return $type === 'bower' || $type === 'npm';
    }

    public function checkName($name)
    {
        return strlen($name)>1;
    }

    public function getFullName()
    {
        return static::buildFullName($this->_type, $this->_name);
    }

    static public function buildFullName($type, $name)
    {
        return $type . '-asset/' . $name;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getHash()
    {
        return $this->_hash;
    }

    static public function getCommonComposer()
    {
        if (static::$_commonComposer === null) {
            static::$_commonComposer = Factory::create(new NullIO());
            #$factory = new Factory();
            #static::$_commonComposer = $factory->createComposer(new NullIO(), null, false, null, false);
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

    /**
     * findOne
     *
     * @param string $type
     * @param string $name
     * @return static|null
     */
    static public function findOne($type, $name)
    {
        $package = new static($type, $name);
        $package->load();

        return $package;
    }

    public function load()
    {
        $data = $this->getStorage()->readPackage($this);
        $this->_hash = $data['hash'];
        $this->_releases = $data['releases'];
    }

    public function update()
    {
        $registry = RegistryFactory::getRegistry($this->getType(), $this->getComposer()->getRepositoryManager());
        $repo = $registry->buildVcsRepository($this->getName());
        $this->_releases = $this->prepareReleases($repo);
        $this->_hash = $this->getStorage()->writePackage($this);
    }

    public function prepareReleases($repo)
    {
        $releases = [];
        foreach ($repo->getPackages() as $package) {
            $version = $package->getVersion();
            $release = [
                'uid'       => $this->prepareUid($version),
                'name'      => $this->getFullName(),
                'version'   => $version,
            ];
            if ($package->getDistUrl()) {
                $release['dist'] = [
                    'type'      => $package->getDistType(),
                    'url'       => $package->getDistUrl(),
                    'reference' => $package->getDistReference(),
                ];
            }
            if ($package->getSourceUrl()) {
                $release['source'] = [
                    'type'      => $package->getSourceType(),
                    'url'       => $package->getSourceUrl(),
                    'reference' => $package->getSourceReference(),
                ];
            }
            if ($release['dist'] || $release['source']) {
                $releases[$version] = $release;
            }
        }

        return $releases;
    }

    public function prepareUid($version)
    {
        $known = $this->getSaved()->getRelease($version);

        return isset($known['uid']) ? $known['uid'] : $this->getStorage()->getNextID();
    }

    public function getReleases()
    {
        return $this->_releases;
    }

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

    public function getStorage()
    {
        if ($this->_storage === null) {
            $this->_storage = Storage::getInstance();
        }

        return $this->_storage;
    }
}
