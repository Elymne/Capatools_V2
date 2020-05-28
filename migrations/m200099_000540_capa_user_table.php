<?php

use yii\db\Migration;

class m200099_000540_capa_user_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%capa_user}}', [
            'id' => $this->primaryKey(),

            'firstname' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'email' => $this->string(),
            'password_hash' => $this->string(),
            'price' => $this->double()->defaultValue(0),

            // Foreign key.
            'cellule_id' => $this->integer(),

            // Yii2 user management values.
            'auth_key' => $this->string(),
            'flag_password' => $this->boolean(),
            'flag_active' => $this->boolean()
        ]);

        $this->addForeignKey(
            'FK_capa_user-cellule',
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
            'FK_capa_user-cellule',
            '{{%capa_user}}'
        );

        $this->dropTable('{{%capa_user}}');
    }
}
