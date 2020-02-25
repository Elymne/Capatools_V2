<?php

use yii\db\Migration;

class m200100_000006_create_devis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%devis}}', [
            'id' => $this->primaryKey(),
            'id_capa' => $this->string(250)->notNull(),
            'internal_name' => $this->string(250)->notNull(),
            'service_duration' => $this->integer()->defaultValue(0),
            'version' => $this->integer()->defaultValue(0),
            'filename' => $this->string(250)->defaultValue(null),
            'filename_first_upload' => $this->dateTime()->defaultValue(null),
            'filename_last_upload' => $this->dateTime()->defaultValue(null),
            'cellule_id' => $this->integer()->notNull(),
            'company_id' => $this->integer()->notNull(),
            'capa_user_id' => $this->integer()->notNull(),
            'price' => $this->double(),
            'delivery_type_id' => $this->integer(),
            'id_laboxy' => $this->string(),
            'status_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'FK_devis_cellule',
            '{{%devis}}',
            'cellule_id',
            '{{%cellule}}',
            'id',
            $delete = null,
            $update = null
        );

        $this->addForeignKey(
            'FK_devis_company',
            '{{%devis}}',
            'company_id',
            '{{%company}}',
            'id',
            $delete = null,
            $update = null
        );

        $this->addForeignKey(
            'FK_devis_capa_user',
            '{{%devis}}',
            'capa_user_id',
            '{{%capa_user}}',
            'id',
            $delete = null,
            $update = null
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('FK_devis_unit', '{{%devis}}');

        $this->dropForeignKey('FK_devis_company', '{{%devis}}');

        $this->dropForeignKey('FK_devis_capa_user', '{{%devis}}');

        $this->dropTable('{{%devis}}');
    }
}
