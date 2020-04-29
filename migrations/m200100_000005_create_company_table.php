<?php

use yii\db\Migration;

class m200100_000005_create_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'address' => $this->string()->unique(),
            'phone' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'siret' => $this->string()->unique(),
            'tva' => $this->string()->unique(),
            'type' => $this->string(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%company}}');
    }
}
