<?php

use yii\db\Schema;
use yii\db\Migration;

class m151111_181420_expense_discount extends Migration {

    public function up() {
        $this->addColumn('{{%transaction_expense}}', 'discount', 'DECIMAL(12,4) NOT NULL DEFAULT 0');
    }

    public function down() {
        $this->dropColumn('{{%transaction_expense}}', 'discount');
    }

}
