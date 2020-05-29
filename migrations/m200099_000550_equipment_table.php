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
            'type' => $this->string()->notNull()
        ]);

        $this->insert('{{%equipment}}', [
            'name' => "Cuve à bière",
            'ht_price' => 1060.00,
            'type' => 'Outil expérimental'
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
