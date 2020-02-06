<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%devis}}`.
 */
class m200206_100741_create_devis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%devis}}', [
            'id' => $this->primaryKey(),
            'id_capa' => $this->string(250),
            'internal_name' => $this->string(250),
            'service_duration' => $this->integer(),
            'version' => $this->integer(),
            'filename' => $this->string(250),
            'filename_first_upload' => $this->dateTime(),
            'filename_last_upload' => $this->dateTime(),
            'cellule_id' => $this->integer(),
            'company_id' => $this->integer(),
            'capaidentity_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'FK_devis_cellule',
            'devis',
            'cellule_id',
            '{{%Cellule}}',
            'id',
            $delete = null,
            $update = null
        );

        $this->addForeignKey(
            'FK_devis_company',
            'devis',
            'company_id',
            'company',
            'id',
            $delete = null,
            $update = null
        );

        $this->addForeignKey(
            'FK_devis_capaidentity',
            'devis',
            'capaidentity_id',
            'capaidentity',
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

        $this->dropForeignKey('FK_devis_unit', 'devis');

        $this->dropForeignKey('FK_devis_company', 'devis');

        $this->dropForeignKey('FK_devis_capaidentity', 'devis');

        $this->dropTable('{{%devis}}');
    }
}
