<?php

use yii\db\Migration;

class m200099_000841_laboratory_contributor_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%laboratory_contributor}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
            'nb_days' => $this->integer()->defaultValue(0),
            'nb_hours' => $this->integer()->defaultValue(0),
            'price_day' => $this->string()->notNull(),
            'price_hour' => $this->integer(),
            'risk' => $this->string()->notNull(),
            'risk_day' => $this->integer(0),
            'risk_hour' => $this->integer(0),

            // Foreign key.
            'laboratory_id' => $this->integer()->notNull(),
            'repayment_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_laboratory_contributor-laboratory',
            '{{%laboratory_contributor}}',
            'laboratory_id',
            '{{%laboratory}}',
            'id'
        );

        $this->addForeignKey(
            'FK_laboratory_contributor-payment',
            '{{%laboratory_contributor}}',
            'payment_id',
            '{{%payment}}',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%laboratory_contributor}}');
    }
}
