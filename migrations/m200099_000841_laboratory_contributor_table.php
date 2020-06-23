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
            'repayment_id',
            '{{%repayment}}',
            'id'
        );

        $this->insert('{{%laboratory_contributor}}', [
            'type' => 'stagiaire',
            'nb_days' => 20,
            'nb_hours' => 19,
            'price_day' => 300,
            'price_hour' => 20,
            'risk' => 'Haute',
            'risk_day' => 15,
            'risk_hour' => 12,
            'laboratory_id' => 1,
            'repayment_id' => 1
        ]);

        $this->insert('{{%laboratory_contributor}}', [
            'type' => 'stagiaire',
            'nb_days' => 20,
            'nb_hours' => 19,
            'price_day' => 300,
            'price_hour' => 20,
            'risk' => 'Normale',
            'risk_day' => 15,
            'risk_hour' => 12,
            'laboratory_id' => 1,
            'repayment_id' => 2
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%laboratory_contributor}}');
    }
}
