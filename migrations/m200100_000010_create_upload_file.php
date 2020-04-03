<?php

use yii\db\Migration;

class m200100_000010_create_upload_file extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%upload_file}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'type' => $this->string(),
            'version' => $this->integer()->notNull(),
            'devis_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_upload_file-cellule',
            '{{%upload_file}}',
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
