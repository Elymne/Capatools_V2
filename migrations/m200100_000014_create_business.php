<?php

use yii\db\Migration;

class m200100_000014_create_business extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%business}}', [
            'id' => $this->primaryKey()
        ]);
    }

    public function safeDown()
    {
    }
}
