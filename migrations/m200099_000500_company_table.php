<?php

use yii\db\Migration;

class m200099_000500_company_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'postal_code' => $this->string()->unique(),
            'city' => $this->string(),
            'country' => $this->string(),
            'tva' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'type' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%company}}');
    }
}
