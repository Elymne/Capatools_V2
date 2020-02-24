<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%milestone}}`.
 */
class m200217_083859_create_milestone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%milestone}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
            'price' => $this->double(),
            'delivery_date' => $this->dateTime(),
            'comments' => $this->text(),
            'milestone_status_id' => $this->integer(),
            'devis_id' => $this->integer(),
        ]);


        $this->createTable('{{%milestone_status}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
        ]);

        //Ajout de la statut Avant Contrat
        $this->insert('{{%milestone_status}}', [
            'id' => '1',
            'label' => 'En cours'
        ]);

        //Ajout de la statut Projet en cours
        $this->insert('{{%milestone_status}}', [
            'id' => '2',
            'label' => 'Facturation en cours'
        ]);


        //Ajout de la statut Projet en cours
        $this->insert('{{%milestone_status}}', [
            'id' => '3',
            'label' => 'Facturé'
        ]);

        //Ajout prestation 
        $this->insert('{{%milestone_status}}', [
            'label' => 'Prestation'
        ]);

        //Ajout prestation interne
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
