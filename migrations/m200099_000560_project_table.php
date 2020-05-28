<?php

use yii\db\Migration;

class m200099_000560_project_table extends Migration
{

    public function safeUp()
    {

        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),

            'id_capa' => $this->string()->notNull(),
            'id_laboxy' => $this->string(),

            'internal_name' => $this->string()->notNull(),
            'internal_reference' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'prospecting_time_day' => $this->integer()->defaultValue(0),
            'signing_probability' => $this->integer()->defaultValue(25),

            'state' => $this->string()->notNull(),
            'version' => $this->string()->notNull(),
            'date_version' => $this->date()->notNull(),
            'file_path' => $this->string(),

            // Should be generated when created.
            'creation_date' => $this->date()->notNull(),

            /* FK - devis */
            // La cellule rataché au projet.
            'cellule_id' => $this->integer()->notNull(),
            // Le client, la société, la demande.
            'company_id' => $this->integer()->notNull(),
            // Le contacte client.
            'contact_id' => $this->integer()->notNull(),
            // Le chef de projet.
            'capa_user_id' => $this->integer()->notNull(),

        ]);

        $this->addForeignKey(
            'FK_project-cellule',
            '{{%project}}',
            'cellule_id',
            '{{%cellule}}',
            'id'
        );

        $this->addForeignKey(
            'FK_project-company',
            '{{%project}}',
            'company_id',
            '{{%company}}',
            'id'
        );

        $this->addForeignKey(
            'FK_project-capa_user',
            '{{%project}}',
            'capa_user_id',
            '{{%capa_user}}',
            'id'
        );

        $this->addForeignKey(
            'FK_project-contact',
            '{{%project}}',
            'capa_user_id',
            '{{%contact}}',
            'id',

        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('FK_project-contact', '{{%project}}');

        $this->dropForeignKey('FK_project-capa_user', '{{%project}}');

        $this->dropForeignKey('FK_project-company', '{{%project}}');

        $this->dropForeignKey('FK_project-cellule', '{{%project}}');

        $this->dropTable('{{%project}}');
    }
}
