<?php

use yii\db\Migration;

class m200200_000003_insert_into_capa_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('toto');
        $this->insert('{{%capa_user}}', [
            'id' => 1,
            'username' => 'toto',
            'email' => 'toto@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 1
        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('sacha');
        $this->insert('{{%capa_user}}', [
            'id' => 2,
            'username' => 'sacha',
            'email' => 'sacha@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 3
        ]);

        $this->update('{{%capa_user}}', ['flag_password' => false], ['id' => 1]);
        $this->update('{{%capa_user}}', ['flag_password' => false], ['id' => 2]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%capa_user}}');
    }
}
