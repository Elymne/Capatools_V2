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
            'id' => 1,
            'label' => 'Avant contrat'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => 2,
            'label' => 'Validation Opérationel'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => 3,
            'label' => 'Signature client'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => 4,
            'label' => 'Projet en cours'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => 5,
            'label' => 'Projet annulé'
        ]);

        $this->insert('{{%devis_status}}', [
            'id' => 6,
            'label' => 'Projet terminé'
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
