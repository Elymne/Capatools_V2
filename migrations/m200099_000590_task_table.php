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
            'lot_number' => 1,
            'title' => "Tâche numéro 1 : trouver les clefs",
            'days_duration' => 23,
            'risk' => 'Normal',
            'unit_price' => 1456,
            'capa_user_id' => 2,
            'lot_id' => 1,
        ]);

        $this->insert('{{%task}}', [
            'lot_number' => 1,
            'title' => "Tâche numéro 2 : libérer la cible",
            'days_duration' => 1,
            'risk' => 'Très haut',
            'unit_price' => 23847,
            'capa_user_id' => 3,
            'lot_id' => 1,
        ]);

        $this->insert('{{%task}}', [
            'lot_number' => 2,
            'title' => "Tâche numéro 1 : dormir",
            'days_duration' => 1,
            'risk' => 'Très haut',
            'unit_price' => 23,
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
