<?php

use yii\db\Migration;

use yii\base\Security;

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
            'auth_key' => $this->string(),
            'password_hash' => $this->string(),

        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('toto');

        $this->insert('capaidentity', [
            'id' => '1',
            'username' => 'toto',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash
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
