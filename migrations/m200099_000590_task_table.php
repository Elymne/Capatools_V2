<?php

use yii\db\Migration;

class m200099_000590_task_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'lot_number' => $this->integer()->defaultValue(0),
            'title' => $this->string()->notNull(),
            'days_duration' => $this->integer()->defaultValue(0),
            'risk' => $this->string()->notNull(),
            'unit_price' => $this->double()->defaultValue(0),

            // Foreign key.
            'capa_user_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_task-capa_user_id',
            '{{%task}}',
            'capa_user_id',
            '{{%capa_user}}',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_task-capa_user_id',
            '{{%task}}'
        );

        $this->dropTable('{{%task}}');
    }
}
