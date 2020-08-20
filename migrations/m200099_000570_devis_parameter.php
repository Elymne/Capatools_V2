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
            'internal_rate_management' => $this->integer()->defaultValue(0),
            'rate_management' => $this->integer()->defaultValue(0),
            'delegate_rate_management' => $this->integer()->defaultValue(0.25),
        ]);

        $this->addPrimaryKey('PK_devis_parameter', '{{%devis_parameter}}', ['id']);

        $this->insert('{{%devis_parameter}}', [
            'id' => 'param',
            'iban' => 'default iban',
            'bic' => 'default bic',
            'banking_domiciliation' => 'default domiciliation',
            'address' => 'default address',
            'legal_status' => 'legal status',
            'devis_note' => 'devis note',
            'internal_rate_management' => '0',
            'rate_management' => '12',
            'delegate_rate_management' => '20',
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%devis_parameter}}', []);
        $this->dropTable('{{%devis_parameter}}');
    }
}
