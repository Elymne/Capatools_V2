<?php

use yii\db\Migration;

class m200099_000480_risk_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%risk}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'coefficient' => $this->double()->notNull(),

        ]);

        $this->insert('{{%risk}}', [
            'title' => "Normale",
            'coefficient' => 1,
        ]);

        $this->insert('{{%risk}}', [
            'title' => "Moderée",
            'coefficient' => 1.25,
        ]);


        $this->insert('{{%risk}}', [
            'title' => "Importante",
            'coefficient' => 1.75,
        ]);
        $this->insert('{{%risk}}', [
            'title' => "Très importante",
            'coefficient' => 2,
        ]);
    }
    public function safeDown()
    {
        $this->dropTable('{{%risk}}');
    }
}
