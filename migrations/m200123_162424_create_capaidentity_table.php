<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%capaidentity}}`.
 */
class m200123_162424_create_capaidentity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%capaidentity}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'name' => $this->string(),
            'password' => $this->string(),
            'auth_key' => $this->string(),
            'password_hash' => $this->string(),

        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%capaidentity}}');
    }
}
