<?php

use yii\db\Migration;

class m200099_000585_expense extends Migration
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
    }

    public function safeDown()
    {
        $this->dropTable('{{%expense}}');
    }
}
