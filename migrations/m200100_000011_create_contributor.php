<?php

use yii\db\Migration;

class m200100_000011_create_contributor extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%contributor}}', [
            'id' => $this->primaryKey(),
            'capa_user_id' => $this->integer()->notNull(),
            'devis_id' => $this->integer()->notNull(),
            'nb_day' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_contributor-capa_user',
            '{{%contributor}}',
            'capa_user_id',
            '{{%capa_user}}',
            'id',
            $delete = null,
            $update = null
        );

        $this->addForeignKey(
            'FK_contributor-devis',
            '{{%contributor}}',
            'devis_id',
            '{{%devis}}',
            'id',
            $delete = null,
            $update = null
        );
    }

    public function safeDown()
    {
    }
}
