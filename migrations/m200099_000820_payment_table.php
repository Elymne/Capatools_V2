<?php

use yii\db\Migration;

//TODO renommer cette table.
class m200099_000820_payment extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'lot_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'FK_payment-lot',
            '{{%payment}}',
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
