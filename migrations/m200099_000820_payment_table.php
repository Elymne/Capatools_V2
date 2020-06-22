<?php

use yii\db\Migration;

class m200099_000820_payment extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'lot_id' => $this->integer(),
            'prospecting_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'FK_payment-lot',
            '{{%payment}}',
            'lot_id',
            '{{%lot}}',
            'id'
        );

        $this->addForeignKey(
            'FK_payment-prospecting',
            '{{%payment}}',
            'prospecting_id',
            '{{%prospecting}}',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%expense}}');
    }
}
