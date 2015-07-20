<?php

use yii\db\Schema;
use yii\db\Migration;

class m150720_204831_balance extends Migration
{
    public function up()
    {
        $this->createTable('{{%balance}}', [
            'id' => Schema::TYPE_PK,
            'account_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'date' => Schema::TYPE_DATE . " NOT NULL",
            'sum' => Schema::TYPE_DECIMAL . "(12,2) NOT NULL",
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");

        $this->createIndex('idx_balance_account_date', '{{%balance}}', ['account_id', 'date'], true);
        $this->addForeignKey('fk_balance_account', '{{%balance}}', 'account_id', '{{%account}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%balance}}');
    }

}
