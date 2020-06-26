<?php

use yii\db\Migration;

class m200099_000550_equipment_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%equipment}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price_day' => $this->double()->defaultValue(0),
            'price_hour' => $this->double()->defaultValue(0),
            'type' => $this->string()->notNull(),

            // Foreign key.
            'laboratory_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_equipment-laboratory',
            '{{%equipment}}',
            'laboratory_id',
            '{{%laboratory}}',
            'id'
        );

        $this->insert('{{%equipment}}', [
            'name' => "Cuve à bière",
            'price_day' => 1060.00,
            'price_hour' => 129.00,
            'type' => 'Outil expérimental',
            'laboratory_id' => 1
        ]);

        $this->insert('{{%equipment}}', [
            'name' => "BFG",
            'price_day' => 10000000.00,
            'price_hour' => 1000000.00,
            'type' => 'Outil expérimental du DoomGuy',
            'laboratory_id' => 2
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment}}');
    }
}
