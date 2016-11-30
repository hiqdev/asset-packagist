<?php

namespace hiqdev\assetpackagist\migrations;

use yii\db\Migration;

/**
 * Migration for queue message storage
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class m161130_163000_package extends Migration
{
    public $tableName = '{{%package}}';
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'type' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'last_update' => $this->integer(),
            'PRIMARY KEY (type, name)'
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
