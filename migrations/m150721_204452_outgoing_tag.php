<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_204452_outgoing_tag extends Migration
{
    public function up() {
        $this->createTable('{{%transaction_outgoing_tag}}', [
            'outgoing_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'tag_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_transaction_outgoing_tag_outgoing', '{{%transaction_outgoing_tag}}', 'outgoing_id', '{{%transaction_outgoing}}', 'id');
        $this->addForeignKey('fk_transaction_outgoing_tag_tag', '{{%transaction_outgoing_tag}}', 'tag_id', '{{%tag}}', 'id');
    }

    public function down() {
        $this->dropTable('{{%transaction_outgoing_tag}}');
    }

}
