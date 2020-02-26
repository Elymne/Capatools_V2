<?php

use yii\db\Migration;

class m200200_000004_insert_into_user_role_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->insert('{{%user_role}}', [
            'role' => 'RH',
            'credential' => 'none',
            'user_id' => 1
        ]);

        $this->insert('{{%user_role}}', [
            'role' => 'Administration',
            'credential' => 'Responsable',
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
        $this->delete('{{%user_role}}');
    }
}
