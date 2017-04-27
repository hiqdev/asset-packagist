<?php
/**
 * Asset Packagist.
 *
 * @see      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\migrations;

use zhuravljov\yii\queue\db\migrations\M170307170300Later;

/**
 * Class m170307_170300_queue_timeout.
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class m170307_170300_queue_timeout extends M170307170300Later
{
    public $tableName = '{{%queue}}';
}
