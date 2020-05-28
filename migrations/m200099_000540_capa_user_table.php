<?php

use yii\db\Migration;

class m200099_000540_capa_user_table extends Migration
{

    public function safeUp()
    {
        /* Table creation */

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
            'flag_password' => $this->boolean()->defaultValue(false),
            'flag_active' => $this->boolean()->defaultValue(true)
        ]);

        /* Table alteration */

        $this->addForeignKey(
            'FK_capa_user-cellule',
            '{{%capa_user}}',
            'cellule_id',
            '{{%cellule}}',
            'id'
        );

        /* Table data insertion */

        $this->insert('{{%capa_user}}', [
            'id' => 1,
            'firstname' => "Lars ",
            'surname' => "Von Trier",
            'email' => 'salarie@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  Yii::$app->getSecurity()->generatePasswordHash('salarie'),
            'price' => 1100,
            'cellule_id' => 1
        ]);

        $this->insert('{{%capa_user}}', [
            'id' => 2,
            'firstname' => "Björk",
            'surname' => "Guðmundsdóttir",
            'email' => 'projet_manager@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('projet_manager'),
            'price' => 1100,
            'cellule_id' => 3
        ]);

        $this->insert('{{%capa_user}}', [
            'id' => 3,
            'firstname' => "Gérard Xavier Marcel",
            'surname' => "Depardieu",
            'email' => 'resp_cellule@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('resp_cellule'),
            'price' => 1100,
            'cellule_id' => 3
        ]);

        $this->insert('{{%capa_user}}', [
            'id' => 4,
            'firstname' => "Bernardo",
            'surname' => "Bertolucci",
            'email' => 'rh@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('rh'),
            'price' => 1100,
            'cellule_id' => 3
        ]);

        $this->insert('{{%capa_user}}', [
            'id' => 5,
            'firstname' => "David",
            'surname' => "Lynch",
            'email' => 'support@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  Yii::$app->getSecurity()->generatePasswordHash('support'),
            'price' => 1100,
            'cellule_id' => 3
        ]);

        $this->insert('{{%capa_user}}', [
            'id' => 6,
            'firstname' => "Georges",
            'surname' => "Brassens",
            'email' => 'admin@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'price' => 1222,
            'cellule_id' => 3
        ]);

        $this->insert('{{%capa_user}}', [
            'id' => 7,
            'firstname' => "Hans Ruedi",
            'surname' => "Giger",
            'email' => 'super_admin@gmail.com',
            'auth_key' => 'test100key',
            'password_hash' =>  Yii::$app->getSecurity()->generatePasswordHash('super_admin'),
            'cellule_id' => 3
        ]);
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

        $this->delete('{{%capa_user}}', []);
        $this->dropTable('{{%capa_user}}');
    }
}
