<?php

use yii\db\Migration;

class m200100_000002_create_cellule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%cellule}}', [
            'id' => $this->primaryKey(),
            'identity' => $this->string(),
            'name' => $this->string(),
        ]);

        $this->execute('ALTER TABLE cellule AUTO_INCREMENT = 1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cellule}}');
    }
}
