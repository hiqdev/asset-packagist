<?php

/*
 * Hisite core package
 *
 * @link      https://github.com/hiqdev/hisite-core
 * @package   hisite-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist;

use Yii;

class MainMenu extends \hiqdev\menumanager\Menu
{
    protected $_addTo = 'main';

    public function items()
    {
        return [
            'about' => [
                'label' => Yii::t('hisite', 'About'),
                'url' => ['/site/about'],
            ],
            'contact' => [
                'label' => Yii::t('hisite', 'Contact'),
                'url' => ['/site/contact'],
            ],
            'github' => [
                'label' => 'GitHub',
                'url' => 'https://github.com/hiqdev/asset-packagist',
            ],
        ];
    }
}
