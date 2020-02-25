<?php

use yii\db\Migration;

class m200100_000008_create_milestone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        /**
         * create table
         */
        $this->createTable('{{%milestone}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
            'price' => $this->double(),
            'delivery_date' => $this->dateTime(),
            'comments' => $this->text(),
            'milestone_status_id' => $this->integer(),
            'devis_id' => $this->integer(),
        ]);

        /**
         * feed table
         */
        $this->createTable('{{%milestone_status}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
        ]);

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

        $this->insert('{{%milestone_status}}', [
            'label' => 'Prestation'
        ]);

        $this->insert('{{%milestone_status}}', [
            'label' => 'Prestation interne'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%milestone}}');
        $this->dropTable('{{%milestone_status}}');
    }
}
