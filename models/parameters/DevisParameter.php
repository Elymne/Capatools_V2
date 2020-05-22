<?php

namespace app\models\parameters;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des paramètres des devis.
 * Permet de faire des requêtes depuis la table devis_parameter de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class DevisParameter extends ActiveRecord
{
    public static function tableName()
    {
        return 'devis_parameter';
    }

    public static function getParameters()
    {
        return static::find()->where(['id' => 'param'])->one();
    }
}
