<?php

use yii\db\Migration;

class m200099_000840_equipment_payment_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%equipment_payment}}', [
            'id' => $this->primaryKey(),
            'nb_days' => $this->string()->notNull(),
            'nb_hour' => $this->integer()->defaultValue(0),
            'risk' => $this->string()->notNull(),
            'risk_days' => $this->integer()->defaultValue(0),

            // Foreign key.
            'equipment_id' => $this->integer()->notNull(),
            'payment_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_equipment_payment-equipment',
            '{{%equipment_payment}}',
            'lot_id',
            '{{%equipment}}',
            'id'
        );

        $this->addForeignKey(
            'FK_equipment_payment-payment',
            '{{%equipment_payment}}',
            'lot_id',
            '{{%payment}}',
            'id'
        );

        $this->insert('{{%task_management}}', [
            'lot_number' => 1,
            'nb_days' => $this->integer()->defaultValue(0),
            'nb_hours' => $this->integer()->defaultValue(0),
            'risk' => 'Normal',
            'risk_days' => 15,
            'equipment_id' => 1,
            'payment_id' => 1
        ]);
    }

    public function safeDown()
    {

        $this->dropForeignKey(
            'FK_task_management-lot',
            '{{%task}}'
        );

        $this->dropTable('{{%task_management}}');
    }
}
