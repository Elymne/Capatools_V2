<?php

use yii\db\Migration;

class m200099_000520_expense extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%expense}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'daily_price' => $this->double()->notNull(),
            'type' => $this->string()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%expense}}');
    }
}
