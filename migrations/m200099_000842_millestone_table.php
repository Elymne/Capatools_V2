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
