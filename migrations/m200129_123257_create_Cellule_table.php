<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Cellule}}`.
 */
class m200129_123257_create_Cellule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Cellule}}', [
            'id' => $this->primaryKey(),
            'identifiant' => $this->string(),
            'name' => $this->string(),
        ]);
        $this->addColumn('capaidentity', 'Celluleid', $this->integer());


        // ajoute un clé étrangère`
        $this->addForeignKey(
            'fk-capaidentity_-Cellule',
            '{{%capaidentity}}',
            'Celluleid',
            'Cellule',
            'id',
            'CASCADE'
            );
    
       //Ajout de la cellule AROBO
        $this->insert('{{%Cellule}}', [
            'id' => '1',
            'identifiant' => 'AROBO',
            'name' => 'Robotique et Procede'
        ]);  

        ///Modification des données de test pour associer l'utilisateur toto à la cellule AROBO
        $this->update('capaidentity', ['Celluleid' => 1], ['username' => 'toto']);

        //On change de nom la colonne name qui redondante en colonne pour stocker les adresses email.
        $this->renameColumn('capaidentity','name','email');

        ///Modification des données de test pour associer l'utilisateur toto à la cellule AROBO
        $this->update('capaidentity', ['email' => 'toto@gmail.com'], ['username' => 'toto']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        // drop de la clé étrangère vers la table `user`
        $this->dropForeignKey(
            'fk-capaidentity_-Cellule',
            '{{%capaidentity}}'
            );

        
        $this->dropColumn('capaidentity', 'Celluleid', $this->integer());

        $this->dropTable('{{%Cellule}}');
    }
}
