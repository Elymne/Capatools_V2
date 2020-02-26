<?php

use yii\db\Migration;

class m200100_000008_create_milestone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%milestone}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
            'price' => $this->double(),
            'delivery_date' => $this->date(),
            'comments' => $this->text(),
            'milestone_status_id' => $this->integer(),
            'devis_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%milestone}}');
    }
}
