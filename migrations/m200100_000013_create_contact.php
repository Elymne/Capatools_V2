<?php

use yii\db\Migration;

class m200100_000013_create_contact extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'company_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_contact-company',
            '{{%contact}}',
            'company_id',
            '{{%company}}',
            'id'
        );
    }

    public function safeDown()
    {
    }
}
