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

        $this->insert('{{%contact}}', [
            'firstname' => 'Marc',
            'Biggard' => 'Aurèle',
            'phone_number' => '06 00000000',
            'email' => 'marcaurele@gmail.com'

        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%contact}}', []);
        $this->dropTable('{{%contact}}');
    }
}
