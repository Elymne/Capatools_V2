<?php

use yii\db\Migration;

class m200100_000003_create_capa_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%capa_user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'email' => $this->string(),
            'auth_key' => $this->string(),
            'password_hash' => $this->string(),
            'cellule_id' => $this->integer(),
            'flag_password' => $this->boolean(),
            'flag_active' => $this->boolean()
        ]);

        $this->addForeignKey(
            'FK_capa_user_to_cellule',
            '{{%capa_user}}',
            'cellule_id',
            '{{%cellule}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_capa_user_to_cellule',
            '{{%capa_user}}'
        );

        $this->dropTable('{{%capa_user}}');
    }
}
