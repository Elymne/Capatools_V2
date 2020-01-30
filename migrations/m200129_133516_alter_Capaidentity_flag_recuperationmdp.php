<?php

use yii\db\Migration;

/**
 * Class m200129_133516_alter_Capaidentity_flag_recuperationmdp
 */
class m200129_133516_alter_Capaidentity_flag_recuperationmdp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('capaidentity', 'flagPassword', $this->boolean());

        ///Modification des données de test pour associer l'utilisateur toto à la cellule AROBO
        $this->update('capaidentity', ['flagPassword' => true], ['username' => 'toto']);

        ///Modification des données de test pour associer l'utilisateur toto à la cellule AROBO
        $this->update('capaidentity', ['flagPassword' => false], ['username' => 'toto']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
        $this->dropColumn('capaidentity', 'flagPassword', $this->boolean());
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200129_133516_alter_Capaidentity_flag_recuperationmdp cannot be reverted.\n";

        return false;
    }
    */
}
