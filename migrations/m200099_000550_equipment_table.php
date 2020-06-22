<?php

use yii\db\Migration;

class m200099_000550_equipment_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%equipment}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'ht_price' => $this->double()->defaultValue(0),
            'type' => $this->string()->notNull(),

            // Foreign key.
            'laboratory_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_equipment-laboratory',
            '{{%equipment}}',
            'laboratoryid',
            '{{%laboratory}}',
            'id'
        );

        $this->insert('{{%equipment}}', [
            'name' => "Cuve à bière",
            'ht_price' => 1060.00,
            'type' => 'Outil expérimental',
            'laboratory_id' => 1
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
