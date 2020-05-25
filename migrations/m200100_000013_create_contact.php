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
            'phone' => $this->string()->notNull()
        ]);

        $this->createTable('{{%contact_company}}', [
            'id' => $this->primaryKey(),
            'id_contact' => $this->integer()->notNull(),
            'id_company' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_contact-company',
            '{{%contact_company}}',
            'id_contact',
            '{{%contact}}',
            'id'
        );

        $this->addForeignKey(
            'FK_company-contact',
            '{{%contact_company}}',
            'id_company',
            '{{%company}}',
            'id'
        );
    }

    public function safeDown()
    {
    }
}
