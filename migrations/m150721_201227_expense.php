<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_201227_expense extends Migration {

    public function up() {
        $this->createTable('{{%transaction_expense}}', [
            'id' => Schema::TYPE_PK,
            'name' => "VARCHAR(255) NOT NULL",
            'contractor_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'transaction_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'price' => Schema::TYPE_DECIMAL . "(10,2) NOT NULL",
            'qty' => Schema::TYPE_DECIMAL . "(12,4) NOT NULL",
            'sum' => Schema::TYPE_DECIMAL . "(10,2) NOT NULL",
            'comment' => Schema::TYPE_TEXT . " NOT NULL DEFAULT \"\"",
            'user_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_transaction_expense_user', '{{%transaction_expense}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_transaction_expense_transaction', '{{%transaction_expense}}', 'transaction_id', '{{%transaction}}', 'id');
        $this->addForeignKey('fk_transaction_expense_contractor', '{{%transaction_expense}}', 'contractor_id', '{{%contractor}}', 'id');
    }

    public function down() {
        $this->dropTable('{{%transaction_expense}}');
    }

}
