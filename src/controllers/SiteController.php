<?php

/*
 * Asset Packagist
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\controllers;

use hiqdev\assetpackagist\models\AssetPackage;
use Yii;

class SiteController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionSearch()
    {
        $q = Yii::$app->request->get('query') ?: Yii::$app->request->post('query');
        list($temp, $name) = explode('/', $q);
        list($type, $temp) = explode('-', $temp);
        $package = new AssetPackage($type, $name);
        $binpath = Yii::getAlias('@vendor/bin/hidev');
        system("$binpath asset-package/update $type $name");
        $package->load();

        return $this->render('search', compact('package'));
    }
}
