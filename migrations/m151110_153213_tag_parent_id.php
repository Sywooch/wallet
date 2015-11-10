<?php

use yii\db\Schema;
use yii\db\Migration;

class m151110_153213_tag_parent_id extends Migration {

    public function up() {
        $this->addColumn('{{%tag}}', 'parent_id', 'INT NULL DEFAULT NULL');
        $this->addForeignKey('tag_parent_id_tag_id', '{{%tag}}', 'parent_id', '{{%tag}}', 'id');
    }

    public function down() {
        $this->dropForeignKey('tag_parent_id_tag_id', '{{%tag}}');
        $this->dropColumn('{{%tag}}', 'parent_id');
    }

}
