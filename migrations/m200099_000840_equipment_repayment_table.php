<?php

use yii\db\Migration;

class m200099_000840_equipment_repayment_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%equipment_repayment}}', [
            'id' => $this->primaryKey(),
            'nb_days' => $this->string()->notNull(),
            'nb_hours' => $this->integer()->defaultValue(0),
            'risk' => $this->string()->notNull(),
            'risk_days' => $this->integer()->defaultValue(0),

            // Foreign key.
            'equipment_id' => $this->integer()->notNull(),
            'repayment_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_equipment_repayment-equipment',
            '{{%equipment_repayment}}',
            'equipment_id',
            '{{%equipment}}',
            'id'
        );

        $this->addForeignKey(
            'FK_equipment_repayment-repayment',
            '{{%equipment_repayment}}',
            'repayment_id',
            '{{%repayment}}',
            'id'
        );

        $this->insert('{{%equipment_repayment}}', [
            'nb_days' => 20,
            'nb_hours' => 19,
            'risk' => 'Haute',
            'risk_days' => 15,
            'equipment_id' => 1,
            'repayment_id' => 1
        ]);

        $this->insert('{{%equipment_repayment}}', [
            'nb_days' => 2000,
            'nb_hours' => 1,
            'risk' => 'Très haute',
            'risk_days' => 239,
            'equipment_id' => 2,
            'repayment_id' => 2
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
