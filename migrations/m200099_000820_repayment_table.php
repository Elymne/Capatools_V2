<?php

use yii\db\Migration;

class m200099_000820_repayment_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%repayment}}', [
            'id' => $this->primaryKey(),
            'lot_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'FK_repayment-lot',
            '{{%repayment}}',
            'lot_id',
            '{{%lot}}',
            'id'
        );

        $this->insert('{{%repayment}}', [
            'id' => 1,
            'lot_id' => 1,
        ]);

        $this->insert('{{%repayment}}', [
            'id' => 2,
            'lot_id' => 2,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%repayment}}');
    }
}
