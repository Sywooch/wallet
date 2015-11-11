<?php

use yii\db\Schema;
use yii\db\Migration;

class m151111_181743_transaction_type extends Migration {

    public function up() {
        $this->addColumn('{{%transaction}}', 'type', 'ENUM("expense", "income", "transfer")');
    }

    public function down() {
        $this->dropColumn('{{%transaction}}', 'type');
    }

}
