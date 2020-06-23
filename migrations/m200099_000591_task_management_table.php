<?php

use yii\db\Migration;

class m200099_000591_task_management_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%task_management}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'days_duration' => $this->integer()->defaultValue(0),
            'risk' => $this->string()->notNull(),
            'risk_days' => $this->integer()->defaultValue(0),

            // Foreign key.
            'lot_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_task_management-lot',
            '{{%task_management}}',
            'lot_id',
            '{{%lot}}',
            'id'
        );

        $this->insert('{{%task_management}}', [
            'title' => "Préparer le café au grin",
            'days_duration' => 20,
            'risk' => 'Normal',
            'risk_days' => 15,
            'lot_id' => 1,
        ]);
    }

    public function safeDown()
    {

        $this->dropForeignKey(
            'FK_task_management-lot',
            '{{%task}}'
        );

        $this->dropTable('{{%task_management}}');
    }
}
