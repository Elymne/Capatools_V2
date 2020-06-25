<?php

use yii\db\Migration;

class m200099_000580_lot_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%lot}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->defaultValue(0),
            'title' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
            'comment' => $this->string(),

            // Foreign key.
            'project_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_lot-projet',
            '{{%lot}}',
            'project_id',
            '{{%project}}',
            'id'
        );

        $this->insert('{{%lot}}', [
            'number' => 1,
            'title' => "lot numéro 1 : évasion",
            'status' => 'En cours',
            'comment' => 'Petit lot pour s\'évader',
            'project_id' => 1
        ]);

        $this->insert('{{%lot}}', [
            'number' => 2,
            'title' => "lot numéro 2 : vacances",
            'status' => 'En cours',
            'comment' => 'Petit lot pour prendre des vacances',
            'project_id' => 1
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_lot-projet',
            '{{%lot}}'
        );

        $this->dropTable('{{%lot}}');
    }
}
