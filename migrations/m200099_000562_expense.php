<?php

use yii\db\Migration;

class m200099_000562_expense extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%expense}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'daily_price' => $this->double()->notNull(),
            'type' => $this->string()->notNull(),
            'project_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_expense-project',
            '{{%expense}}',
            'project_id',
            '{{%project}}',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%expense}}');
    }
}
