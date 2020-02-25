<?php

use yii\db\Migration;

class m200200_000005_insert_into_company_table extends Migration
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
        $this->delete('{{%company}}');
    }
}
