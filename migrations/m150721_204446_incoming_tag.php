<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_204446_incoming_tag extends Migration {

    public function up() {
        $this->createTable('{{%transaction_incoming_tag}}', [
            'incoming_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'tag_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_transaction_incoming_tag_incoming', '{{%transaction_incoming_tag}}', 'incoming_id', '{{%transaction_incoming}}', 'id');
        $this->addForeignKey('fk_transaction_incoming_tag_tag', '{{%transaction_incoming_tag}}', 'tag_id', '{{%tag}}', 'id');
    }

    public function down() {
        $this->dropTable('{{%transaction_incoming_tag}}');
    }

}
