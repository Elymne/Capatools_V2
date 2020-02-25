<?php

use yii\db\Migration;

class m200100_000007_create_devis_statut_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        /**
         * create table
         */
        $this->createTable('{{%devis_status}}', [
            'id' => $this->integer(),
            'label' => $this->string(),
        ]);

        /**
         * alter table
         */
        $this->execute('ALTER TABLE devis_status AUTO_INCREMENT = 0');

        $this->execute('ALTER TABLE devis_status ADD PRIMARY KEY (id)');

        /**
         * feed table
         */
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
        $this->dropTable('{{%devis_status}}');

        $this->dropColumn('devis', 'status_id', $this->integer());
    }
}
