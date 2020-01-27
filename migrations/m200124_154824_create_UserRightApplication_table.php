<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%UserRightApplication}}`.
 */
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
                'fk-post_tag-post_id',
                '{{%UserRightApplication}}',
                'Userid',
                'capaidentity',
                'id',
                'CASCADE'
            );
 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%UserRightApplication}}');
    }
}
