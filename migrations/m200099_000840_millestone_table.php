<?php

use yii\db\Migration;

class m200099_000840_millestone_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%millestone}}', [
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
            'project_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_millestone-project',
            '{{%millestone}}',
            'project_id',
            '{{%project}}',
            'id'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%millestone}}');
    }
}
