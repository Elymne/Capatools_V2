<?php

use yii\db\Migration;

class m200099_000585_investment extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%investment}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->double()->notNull(),
            'lot_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_investment-lot',
            '{{%investment}}',
            'lot_id',
            '{{%lot}}',
            'id'
        );

        $this->insert('{{%lot}}', [
            'name' => "Achat de jambon de haute qualité",
            'price' => 100,
            'lot_id' => 1,
        ]);

        $this->insert('{{%lot}}', [
            'name' => "Frais de loyer du chalet",
            'price' => 1230000,
            'lot_id' => 1,
        ]);

        $this->insert('{{%lot}}', [
            'name' => "La taxe",
            'price' => 140,
            'lot_id' => 2,
        ]);
    }

    public function safeDown()
    {

        $this->dropForeignKey(
            'FK_investment-lot',
            '{{%investment}}'
        );

        $this->dropTable('{{%investment}}');
    }
}
