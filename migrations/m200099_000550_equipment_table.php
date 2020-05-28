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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment}}');
    }
}
