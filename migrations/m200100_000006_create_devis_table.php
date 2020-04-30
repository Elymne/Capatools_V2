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
            // Auto-generated.
            'id' => $this->primaryKey(),
            'id_capa' => $this->string(250)->notNull(),

            // Generated when created.
            'creation_date' => $this->date()->notNull(),

            'internal_name' => $this->string(250)->notNull(),
            'laboratory_proposal' => $this->string(250),

            'service_duration' => $this->integer()->defaultValue(0),
            'validity_duration' => $this->integer()->defaultValue(0),
            'payment_conditions' => $this->string(250),
            'payment_details' => $this->string(250),
            'price' => $this->double(),

            'delivery_type_id' => $this->integer(),

            'id_laboxy' => $this->string(),
            'status_id' => $this->integer(),

            // FK - devis
            'cellule_id' => $this->integer()->notNull(),
            'company_id' => $this->integer()->notNull(),
            'capa_user_id' => $this->integer()->notNull(),

            // File management.
            'version' => $this->integer()->defaultValue(0),
            'filename' => $this->string(250)->defaultValue(null),
            'filename_first_upload' => $this->dateTime()->defaultValue(null),
            'filename_last_upload' => $this->dateTime()->defaultValue(null),
        ]);

        $this->addForeignKey(
            'FK_devis-cellule',
            '{{%devis}}',
            'cellule_id',
            '{{%cellule}}',
            'id',
            $delete = null,
            $update = null
        );

        $this->addForeignKey(
            'FK_devis-company',
            '{{%devis}}',
            'company_id',
            '{{%company}}',
            'id',
            $delete = null,
            $update = null
        );

        $this->addForeignKey(
            'FK_devis-capa_user',
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

        $this->dropForeignKey('FK_devis-cellule', '{{%devis}}');

        $this->dropForeignKey('FK_devis-company', '{{%devis}}');

        $this->dropForeignKey('FK_devis-capa_user', '{{%devis}}');

        $this->dropTable('{{%devis}}');
    }
}
