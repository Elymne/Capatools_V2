<?php

use yii\db\Migration;

/**
 * Class m200219_091731_create_delivery_type
 */
class m200100_091731_create_delivery_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%delivery_type}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(),
        ]);

        //Ajout Prestation delegué
        $this->insert('{{%delivery_type}}', [
            'label' => 'Délégué'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery_type}}');
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
