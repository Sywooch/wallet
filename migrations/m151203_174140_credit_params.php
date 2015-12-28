<?php

use yii\db\Schema;
use yii\db\Migration;

class m151203_174140_credit_params extends Migration {

    public function up() {
        $this->addColumn('{{%account}}', 'percent', 'DECIMAL(5,2) NULL DEFAULT NULL');
        $this->addColumn('{{%account}}', 'payment_date', 'TINYINT NULL DEFAULT NULL');
        $this->addColumn('{{%account}}', 'credit_card_limit', 'DECIMAL(12,2) NULL DEFAULT NULL');
    }

    public function down() {
        $this->dropColumn('{{%account}}', 'percent');
        $this->dropColumn('{{%account}}', 'payment_date');
        $this->dropColumn('{{%account}}', 'credit_card_limit');
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
