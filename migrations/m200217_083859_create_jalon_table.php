<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jalon}}`.
 */
class m200217_083859_create_jalon_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%jalon}}', [
            'id' => $this->primaryKey(),
            'devis_id' => $this->integer(),
            'label' => $this->string(),
            'prix_jalon' => $this->double(),
            'date_jalon' => $this->dateTime(),
            'commentaires' => $this->text(),
            'statut_jalon_id' => $this->integer(),
        ]);


        $this->createTable('{{%jalonstatut}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
        ]);

        $this->addColumn('devis', 'prix', $this->double());


        //Ajout de la statut Avant Contrat
        $this->insert('{{%jalonstatut}}', [
            'id' => '1',
            'label' => 'En cours'
        ]);

        //Ajout de la statut Projet en cours
        $this->insert('{{%jalonstatut}}', [
            'id' => '2',
            'label' => 'Facturation en cours'
        ]);


        //Ajout de la statut Projet en cours
        $this->insert('{{%jalonstatut}}', [
            'id' => '3',
            'label' => 'Facturé'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%jalon}}');
        $this->dropTable('{{%jalonstatut}}');
        $this->dropColumn('devis', 'prix');
    }
}
