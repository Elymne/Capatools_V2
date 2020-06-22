<?php

use yii\db\Migration;

class m200099_000565_prospecting_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%prospecting}}', [

            'id' => $this->primaryKey()->notNull(),

            // Foreign key.
            'project_id' => $this->integer()->notNull()
        ]);

        // De prospecting vers projet.
        $this->addForeignKey(
            'FK_prospecting-project',
            '{{%prospecting}}',
            'project_id',
            '{{%project}}',
            'id'
        );

        // De project vers prospecting.
        $this->addForeignKey(
            'FK_project-prospecting',
            '{{%project}}',
            'prospecting_id',
            '{{%prospecting}}',
            'id'
        );

        $this->insert('{{%prospecting}}', [
            'id' => 1,
            'project_id' => 1
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_prospecting-projet',
            '{{%prospecting}}'
        );

        $this->dropForeignKey(
            'FK_project-prospecting',
            '{{%project}}'
        );

        $this->dropTable('{{%prospecting}}');
    }
}
