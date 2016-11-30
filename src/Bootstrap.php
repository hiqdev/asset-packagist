<?php

namespace hiqdev\assetpackagist;

use hiqdev\assetpackagist\repositories\PackageRepository;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        Yii::$container->set('db', function () { return Yii::$app->get('db'); });
        Yii::$container->set(PackageRepository::class, PackageRepository::class, [\yii\di\Instance::of('db')]);
    }
}
