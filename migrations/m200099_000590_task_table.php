<?php

use yii\db\Migration;

class m200099_000590_task_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->defaultValue(0),
            'title' => $this->string()->notNull(),
            'day_duration' => $this->integer()->defaultValue(0),
            'hour_duration' => $this->integer()->defaultValue(0),
            'price' => $this->double()->defaultValue(0),
            'risk' => $this->string()->notNull(),
            'risk_duration_hour' => $this->double(),
            'task_category' => $this->string()->notNull(),

            // Foreign key.
            'capa_user_id' => $this->integer()->notNull(),
            'lot_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_task-capa_user_id',
            '{{%task}}',
            'capa_user_id',
            '{{%capa_user}}',
            'id'
        );

        $this->addForeignKey(
            'FK_task-lot',
            '{{%task}}',
            'lot_id',
            '{{%lot}}',
            'id'
        );

        $this->insert('{{%task}}', [
            'title' => "Fumer un bon cigare",
            'day_duration' => 23,
            'hour_duration' => 2,

            'price' => 15000,
            'risk' => '1',
            'risk_duration_hour' => '7.7',
            'task_category' => 'Tâche',
            'capa_user_id' => 2,
            'lot_id' => 3,
        ]);
        $this->insert('{{%task}}', [
            'title' => "Faire une réunion avec nous même",
            'day_duration' => 23,
            'hour_duration' => 2,

            'price' => 1456,
            'risk' => '1',
            'risk_duration_hour' => '23.1',
            'task_category' => 'Management',
            'capa_user_id' => 2,
            'lot_id' => 1,
        ]);
        $this->insert('{{%task}}', [
            'title' => "Tâche numéro 1 : trouver les clefs",
            'day_duration' => 23,
            'hour_duration' => 2,
            'price' => 1456,
            'risk' => '1',
            'task_category' => 'Tâche',
            'risk_duration_hour' => '23.1',
            'capa_user_id' => 2,
            'lot_id' => 1,
        ]);

        $this->insert('{{%task}}', [
            'title' => "Tâche numéro 2 : libérer la cible",
            'day_duration' => 23,
            'hour_duration' => 2,
            'price' => 123,
            'risk' => '4',
            'task_category' => 'Tâche',
            'risk_duration_hour' => '23.1',
            'capa_user_id' => 3,
            'lot_id' => 1,
        ]);

        $this->insert('{{%task}}', [
            'title' => "Faire une réunion avec le lit",
            'day_duration' => 23,
            'hour_duration' => 2,
            'price' => 4005,
            'risk' => '4',
            'task_category' => 'Management',
            'risk_duration_hour' => '23.1',
            'capa_user_id' => 6,
            'lot_id' => 2,
        ]);
        $this->insert('{{%task}}', [
            'title' => "Tâche numéro 1 : dormir",
            'day_duration' => 23,
            'hour_duration' => 2,
            'price' => 4005,
            'risk' => '4',
            'task_category' => 'Tâche',
            'risk_duration_hour' => '23.1',
            'capa_user_id' => 6,
            'lot_id' => 2,
        ]);
    }

    public function safeDown()
    {

        $this->dropForeignKey(
            'FK_task-lot',
            '{{%task}}'
        );

        $this->dropForeignKey(
            'FK_task-capa_user_id',
            '{{%task}}'
        );

        $this->dropTable('{{%task}}');
    }
}
