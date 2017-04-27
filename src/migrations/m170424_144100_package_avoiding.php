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

use yii\db\Migration;

/**
 * Migration for packages avoiding.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class m170424_144100_package_avoiding extends Migration
{
    public function up()
    {
        $this->addColumn('package', 'is_avoided', $this->boolean()->defaultExpression('false'));

        $this->createIndex('package-is_avoided-idx', 'package', 'is_avoided');
    }

    public function down()
    {
        $this->dropColumn('package', 'is_avoided');
    }
}
