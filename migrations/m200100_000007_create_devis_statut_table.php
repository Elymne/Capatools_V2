<?php

use yii\db\Migration;

class m200100_000007_create_devis_statut_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%devis_status}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
        ]);

        $this->execute('ALTER TABLE devis_status AUTO_INCREMENT = 1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%devis_status}}');
    }
}
