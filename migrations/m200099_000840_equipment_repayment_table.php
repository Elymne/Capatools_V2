<?php

use yii\db\Migration;

class m200099_000840_equipment_repayment_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%equipment_repayment}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'daily_price' => $this->double()->defaultValue(0),
            'nb_days' => $this->integer()->notNull(),
            'nb_hours' => $this->integer()->defaultValue(0),
            'risk_coefficient' => $this->double()->defaultValue(1.00),

            'price' => $this->double()->defaultValue(0),
            'time_risk' => $this->integer()->defaultValue(0),

            // Foreign key.
            'lot_id' => $this->integer()->notNull(),
            'risk_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_equipment_repayment-lot',
            '{{%equipment_repayment}}',
            'lot_id',
            '{{%lot}}',
            'id'
        );

        $this->addForeignKey(
            'FK_equipment_repayment-risk',
            '{{%equipment_repayment}}',
            'risk_id',
            '{{%risk}}',
            'id'
        );

        $this->insert('{{%equipment_repayment}}', [
            'name' => 'Voiture moche',
            'daily_price' => 1000,
            'nb_days' => 20,
            'nb_hours' => 19,
            'risk_coefficient' => 1,
            'price' => 200,
            'time_risk' => 15,
            'lot_id' => 1,
            'risk_id' => 1
        ]);

        $this->insert('{{%equipment_repayment}}', [
            'name' => 'Voiture un peu stylé',
            'daily_price' => 100000,
            'nb_days' => 2000,
            'nb_hours' => 1,
            'risk_coefficient' => 1,
            'price' => 1000,
            'time_risk' => 239,
            'lot_id' => 2,
            'risk_id' => 1
        ]);
    }

    public function safeDown()
    {

        $this->dropForeignKey(
            'FK_task_management-lot',
            '{{%equipment_payment}}'
        );

        $this->dropTable('{{%equipment_payment}}');
    }
}
