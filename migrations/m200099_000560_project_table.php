<?php

use app\models\projects\Project;
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
            'signing_probability' => $this->integer()->defaultValue(25),
            'managment_rate' => $this->integer()->defaultValue(0),

            'state' => $this->string()->notNull(),
            'version' => $this->string()->notNull(),
            'date_version' => $this->date()->notNull(),
            'file_path' => $this->string(),

            // Options for project.
            'draft' => $this->boolean()->defaultValue(true),
            'laboratory_repayment' => $this->boolean()->defaultValue(true),

            // Should be generated when created.
            'creation_date' => $this->date()->notNull(),

            /* FK - project */
            // La cellule rataché au projet.
            'cellule_id' => $this->integer()->notNull(),
            // Le client, la société, la demande.
            'company_id' => $this->integer(),
            // Le contacte client.
            'contact_id' => $this->integer(),
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
            'contact_id',
            '{{%contact}}',
            'id',

        );

        $this->insert('{{%project}}', [
            'id_capa' => "AIEX_I",
            'id_laboxy' => "OIUEJYYT",
            'internal_name' => 'Projet Balkany',
            'internal_reference' => 'Projet Balkany',
            'type' => Project::TYPE_INTERNAL,
            'signing_probability' => 50,
            'state' => Project::STATE_DRAFT,
            'version' => 'V2',
            'date_version' => date_create()->format('Y-m-d H:i:s'),
            'file_path' => '',
            'creation_date' => date_create()->format('Y-m-d H:i:s'),
            'cellule_id' => 3,
            'company_id' => 1,
            'contact_id' => 1,
            'capa_user_id' => 4,
        ]);
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
