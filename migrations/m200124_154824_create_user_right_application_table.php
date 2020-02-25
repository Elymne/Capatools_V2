<?php

use yii\db\Migration;

class m200124_154824_create_user_right_application_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_right_application}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string(),
            'credential'   => $this->string(),
            'user_id' => $this->integer()->notNull()
        ]);

        // ajoute un clé étrangère vers la table `user`
        $this->addForeignKey(
            'FK_capa_user_to_user_right_application',
            '{{%user_right_application}}',
            'user_id',
            '{{%capa_user}}',
            'id'
        );


        $this->insert('{{%user_right_application}}', [
            'id' => '1',
            'role' => 'RH',
            'credential' => 'Aucun',
            'user_id' => '1'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_right_application}}');
    }
}
