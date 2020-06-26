<?php

use yii\db\Migration;

class m200099_000843_risk_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%risk}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'coeficient' => $this->double()->notNull(),

        ]);

        $this->insert('{{%risk}}', [
            'title' => "Normale",
            'coeficient' => 1,
        ]);

        $this->insert('{{%risk}}', [
            'title' => "Moderée",
            'coeficient' => 1.5,
        ]);


        $this->insert('{{%risk}}', [
            'title' => "Importante",
            'coeficient' => 3,
        ]);
        $this->insert('{{%risk}}', [
            'title' => "Très importante",
            'coeficient' => 4,
        ]);
    }
    public function safeDown()
    {
        $this->dropTable('{{%risk}}');
    }
}
