<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_185355_contractor extends Migration {

    public function up() {
        $this->createTable('{{%contractor}}', [
            'id' => Schema::TYPE_PK,
            'name' => "varchar(255) NOT NULL",
            'comment' => Schema::TYPE_TEXT . " NOT NULL",
            'user_id' => Schema::TYPE_INTEGER . " NOT NULL",
                ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');
        $this->createIndex('idx_contractor_name', '{{%contractor}}', 'name');
        $this->addForeignKey('fk_contractor_user', '{{%contractor}}', 'user_id', '{{%user}}', 'id');
    }

    public function down() {
        $this->dropTable('{{%contractor}}');
    }

}
