<?php

use yii\db\Migration;

class m200200_000008_insert_into_milestone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->insert('{{%milestone}}', [
            'id' => '1',
            'label' => 'En cours'
        ]);

        $this->insert('{{%milestone}}', [
            'id' => '2',
            'label' => 'Facturation en cours'
        ]);

        $this->insert('{{%milestone}}', [
            'id' => '3',
            'label' => 'Facturé'
        ]);

        $this->insert('{{%milestone}}', [
            'label' => 'Prestation'
        ]);

        $this->insert('{{%milestone}}', [
            'label' => 'Prestation interne'
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
