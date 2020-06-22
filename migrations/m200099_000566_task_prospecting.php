<?php

use yii\db\Migration;

class m200099_000566_task_prospecting extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%task_prospecting}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
            'nb_days' => $this->integer()->defaultValue(0),
            'nb_hours' => $this->integer()->defaultValue(0),

            // Foreign key.
            'prospecting_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_task_prospecting-prospecting',
            '{{%task_prospecting}}',
            'prospecting_id',
            '{{%prospecting}}',
            'id'
        );

        $this->insert('{{%task_prospecting}}', [
            'type' => 'Transport',
            'nb_days' => 2,
            'nb_hours' => 12,
            'prospecting_id' => 1
        ]);

        $this->insert('{{%task_prospecting}}', [
            'type' => 'Transport',
            'nb_days' => 2,
            'nb_hours' => 12,
            'prospecting_id' => 1
        ]);
    }

    public function safeDown()
    {

        $this->dropForeignKey(
            'FK_task_prospecting-prospecting',
            '{{%task_prospecting}}'
        );

        $this->dropTable('{{%task_prospecting}}');
    }
}
