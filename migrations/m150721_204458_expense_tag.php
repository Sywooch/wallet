<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_204458_expense_tag extends Migration
{
    public function up() {
        $this->createTable('{{%transaction_expense_tag}}', [
            'expense_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'tag_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_transaction_expense_tag_expense', '{{%transaction_expense_tag}}', 'expense_id', '{{%transaction_expense}}', 'id');
        $this->addForeignKey('fk_transaction_expense_tag_tag', '{{%transaction_expense_tag}}', 'tag_id', '{{%tag}}', 'id');
    }

    public function down() {
        $this->dropTable('{{%transaction_expense_tag}}');
    }

}
