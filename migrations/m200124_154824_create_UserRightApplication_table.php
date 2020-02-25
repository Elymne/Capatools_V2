<?php

use yii\db\Migration;

class m200124_154824_create_UserRightApplication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%UserRightApplication}}', [
            'id' => $this->primaryKey(),
            'Userid' => $this->integer()->notNull(),
            'Application' => $this->string(),
            'Credential'   => $this->string()
        ]);

        // ajoute un clé étrangère vers la table `user`
        $this->addForeignKey(
            'fk_capa_user_to_UserRightApplication',
            '{{%UserRightApplication}}',
            'Userid',
            '{{%capa_user}}',
            'id',
            'CASCADE'
        );


        $this->insert('{{%UserRightApplication}}', [
            'id' => '1',
            'Userid' => '1',
            'Application' => 'RH',
            'Credential' => 'Aucun'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%UserRightApplication}}');
    }
}
