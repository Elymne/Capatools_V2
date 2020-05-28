<?php

use yii\db\Migration;

class m200200_000003_insert_into_capa_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('salarie');
        $this->insert('{{%capa_user}}', [
            'id' => 1,
            'username' => 'salarie',
            'email' => 'salarie@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 1
        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('projet_manager');
        $this->insert('{{%capa_user}}', [
            'id' => 2,
            'username' => 'projet_manager',
            'email' => 'projet_manager@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 3
        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('resp_cellule');
        $this->insert('{{%capa_user}}', [
            'id' => 3,
            'username' => 'resp_cellule',
            'email' => 'resp_cellule@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 3
        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('rh');
        $this->insert('{{%capa_user}}', [
            'id' => 4,
            'username' => 'rh',
            'email' => 'rh@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 3
        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('support');
        $this->insert('{{%capa_user}}', [
            'id' => 5,
            'username' => 'support',
            'email' => 'support@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 3
        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('admin');
        $this->insert('{{%capa_user}}', [
            'id' => 6,
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 3
        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('super_admin');
        $this->insert('{{%capa_user}}', [
            'id' => 7,
            'username' => 'super_admin',
            'email' => 'super_admin@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 3
        ]);

        $this->update('{{%capa_user}}', ['flag_password' => false], ['id' => 1]);
        $this->update('{{%capa_user}}', ['flag_password' => false], ['id' => 2]);
        $this->update('{{%capa_user}}', ['flag_password' => false], ['id' => 3]);
        $this->update('{{%capa_user}}', ['flag_password' => false], ['id' => 4]);
        $this->update('{{%capa_user}}', ['flag_password' => false], ['id' => 5]);
        $this->update('{{%capa_user}}', ['flag_password' => false], ['id' => 178]);
        $this->update('{{%capa_user}}', ['flag_active' => true], []);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%capa_user}}');
    }
}
