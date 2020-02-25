<?php

use yii\db\Migration;

class m200200_000006_insert_into_devis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%devis}}');
    }
}
