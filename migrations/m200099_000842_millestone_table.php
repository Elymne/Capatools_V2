<?php

use yii\db\Migration;

class m200099_000842_millestone_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%millestone}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull(),
            'comment' => $this->string()->notNull(),
            'pourcentage' => $this->double()->notNull(),
            'price' => $this->double()->notNull(),
            'statut' => $this->string()->notNull(),
            'estimate_date' => $this->string(),
            'last_update_date' => $this->string(),

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

        $this->insert('{{%millestone}}', [
            'id' => 1,
            'number' => 1,
            'comment' => 'Jalon 1',
            'pourcentage' => 40,
            'price' => 1200,
            'statut' => 'en cours',
            'estimate_date' => '2020-09-01',
            'last_update_date' => '2020-09-01',

            'project_id' => 1
        ]);

        $this->insert('{{%millestone}}', [
            'id' => 2,
            'number' => 2,
            'comment' => 'Jalon 2',
            'pourcentage' => 60,
            'price' => 1200,
            'statut' => 'en cours',
            'estimate_date' => '2021-09-01',
            'last_update_date' => '2020-09-01',

            'project_id' => 1
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%millestone}}');
    }
}
