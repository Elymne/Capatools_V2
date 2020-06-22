<?php

use yii\db\Migration;

class m200099_000545_laboratory_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%laboratory}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price_contributor_day' => $this->double()->defaultValue(0),
            'price_contributor_hour' => $this->double()->defaultValue(0),
            'price_ec_day' => $this->double()->defaultValue(0),
            'price_ec_hour' => $this->double()->defaultValue(0),

            // Foreign key.
            'cellule_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_laboratory-cellule',
            '{{%laboratory}}',
            'cellule_id',
            '{{%cellule}}',
            'id'
        );

        $this->insert('{{%equipment}}', [
            'name' => "Le laboratoire de Dexter, oui le jeune garçon le plus doué",
            'price_contributor_day' => 234,
            'price_contributor_hour' => 23,
            'price_ec_day' => 987,
            'price_ec_hour' => 8888,
            'cellule_id' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment}}');
    }
}
