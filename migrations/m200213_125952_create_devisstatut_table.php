<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%devisstatut}}`.
 */
class m200213_125952_create_devisstatut_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%devisstatut}}', [
            'id' => $this->integer(),
            'label' =>$this->string(),
        ]);

        $this->execute('ALTER TABLE devisstatut AUTO_INCREMENT = 0');

        //Ajout de la statut Avant Contrat
        $this->insert('{{%devisstatut}}', [
            'id' => '0',
            'label' => 'Avant contrat'
        ]);

        //Ajout de la statut Projet en cours
        $this->insert('{{%devisstatut}}', [
            'id' => '1',
            'label' => 'Projet en cours'
        ]);

        //Ajout de la statut Projet annulé
        $this->insert('{{%devisstatut}}', [
            'id' => '2',
            'label' => 'Projet annulé'
        ]);

        //Ajout de la statut Projet terminé
        $this->insert('{{%devisstatut}}', [
            'id' => '3',
            'label' => 'Projet terminé'
        ]);

        //Ajout de la statut Projet en attente validation resopnsable opérationel
        $this->insert('{{%devisstatut}}', [
            'id' => '4',
            'label' => 'Attente validation Opérationel'
        ]);

        //Ajout de la statut Projet en attente validation resopnsable opérationel
        $this->insert('{{%devisstatut}}', [
            'id' => '5',
            'label' => 'Attente validation client'
        ]);
        
        $this->execute('ALTER TABLE devisstatut ADD PRIMARY KEY (id)');
        

        $this->addColumn('devis', 'statut_id', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%devisstatut}}');
        
        $this->dropColumn('devis', 'statut_id', $this->integer());
    }
}
