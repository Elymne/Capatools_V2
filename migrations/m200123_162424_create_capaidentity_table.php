<?php

use yii\db\Migration;

use yii\base\Security;

/**
 * Handles the creation of table `{{%capaidentity}}`.
 */
class m200123_162424_create_capaidentity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%capaidentity}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'email' => $this->string(),
            'auth_key' => $this->string(),
            'password_hash' => $this->string(),
            'Celluleid' => $this->integer()
        ]);

        // ajoute un clé étrangère`
        $this->addForeignKey(
            'fk-capaidentity_-Cellule',
            '{{%capaidentity}}',
            'Celluleid',
            'cellule',
            'id'
        );

        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('toto');

        $this->insert('capaidentity', [
            'id' => '1',
            'username' => 'toto',
            'email' => 'toto@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  $password_hash,
            'Celluleid' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%capaidentity}}');
    }
}
