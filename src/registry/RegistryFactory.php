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
use Composer\Repository\RepositorySet;
use hiqdev\assetpackagist\fxp\Config\Config as AssetConfig;
use hiqdev\assetpackagist\fxp\Repository\AssetRepositoryManager;
use hiqdev\assetpackagist\fxp\Repository\VcsPackageFilter;
use hiqdev\assetpackagist\fxp\Util\AssetPlugin;
use hiqdev\assetpackagist\log\YiiLogIO;
use yii\base\BaseObject;
use yii\di\Instance;

class RegistryFactory extends BaseObject
{
    /**
     * The composer output.
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

        /**
         * Factory::createConfig load the composer configuration in COMPOSER_HOME
         * First read COMPOSER_HOME/config.json and COMPOSER_HOME/auth.json.
         */
        $this->composerConfig = Factory::createConfig($this->io);

        /**
         * Required to read authentication tokens (Ex. GitHub API)
         * See https://getcomposer.org/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens.
         */
        $this->io->loadConfiguration($this->composerConfig);

        /**
         * Create RepositoryManager with defaults repositories classes.
         */
        $this->repositoryManager = RepositoryFactory::manager($this->io, $this->composerConfig);

        // Keep the historical fxp-asset settings as input to the internal port.
        // No external Composer plugin is loaded or activated.
        $arrayConfig = [];
        if ($this->composerConfig->has('fxp-asset')) {
            $arrayConfig = $this->composerConfig->get('fxp-asset');
        }
        $this->assetConfig = new AssetConfig($arrayConfig);

        //Dummy Package
        $this->rootPackage = new RootPackage('asset-packagist', '0.0.0.0', '0.0.0');
        $this->installationManager = Factory::create($this->io, null, true)->getInstallationManager();
        $this->packageFilter = new VcsPackageFilter($this->assetConfig, $this->rootPackage, $this->installationManager);
        $this->assetRepositoryManager = new AssetRepositoryManager($this->io, $this->repositoryManager, $this->assetConfig, $this->packageFilter);

        /**
         * Define default repositories for Bower and NPM.
         */
        AssetPlugin::addRegistryRepositories($this->assetRepositoryManager, $this->packageFilter, $this->assetConfig);
        AssetPlugin::setVcsTypeRepositories($this->repositoryManager);
    }

    public function getRepository()
    {
        return new CompositeRepository($this->repositoryManager->getRepositories());
    }

    public function getPool($minimumStability = 'dev', $packageName = null)
    {
        $repositorySet = new RepositorySet($minimumStability);
        $repositorySet->addRepository($this->getRepository());

        return $packageName === null
            ? $repositorySet->createPoolWithAllPackages()
            : $repositorySet->createPoolForPackage($packageName);
    }
}
