<?php

namespace app\models\projects;

use JsonSerializable;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des tâches.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Risk extends ActiveRecord implements JsonSerializable
{

    public static function tableName()
    {
        return 'risk';
    }

    public static function getAll()
    {
        return static::find();
    }

    /**
     * Fonction pour envoyer au format json les données de l'objet.
     * 
     * //TODO coefficient voca error.
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'coeficient' => $this->coeficient,
        );
    }
}
