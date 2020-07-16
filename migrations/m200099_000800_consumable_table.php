<?php

use yii\db\Migration;

class m200099_000800_consumable_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%consumable}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'price' => $this->double()->notNull(),
            'type' => $this->string()->notNull(),
            'lot_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'FK_consumable-lot',
            '{{%consumable}}',
            'lot_id',
            '{{%lot}}',
            'id'
        );

        $this->insert('{{%consumable}}', [
            'id' => 3,
            'title' => "Un cigare cubain",
            'price' => 1555,
            'type' => 'Consommable',
            'lot_id' => 3,
        ]);

        $this->insert('{{%consumable}}', [
            'id' => 1,
            'title' => "Orbe rouge brisé",
            'price' => 1200,
            'type' => 'Consommable',
            'lot_id' => 1,
        ]);

        $this->insert('{{%consumable}}', [
            'id' => 2,
            'title' => "Felcloth",
            'price' => 1200,
            'type' => 'Consommable',
            'lot_id' => 1,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%expense}}');
    }
}
