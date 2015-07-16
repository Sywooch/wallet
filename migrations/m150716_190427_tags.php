<?php

use yii\db\Schema;
use yii\db\Migration;

class m150716_190427_tags extends Migration
{
    public function up()
    {
        $this->createTable('{{%tag}}', [
            'id' => Schema::TYPE_PK,
            'name' => "VARCHAR(255) NOT NULL",
            'type' => "ENUM('expense', 'income', 'transfer') NOT NULL",
            'user_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8");
        $this->addForeignKey('fk_tag_user', '{{%tag}}', 'user_id', '{{%user}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%tags}}');
    }

}
