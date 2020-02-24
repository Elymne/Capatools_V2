<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%devis_status}}`.
 */
class m200213_125952_create_devis_statut_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%devis_status}}', [
            'id' => $this->integer(),
            'label' => $this->string(),
        ]);

        $this->execute('ALTER TABLE devis_status AUTO_INCREMENT = 0');

        //Ajout de la statut Avant Contrat
        $this->insert('{{%devis_status}}', [
            'id' => '0',
            'label' => 'Avant contrat'
        ]);

        //Ajout de la statut Projet en cours
        $this->insert('{{%devis_status}}', [
            'id' => '1',
            'label' => 'Projet en cours'
        ]);

        //Ajout de la statut Projet annulé
        $this->insert('{{%devis_status}}', [
            'id' => '2',
            'label' => 'Projet annulé'
        ]);

        //Ajout de la statut Projet terminé
        $this->insert('{{%devis_status}}', [
            'id' => '3',
            'label' => 'Projet terminé'
        ]);

        //Ajout de la statut Projet en attente validation resopnsable opérationel
        $this->insert('{{%devis_status}}', [
            'id' => '4',
            'label' => 'Attente validation Opérationel'
        ]);

        //Ajout de la statut Projet en attente validation resopnsable opérationel
        $this->insert('{{%devis_status}}', [
            'id' => '5',
            'label' => 'Attente validation client'
        ]);

        $this->execute('ALTER TABLE devis_status ADD PRIMARY KEY (id)');


        $this->addColumn('devis', 'statut_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%devis_status}}');

        $this->dropColumn('devis', 'statut_id', $this->integer());
    }
}
