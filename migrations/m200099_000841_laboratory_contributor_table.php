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
            'price' => $this->integer()->defaultValue(0),
            'time_risk' => $this->integer()->defaultValue(0),

            // Foreign key.
            'laboratory_id' => $this->integer()->notNull(),
            'repayment_id' => $this->integer()->notNull(),
            'risk_id' => $this->integer()->notNull(),
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

        $this->addForeignKey(
            'laboratory_contributor-risk',
            '{{%laboratory_contributor}}',
            'risk_id',
            '{{%risk}}',
            'id'
        );

        $this->insert('{{%laboratory_contributor}}', [
            'type' => 'stagiaire',
            'nb_days' => 20,
            'nb_hours' => 19,
            'price' => 300,
            'time_risk' => 15,
            'laboratory_id' => 1,
            'repayment_id' => 1,
            'risk_id' => 3
        ]);

        $this->insert('{{%laboratory_contributor}}', [
            'type' => 'stagiaire',
            'nb_days' => 20,
            'nb_hours' => 19,
            'price' => 300,
            'time_risk' => 15,
            'laboratory_id' => 1,
            'repayment_id' => 2,
            'risk_id' => 1
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%laboratory_contributor}}');
    }
}
