<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_201221_outgoing extends Migration {

    public function up() {
        $this->createTable('{{%transaction_outgoing}}', [
            'id' => Schema::TYPE_PK,
            'account_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'transaction_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'sum' => Schema::TYPE_DECIMAL . "(10,2) NOT NULL",
            'comment' => Schema::TYPE_TEXT . " NOT NULL DEFAULT \"\"",
            'user_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_transaction_outgoing_user', '{{%transaction_outgoing}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_transaction_outgoing_transaction', '{{%transaction_outgoing}}', 'transaction_id', '{{%transaction}}', 'id');
        $this->addForeignKey('fk_transaction_outgoing_account', '{{%transaction_outgoing}}', 'account_id', '{{%account}}', 'id');
    }

    public function down() {
        $this->dropTable('{{%transaction_outgoing}}');
    }

}
