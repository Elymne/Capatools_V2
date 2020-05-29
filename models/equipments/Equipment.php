<?php

namespace app\models\equipments;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des matériels.
 * Permet de faire des requêtes depuis la table equipment de la db associée à l'app.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Equipment extends ActiveRecord
{

    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    public static function tableName()
    {
        return 'equipment';
    }

    public function getOneById(int $id)
    {
        return static::find(['id' => $id])->one();
    }

    /**
     * Utilisé pour récupérer tous les matériels.
     */
    public static function getAll()
    {
        return static::find();
    }
}