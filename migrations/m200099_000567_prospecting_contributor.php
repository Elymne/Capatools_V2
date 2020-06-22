<?php

use yii\db\Migration;

class m200099_000567_prospecting_contributor extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%prospecting_contributor}}', [
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
            'FK_prospecting_contributor-prospecting',
            '{{%prospecting_contributor}}',
            'prospecting_id',
            '{{%prospecting}}',
            'id'
        );

        $this->addForeignKey(
            'FK_prospecting_contributor-capa_user',
            '{{%prospecting_contributor}}',
            'capa_user_id',
            '{{%capa_user}}',
            'id'
        );

        $this->insert('{{%prospecting_contributor}}', [
            'nb_days' => 8,
            'nb_hours' => 12,
            'hour_price' => 234,
            'risk' => 'Normale',
            'risk_days' => 21,
            'prospecting_id' => 1,
            'capa_user_id' => 2,
        ]);

        $this->insert('{{%prospecting_contributor}}', [
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
            'FK_prospecting_contributor-prospecting',
            '{{%prospecting_contributor}}'
        );

        $this->dropTable('{{%prospecting_contributor}}');
    }
}
