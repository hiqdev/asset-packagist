<?php

namespace hiqdev\assetpackagist;

use hiqdev\assetpackagist\components\Storage;
use hiqdev\assetpackagist\components\StorageInterface;
use hiqdev\assetpackagist\repositories\PackageRepository;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\di\Instance;

class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        Yii::$container->set('db', function () { return Yii::$app->get('db'); });
        Yii::$container->set(PackageRepository::class, PackageRepository::class, [Instance::of('db')]);

        Yii::$container->set(StorageInterface::class, function () {
            return Yii::$app->get('packageStorage');
        });
    }
}
