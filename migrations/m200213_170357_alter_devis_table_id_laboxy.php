<?php

use yii\db\Migration;

/**
 * Class m200213_170357_alter_devis_table_id_laboxy
 */
class m200213_170357_alter_devis_table_id_laboxy extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('devis', 'id_laboxy', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('devis', 'id_laboxy', $this->string());
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200213_170357_alter_devis_table_id_laboxy cannot be reverted.\n";

        return false;
    }
    */
}
