<?php

use yii\db\Migration;

class m200099_000500_company_table extends Migration
{

    public function safeUp()
    {
        /* Table creation */

        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'address' => $this->string(),
            'postal_code' => $this->string(),
            'phone' => $this->string(),
            'city' => $this->string(),
            'country' => $this->string(),
            'tva' => $this->string()->unique(),
            'siret' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'type' => $this->string(),

        ]);

        $this->insert('{{%company}}', [
            'name' => 'Maison de Balkany',
            'address' => "Rue des boulangeaux",
            'postal_code' => '44500',
            'phone' => "0600000001",
            'city' => 'Paris',
            'country' => 'France',
            'tva' => 'FR 99999999999',
            'siret' => '9999999',
            'email' => 'balkany-corp@gmail.com',
            'type' => 'public'
        ]);

        $this->insert('{{%company}}', [
            'name' => 'Maison du Roi des Francs',
            'address' => "Rue des boulangeaux",
            'postal_code' => '12345',
            'phone' => "0600000002",
            'city' => 'Paris',
            'country' => 'France',
            'tva' => 'FR 99999999991',
            'siret' => '9999992',
            'email' => 'clovis-roidelafrancia@gmail.com',
            'type' => 'public'
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%company}}', []);
        $this->dropTable('{{%company}}');
    }
}
