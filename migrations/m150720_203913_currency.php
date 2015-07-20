<?php

use yii\db\Schema;
use yii\db\Migration;

class m150720_203913_currency extends Migration
{
    public function up()
    {
        $this->createTable('{{%currency}}', [
            'id' => "varchar(5) PRIMARY KEY",
            'title' => "varchar(64) NOT NULL",
            'format' => "varchar(16) NOT NULL",
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");

        $this->insert('{{%currency}}', ['id' => 'RUR', 'title' => "Russian rouble", 'format' => "%.2f&nbsp;руб."]);
        $this->insert('{{%currency}}', ['id' => 'USD', 'title' => "US dollar", 'format' => "$&nbsp;%.2f"]);
        $this->insert('{{%currency}}', ['id' => 'KZT', 'title' => "Kazakh tenge", 'format' => "%.2f&nbsp;тг."]);
    }

    public function down()
    {
        $this->dropTable('{{%currency}}');
    }

}
