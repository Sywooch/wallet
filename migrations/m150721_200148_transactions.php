<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_200148_transactions extends Migration {

    public function up() {
        $this->createTable('{{%transaction}}', [
            'id' => Schema::TYPE_PK,
            'date' => Schema::TYPE_DATETIME . " NOT NULL",
            'comment' => Schema::TYPE_TEXT . " NOT NULL DEFAULT \"\"",
            'user_id' => Schema::TYPE_INTEGER . " NOT NULL",
                ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_transaction_user', '{{%transaction}}', 'user_id', '{{%user}}', 'id');
    }

    public function down() {
        $this->dropTable('{{%transaction}}');
    }

}
