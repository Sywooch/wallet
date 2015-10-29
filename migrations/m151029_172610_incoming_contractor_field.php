<?php

use yii\db\Schema;
use yii\db\Migration;

class m151029_172610_incoming_contractor_field extends Migration {

    public function up() {
        $this->addColumn("{{%transaction_incoming}}", 'contractor_id', "INT(11) NOT NULL");
        $this->addForeignKey("transaction_incoming_contractor_id", "{{%transaction_incoming}}", ['contractor_id'], "{{%contractor}}", ['id']);
    }

    public function down() {
        $this->dropForeignKey("transaction_incoming_contractor_id", "{{%transaction_incoming}}");
        $this->dropColumn("{{%transaction_incoming}}", 'contractor_id');
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
