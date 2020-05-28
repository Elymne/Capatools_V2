<?php

use yii\db\Migration;

class m200099_000530_cellule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Table creation. */

        $this->createTable('{{%cellule}}', [
            'id' => $this->primaryKey(),
            'identity' => $this->string(),
            'name' => $this->string(),
            'default_management_price' => $this->double()->defaultValue(0),
            'default_user_price' => $this->double()->defaultValue(0)
        ]);

        /* Table data insertion */

        $this->insert('{{%cellule}}', [
            'identity' => 'AIERA',
            'name' => 'IREALITE',
            'default_management_price' => 1500,
            'default_user_price' => 1100
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'ACMER',
            'name' => 'MER',
            'default_management_price' => 1500,
            'default_user_price' => 1100
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'ACAPT',
            'name' => 'CAPTEURS ET COMPOSITES',
            'default_management_price' => 1500,
            'default_user_price' => 1100
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'AIXEA',
            'name' => 'IXEAD',
            'default_management_price' => 7654,
            'default_user_price' => 7896
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%cellule}}', []);
        $this->dropTable('{{%cellule}}');
    }
}
