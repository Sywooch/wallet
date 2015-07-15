<?php

use yii\db\Schema;
use yii\db\Migration;

class m150715_194200_users extends Migration
{

    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . " COLLATE utf8_unicode_ci NOT NULL",
            'auth_key' => "VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL",
            'password_hash' => "VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL",
            'password_reset_token' => "VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL",
            'email' => "VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL",
            'status' => "smallint(6) NOT NULL DEFAULT '10'",
            'created_at' => "int(11) NOT NULL",
            'updated_at' => "int(11) NOT NULL",

        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
    }

    public function down()
    {
         $this->dropTable('{{%user}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
