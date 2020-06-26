<?php

namespace app\models\projects;

use app\models\users\CapaUser;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des tâches.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Risk extends ActiveRecord
{




    public static function tableName()
    {
        return 'risk';
    }

    public static function getAll()
    {
        return static::find();
    }
}
