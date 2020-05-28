<?php

use yii\db\Migration;

class m200099_000570_devis_parameter extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%devis_parameter}}', [
            'id' => $this->string()->notNull(),
            'iban' => $this->string()->notNull(),
            'bic' => $this->string()->notNull(),
            'banking_domiciliation' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'legal_status' => $this->string()->notNull(),
            'devis_note' => $this->string()->notNull(),
        ]);

        $this->addPrimaryKey('PK_devis_parameter', '{{%devis_parameter}}', ['id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%devis_parameter}}');
    }
}
