<?php

use yii\db\Migration;

class m200200_000007_insert_into_devis_statut_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        

        $this->insert('{{%devis_status}}', [
            'id' => '0',
            'label' => 'Avant contrat'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => '1',
            'label' => 'Projet en cours'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => '2',
            'label' => 'Projet annulé'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => '3',
            'label' => 'Projet terminé'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => '4',
            'label' => 'Attente validation Opérationel'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => '5',
            'label' => 'Attente validation client'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%devis_status}}');
    }
}
