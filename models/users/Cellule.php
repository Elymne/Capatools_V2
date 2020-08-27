<?php

namespace app\models\users;

use app\models\laboratories\Laboratory;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des cellules.
 * Permet de faire des requêtes depuis la table cellule de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * Cette classe implémente l'interface IDentityInterface qui permet de gérer les utiliseurs et la sécurité à la manière de Yii2.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Cellule extends ActiveRecord
{

    public static function tableName()
    {
        return 'cellule';
    }

    public static function getAll()
    {
        return static::find()->all();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public function getCapaUsers()
    {
        return $this->hasMany(CapaUser::class, ['cellule_id' => 'id']);
    }

    public function getLaboratories()
    {
        return $this->hasMany(Laboratory::class, ['cellule_id' => 'id']);
    }

    public static function findByAXX($AXXX)
    {
        return static::findOne(['identity' => $AXXX]);
    }
}
