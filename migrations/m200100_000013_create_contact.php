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
            'contact_id' => $this->integer()->notNull(),
            'company_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_contact-company',
            '{{%contact_company}}',
            'contact_id',
            '{{%contact}}',
            'id'
        );

        $this->addForeignKey(
            'FK_company-contact',
            '{{%contact_company}}',
            'company_id',
            '{{%company}}',
            'id'
        );
    }

    public function safeDown()
    {
    }
}
