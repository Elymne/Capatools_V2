<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%capa_user}}`.
 */
class m200100_000003_create_capa_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        /**
         * create table
         */
        $this->createTable('{{%capa_user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'email' => $this->string(),
            'auth_key' => $this->string(),
            'password_hash' => $this->string(),
            'cellule_id' => $this->integer(),
            'flag_password' => $this->boolean()
        ]);

        /**
         * alter table
         */
        $this->addForeignKey(
            'FK_capa_user_to_cellule',
            '{{%capa_user}}',
            'cellule_id',
            '{{%cellule}}',
            'id'
        );

        /**
         * feed table
         */
        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('toto');
        $this->insert('capa_user', [
            'id' => 1,
            'username' => 'toto',
            'email' => 'toto@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 1
        ]);

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('sacha');
        $this->insert('capa_user', [
            'id' => 2,
            'username' => 'sacha',
            'email' => 'sacha@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'cellule_id' => 3
        ]);

        /**
         * update table
         */
        $this->update('capa_user', ['flag_password' => false], ['id' => 1]);
        $this->update('capa_user', ['flag_password' => false], ['id' => 2]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%capa_user}}');
    }
}
