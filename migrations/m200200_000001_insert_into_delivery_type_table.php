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
            'label' => 'Délégué'
        ]);

        $this->insert('{{%delivery_type}}', [
            'label' => 'Prestation'
        ]);

        $this->insert('{{%delivery_type}}', [
            'label' => 'Prestation interne'
        ]);

        $this->insert('{{%delivery_type}}', [
            'label' => 'Projet interne'
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
