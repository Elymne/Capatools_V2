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
            'label' => 'Avant contrat'
        ]);

        $this->insert('{{%devis_status}}', [
            'label' => 'Projet en cours'
        ]);

        $this->insert('{{%devis_status}}', [
            'label' => 'Projet annulé'
        ]);

        $this->insert('{{%devis_status}}', [
            'label' => 'Projet terminé'
        ]);

        $this->insert('{{%devis_status}}', [
            'label' => 'Attente validation Opérationel'
        ]);

        $this->insert('{{%devis_status}}', [
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
