<?php

use yii\db\Migration;

class m200099_000585_expense extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%expense}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->double()->notNull(),
            'type' => $this->string()->notNull(),
            'lot_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_expense-lot',
            '{{%expense}}',
            'lot_id',
            '{{%lot}}',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%expense}}');
    }
}
