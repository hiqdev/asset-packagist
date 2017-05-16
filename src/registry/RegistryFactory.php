<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\registry;

use Composer\Config as ComposerConfig;
use Composer\DependencyResolver\Pool;
use Composer\Factory;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use Composer\Package\RootPackage;
use Composer\Repository\CompositeRepository;
use Composer\Repository\RepositoryFactory;
use Composer\Repository\RepositoryManager;
use Fxp\Composer\AssetPlugin\Config\Config as AssetConfig;
use Fxp\Composer\AssetPlugin\Repository\AssetRepositoryManager;
use Fxp\Composer\AssetPlugin\Repository\VcsPackageFilter;
use Fxp\Composer\AssetPlugin\Util\AssetPlugin;
use hiqdev\assetpackagist\log\YiiLogIO;
use yii\base\Object;
use yii\di\Instance;

class RegistryFactory extends Object
{
    /**
     * @var array
     */
    public $registryMap = [
        //'bower' => BowerRegistry::class,
        //'npm'   => NpmRegistry::class,
    ];

    /**
     * @var string|IOInterface
     */
    public $io = [
        'class' => YiiLogIO::class,
    ];

    /**
     * @var ComposerConfig 
     */
    public $composerConfig;

    /**
     * @var RepositoryManager
     */
    public $repositoryManager;

    /**
     * @var AssetConfig 
     */
    public $assetConfig;

    /**
     * @var RootPackage 
     */
    public $rootPackage;

    /**
     * @var InstallationManager 
     */
    public $installationManager;

    /**
     * @var VcsPackageFilter 
     */
    public $packageFilter;

    /**
     * @var AssetRepositoryManager 
     */
    public $assetRepositoryManager;

    public function init()
    {
        parent::init();

        $this->io = Instance::ensure($this->io, IOInterface::class);

        $this->composerConfig = Factory::createConfig($this->io);

        $this->io->loadConfiguration($this->composerConfig);

        $this->repositoryManager = RepositoryFactory::manager($this->io, $this->composerConfig);

        $arrayConfig = [];
        if ($this->composerConfig->has('fxp-asset')) {
            $arrayConfig = $this->composerConfig->get('fxp-asset');
        }

        $this->assetConfig = new AssetConfig($arrayConfig);

        $this->rootPackage = new RootPackage('asset-packagist', '0.0.0.0', '0.0.0');

        $this->installationManager = new InstallationManager();

        $this->packageFilter = new VcsPackageFilter($this->assetConfig, $this->rootPackage, $this->installationManager);

        $this->assetRepositoryManager = new AssetRepositoryManager($this->io, $this->repositoryManager, $this->assetConfig, $this->packageFilter);

        //This not allow override class
        AssetPlugin::addRegistryRepositories($this->assetRepositoryManager, $this->packageFilter, $this->assetConfig);
        //
        //This allow override class
        //$this->registryMap = \yii\helpers\ArrayHelper::merge(Assets::getDefaultRegistries(), $this->registryMap);
        //foreach ($this->classMap as $assetType => $class) {
        //    $repoConfig = AssetPlugin::createRepositoryConfig($this->assetRepositoryManager, $this->packageFilter, $this->assetConfig, $assetType);
        //    $this->repositoryManager->setRepositoryClass($assetType, $class);
        //    $this->repositoryManager->addRepository($this->repositoryManager->createRepository($assetType, $repoConfig));
        //}

        AssetPlugin::setVcsTypeRepositories($this->repositoryManager);
    }

    public function getRepository()
    {
        return new CompositeRepository($this->repositoryManager->getRepositories());
    }

    public function getPool($minimumStability = 'dev')
    {
        $pool = new Pool($minimumStability);
        $pool->addRepository($this->getRepository());
        return $pool;
    }
}
