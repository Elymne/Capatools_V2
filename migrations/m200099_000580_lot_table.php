<?php

use yii\db\Migration;

class m200099_000580_lot_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%lot}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->defaultValue(1),
            'title' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
            'comment' => $this->string(),

            // Foreign key.
            'project_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_lot-projet',
            '{{%lot}}',
            'project_id',
            '{{%project}}',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_lot-projet',
            '{{%lot}}'
        );

        $this->dropTable('{{%lot}}');
    }
}
