<?php

namespace app\models\companies;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des sociétés.
 * Permet de faire des requêtes depuis la table company de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Company extends ActiveRecord
{

    /**
     * Utilisé pour définir quelle table est associé à cette classe.
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * Utilisé pour récupérer toutes les sociétés.
     */
    public static function getAll()
    {
        return static::find();
    }

    public static function getOneById(int $id)
    {
        return static::find(['id' => $id])->one();
    }
}
