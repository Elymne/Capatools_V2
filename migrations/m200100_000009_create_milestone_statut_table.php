<?php

use yii\db\Migration;

class m200100_000009_create_milestone_statut_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%milestone_status}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
        ]);

        $this->execute('ALTER TABLE devis_status AUTO_INCREMENT = 0');

        $this->execute("ALTER TABLE `milestone` CHANGE `milestone_status_id` `milestone_status_id` INT(11) NULL DEFAULT '1'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%milestone_status}}');
    }
}
