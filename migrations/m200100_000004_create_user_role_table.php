<?php

use yii\db\Migration;

class m200100_000004_create_user_role_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%user_role}}', [
            'id' => $this->primaryKey(),
            'service' => $this->string(),
            'role'   => $this->string(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->execute('ALTER TABLE cellule AUTO_INCREMENT = 1');

        $this->addForeignKey(
            'FK_capa_user_to_user_role',
            '{{%user_role}}',
            'user_id',
            '{{%capa_user}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'FK_capa_user_to_user_role',
            '{{%user_role}}'
        );

        $this->dropTable('{{%user_role}}');
    }
}
