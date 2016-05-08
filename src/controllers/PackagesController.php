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

use Yii;

class PackagesController extends \yii\web\Controller
{
    public function actionPackages()
    {
        Yii::$app->response->format = 'json';
        return [
            /*'packages'          => [
                'bower-asset/bootstrap' => [
                    '3.3.6' => [
                        'name'      => 'bower-asset/bootstrap',
                        'version'   => '3.3.6',
                        'dist'      => [
                            'url'       => 'https://github.com/twbs/bootstrap/archive/v3.3.6.zip',
                            'type'      => 'zip',
                        ],
                    ],
                ],
                'bower-asset/icheck' => [
                    '1.0.2' => [
                        'name'      => 'bower-asset/icheck',
                        'version'   => '1.0.2',
                        'dist'      => [
                            'url'       => 'https://github.com/fronteed/icheck/archive/1.0.2.zip',
                            'type'      => 'zip',
                        ],
                    ],
                ],
            ],
            */
            #'notify'            => '/downloads/%package%',
            #'notify-batch'      => '/downloads/',
            'providers-url'     => '/p/%package%$%hash%.json',
            'search'            => '/search.json?q=%query%',
            /*'provider-includes' => [
                'p/provider-latest.json' => [
                    'sha256' => 'ecadd2f1586d5d4b185d07af49ce108457b403fb8f33a0a56984950eaf2b616c',
                ],
            ],*/
        ];
    }

    public function actionProvider()
    {
        Yii::$app->response->format = 'json';
        return [
            'providers' => [
                'bower-asset/bootstrap' => [
                    'sha256' => '72899d5e585c6c234736b5c5d31b1dc3a87abc5521e1ad3c0d8f87b812b6de',
                ],
            ],
        ];
    }
}
