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
            'rate_human_margin' => $this->double()->defaultValue(30),
            'rate_repayement_margin' => $this->double()->defaultValue(30),
            'rate_consumable_investement_margin' => $this->double()->defaultValue(1),

            // Foreign key.
            'project_id' => $this->integer()->notNull(),
            'laboratory_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'FK_lot-projet',
            '{{%lot}}',
            'project_id',
            '{{%project}}',
            'id'
        );

        $this->addForeignKey(
            'FK_lot-laboratory',
            '{{%lot}}',
            'laboratory_id',
            '{{%laboratory}}',
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
        $this->insert('{{%lot}}', [
            'number' => 0,
            'title' => "Avant projet",
            'status' => 'En cours',
            'comment' => 'Temps de chiffrage à la maison',
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
