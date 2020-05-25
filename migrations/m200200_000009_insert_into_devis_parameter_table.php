<?php

use yii\db\Migration;

class m200200_000009_insert_into_devis_parameter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%devis_parameter}}', [
            'id' => 'param',
            'iban' => 'default iban',
            'bic' => 'default bic',
            'banking_domiciliation' => 'default domiciliation',
            'address' => 'default address',
            'legal_status' => 'legal status',
            'devis_note' => 'devis note',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->delete('{{%milestone_status}}');
    }
}
