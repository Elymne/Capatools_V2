<?php

namespace app\models\companies;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des contacts.
 * Cette classe possèdes une structure permettant d'avoir un jointure avec la table company (array d'objets Company).
 * Permet de faire des requêtes depuis la table contact de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Contact extends ActiveRecord
{

    /**
     * Utilisé pour définir quelle table est associé à cette classe.
     */
    public static function tableName()
    {
        return 'contact';
    }

    // Relation mapping.

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
