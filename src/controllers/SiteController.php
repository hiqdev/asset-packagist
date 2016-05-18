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
use yii\web\ServerErrorHttpException;

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
        $query = Yii::$app->request->get('query') ?: Yii::$app->request->post('query');

        list($type, $name) = AssetPackage::splitFullName($query);

        try {
            $package = new AssetPackage($type, $name);
            $package->update();
            $package->load();
        }  catch (\Exception $e) {
            throw new ServerErrorHttpException($e->getMessage());
        }

        return $this->render('search', ['package' => $package, 'query' => $query]);
    }
}
