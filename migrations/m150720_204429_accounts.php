<?php

use yii\db\Schema;
use yii\db\Migration;

class m150720_204429_accounts extends Migration
{
    public function up()
    {
        $this->createTable('{{%account}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'type' => "ENUM('money','credit','creditcard','invest','card','bonus','debt') DEFAULT NULL",
            'currency_id' => "varchar(5) DEFAULT NULL",
            'title' => "varchar(255) NOT NULL",
            'virtual' => Schema::TYPE_SMALLINT . " DEFAULT 0",
            'parent_id' => Schema::TYPE_INTEGER . " DEFAULT NULL",
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");

        $this->addForeignKey('fk_accounts_currency', '{{%account}}', 'currency_id', '{{%currency}}', 'id');
        $this->addForeignKey('fk_accounts_user', '{{%account}}', 'user_id', '{{%user}}', 'id');
    }

    public function down()
    {
        echo "m150720_203429_accounts cannot be reverted.\n";

        return false;
    }

}
