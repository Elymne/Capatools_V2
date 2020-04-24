<?php

use yii\db\Migration;

class m200200_000001_insert_into_delivery_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->insert('{{%delivery_type}}', [
            'label' => 'Prestation externe'
        ]);

        $this->insert('{{%delivery_type}}', [
            'label' => 'Activité déléguée'
        ]);

        $this->insert('{{%delivery_type}}', [
            'label' => 'Prestation interne'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%delivery_type}}');
    }
}
