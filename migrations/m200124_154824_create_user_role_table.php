<?php

use yii\db\Migration;

class m200124_154824_create_user_role_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        /**
         * create table
         */
        $this->createTable('{{%user_role}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string(),
            'credential'   => $this->string(),
            'user_id' => $this->integer()->notNull()
        ]);

        /**
         * alter table
         */
        $this->execute('ALTER TABLE cellule AUTO_INCREMENT = 1');

        $this->addForeignKey(
            'FK_capa_user_to_user_role',
            '{{%user_role}}',
            'user_id',
            '{{%capa_user}}',
            'id'
        );

        /**
         * feed table
         */
        $this->insert('{{%user_role}}', [
            'role' => 'RH',
            'credential' => 'none',
            'user_id' => 1
        ]);

        $this->insert('{{%user_role}}', [
            'role' => 'RH',
            'credential' => 'none',
            'user_id' => 2
        ]);

        $this->insert('{{%user_role}}', [
            'role' => 'Administration',
            'credential' => 'Responsable',
            'user_id' => 2
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
