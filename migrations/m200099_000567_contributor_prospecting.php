<?php

use yii\db\Migration;

class m200099_000567_contributor_prospecting extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%contributor_prospecting}}', [
            'id' => $this->primaryKey(),
            'nb_days' => $this->integer()->defaultValue(0),
            'nb_hours' => $this->integer()->defaultValue(0),
            'hour_price' => $this->double()->defaultValue(0),
            'risk' => $this->string()->notNull(),
            'risk_day' => $this->integer()->defaultValue(0),

            // Foreign key.
            'prospecting_id' => $this->integer()->notNull(),
            'capa_user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_contributor_prospecting-prospecting',
            '{{%contributor_prospecting}}',
            'prospecting_id',
            '{{%prospecting}}',
            'id'
        );

        $this->addForeignKey(
            'FK_contributor_prospecting-capa_user',
            '{{%contributor_prospecting}}',
            'capa_user_id',
            '{{%capa_user}}',
            'id'
        );

        $this->insert('{{%task_prospecting}}', [
            'nb_days' => 8,
            'nb_hours' => 12,
            'hour_price' => 234,
            'risk' => 'Normale',
            'risk_days' => 21,
            'prospecting_id' => 1,
            'capa_user_id' => 2,
        ]);

        $this->insert('{{%task_prospecting}}', [
            'nb_days' => 8,
            'nb_hours' => 12,
            'hour_price' => 234,
            'risk' => 'Haute',
            'risk_days' => 21,
            'prospecting_id' => 1,
            'capa_user_id' => 3,
        ]);
    }

    public function safeDown()
    {

        $this->dropForeignKey(
            'FK_task_prospecting-prospecting',
            '{{%task_prospecting}}'
        );

        $this->dropTable('{{%task_prospecting}}');
    }
}
