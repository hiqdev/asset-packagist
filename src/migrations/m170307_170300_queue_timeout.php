<?php

namespace hiqdev\assetpackagist\migrations;

use zhuravljov\yii\queue\db\migrations\M170307170300Later;

/**
 * Class m170307_170300_queue_timeout
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
class m170307_170300_queue_timeout extends M170307170300Later
{
    public $tableName = '{{%queue}}';
}