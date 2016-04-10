<?php

/*
 * asset-packagist.hiqdev.com
 *
 * @link      http://asset-packagist.hiqdev.com/
 * @package   asset-packagist.hiqdev.com
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\controllers;

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
}
