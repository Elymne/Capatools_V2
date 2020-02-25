<?php

use yii\db\Migration;

class m200124_154824_create_user_role_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_role}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string(),
            'credential'   => $this->string(),
            'user_id' => $this->integer()->notNull()
        ]);

        // ajoute un clé étrangère vers la table `user`
        $this->addForeignKey(
            'FK_capa_user_to_user_role',
            '{{%user_role}}',
            'user_id',
            '{{%capa_user}}',
            'id'
        );


        $this->insert('{{%user_role}}', [
            'id' => '1',
            'role' => 'RH',
            'credential' => 'aucuns',
            'user_id' => '1'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_role}}');
    }
}
