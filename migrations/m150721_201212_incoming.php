<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_201212_incoming extends Migration {

    public function up() {
        $this->createTable('{{%transaction_incoming}}', [
            'id' => Schema::TYPE_PK,
            'account_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'transaction_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'sum' => Schema::TYPE_DECIMAL . "(10,2) NOT NULL",
            'comment' => Schema::TYPE_TEXT . " NOT NULL DEFAULT \"\"",
            'user_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_transaction_incoming_user', '{{%transaction_incoming}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_transaction_incoming_transaction', '{{%transaction_incoming}}', 'transaction_id', '{{%transaction}}', 'id');
        $this->addForeignKey('fk_transaction_incoming_account', '{{%transaction_incoming}}', 'account_id', '{{%account}}', 'id');
    }

    public function down() {
        $this->dropTable('{{%transaction_incoming}}');
    }

}
