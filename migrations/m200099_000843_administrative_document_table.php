<?php

use yii\db\Migration;

class m200099_000843_administrative_document_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%administrative_document_table}}', [
            'id' => $this->string(),
            'title' => $this->integer()->notNull(),
            'internal_link' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'last_update_date' => $this->string(),


        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%administrative_document_table}}');
    }
}
