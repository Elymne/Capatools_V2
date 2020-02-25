<?php

use yii\db\Migration;

class m200100_091731_create_delivery_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        /**
         * create table
         */
        $this->createTable('{{%delivery_type}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
        ]);

        /**
         * feed table
         */
        $this->insert('{{%delivery_type}}', [
            'label' => 'Délégué'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery_type}}');
        return true;
    }
}
