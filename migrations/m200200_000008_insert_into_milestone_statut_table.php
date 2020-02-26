<?php

use yii\db\Migration;

class m200200_000008_insert_into_milestone_statut_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->insert('{{%milestone_status}}', [
            'id' => '1',
            'label' => 'En cours'
        ]);

        $this->insert('{{%milestone_status}}', [
            'id' => '2',
            'label' => 'Facturation en cours'
        ]);

        $this->insert('{{%milestone_status}}', [
            'id' => '3',
            'label' => 'Facturé'
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->delete('{{%milestone_status}}');
    }
}
