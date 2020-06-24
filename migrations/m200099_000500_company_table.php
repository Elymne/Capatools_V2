<?php

use yii\db\Migration;

class m200099_000500_company_table extends Migration
{

    public function safeUp()
    {
        /* Table creation */

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

        /* Table data insertion */
        $this->insert('{{%company}}', [
            'id' => -1,
            'name' => 'Indéfini',
            'postal_code' => 'Indéfini',
            'city' => 'Indéfini',
            'country' => 'Indéfini',
            'tva' => 'Indéfini',
            'email' => 'Indéfini',
            'type' => 'Indéfini'
        ]);

        $this->insert('{{%company}}', [
            'name' => 'Maison de Balkany',
            'postal_code' => '44500',
            'city' => 'Paris',
            'country' => 'France',
            'tva' => 'FR 99999999999',
            'email' => 'balkany-corp@gmail.com',
            'type' => 'public'
        ]);

        $this->insert('{{%company}}', [
            'name' => 'Maison du Roi des Francs',
            'postal_code' => '12345',
            'city' => 'Paris',
            'country' => 'France',
            'tva' => 'FR 99999999991',
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
