<?php

use yii\db\Migration;

/**
 * Class m200219_091731_Ajout_typeprestation
 */
class m200219_091731_Ajout_typeprestation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%typeprestation}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
        ]);

        //Ajout Prestation delegué
        $this->insert('{{%typeprestation}}', [
            'label' => 'Délégué'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%typeprestation}}');
        $this->dropColumn('devis', 'typeprestation_id');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200219_091731_Ajout_typeprestation cannot be reverted.\n";

        return false;
    }
    */
}
