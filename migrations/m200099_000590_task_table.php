<?php

use yii\db\Migration;

class m200099_000590_task_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'duration' => $this->integer()->defaultValue(0),
            'kind_duration' => $this->string()->notNull(),
            'price' => $this->double()->defaultValue(0),
            'risk' => $this->string()->notNull(),
            'risk_duration' => $this->double()->defaultValue(0),
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
            'title' => "Faire une réunion avec nous même",
            'duration' => 23,
            'kind_duration' => 'Jour(s)',
            
            'price' => 1456,
            'risk' => 'Normale',
            'risk_duration' => 3,
            'task_category' => 'Management',
            'capa_user_id' => 2,
            'lot_id' => 1,
        ]);
        $this->insert('{{%task}}', [
            'title' => "Tâche numéro 1 : trouver les clefs",
            'duration' => 23,
            'kind_duration' => 'Jour(s)',
            'price' => 1456,
            'risk' => 'Normale',
            'task_category' => 'Tâche',
            'risk_duration' => 3,
            'capa_user_id' => 2,
            'lot_id' => 1,
        ]);

        $this->insert('{{%task}}', [
            'title' => "Tâche numéro 2 : libérer la cible",
            'duration' => 1,
            'kind_duration' => 'Jour(s)',
            'price' => 123,
            'risk' => 'Très haut',
            'task_category' => 'Tâche',
            'risk_duration' => 3,
            'capa_user_id' => 3,
            'lot_id' => 1,
        ]);

        $this->insert('{{%task}}', [
            'title' => "Faire une réunion avec le lit",
            'duration' => 1,
            'kind_duration' => 'Jour(s)',
            'price' => 4005,
            'risk' => 'Très haut',
            'task_category' => 'Management',
            'risk_duration' => 3,
            'capa_user_id' => 6,
            'lot_id' => 2,
        ]);
        $this->insert('{{%task}}', [
            'title' => "Tâche numéro 1 : dormir",
            'duration' => 1,
            'kind_duration' => 'Jour(s)',
            'price' => 4005,
            'risk' => 'Très haut',
            'task_category' => 'Tâche',
            'risk_duration' => 3,
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
