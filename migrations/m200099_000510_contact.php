<?php

use yii\db\Migration;

class m200099_000510_contact extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'phone_number' => $this->string()->notNull(),
            'email' => $this->string()->unique()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%contact}}');
    }
}
