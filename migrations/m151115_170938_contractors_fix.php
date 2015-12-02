<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_170938_contractors_fix extends Migration {

    public function up() {
        $this->alterColumn('{{%transaction_incoming}}', 'contractor_id', 'INT(11) NULL DEFAULT NULL');
        $this->alterColumn('{{%transaction_expense}}', 'contractor_id', 'INT(11) NULL DEFAULT NULL');
    }

    public function down() {
        $this->alterColumn('{{%transaction_incoming}}', 'contractor_id', 'INT(11) NOT NULL');
        $this->alterColumn('{{%transaction_expense}}', 'contractor_id', 'INT(11) NOT NULL');
    }

}
