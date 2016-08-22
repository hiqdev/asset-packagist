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

use Exception;
use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\filters\VerbFilter;

class SiteController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'update' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionSearch($query)
    {
        try {
            $package = $this->getAssetPackage($query);
            $params = ['package' => $package, 'query' => $query, 'forceUpdate' => false];

            if ($package->canAutoUpdate()) {
                $params['forceUpdate'] = true;
            }
        } catch (Exception $e) {
            $query = preg_replace('/[^a-z0-9-]/i', '', $query);

            return $this->render('notFound', compact('query'));
        }

        return $this->render('search', $params);
    }

    /**
     * @param $query
     * @return AssetPackage
     */
    private static function getAssetPackage($query)
    {
        list($type, $name) = AssetPackage::splitFullName($query);
        $package = new AssetPackage($type, $name);
        $package->load();
        return $package;
    }

    public function actionUpdate()
    {
        session_write_close();
        $query = Yii::$app->request->post('query');

        $package = $this->getAssetPackage($query);
        if ($package->canBeUpdated()) {
            $package->update();
        } else {
            Yii::$app->session->addFlash('update-impossible', true);
        }
        $package->load();

        return $this->renderPartial('package-details', ['package' => $package]);
    }
}
