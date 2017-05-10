<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\menus;

use Yii;

/**
 * Navbar menu.
 * @author Andrii Vasyliev <sol@hiqdev.com>
 */
class NavbarMenu extends \hiqdev\thememanager\menus\NavbarMenu
{
    public function items()
    {
        return array_merge(parent::items(), [
            'search' => [
                'label' => $this->render('main-search'),
            ],
        ]);
    }
}
