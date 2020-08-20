<?php

namespace app\models\projects;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des dépenses.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Investment extends ActiveRecord
{

    public static function tableName()
    {
        return 'investment';
    }

    public static function getAll()
    {
        return static::find();
    }

    public static function getOneById($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    public static function getAllByLotID($id)
    {
        return static::find()->where(['lot_id' => $id])->all();
    }

    public function getLot()
    {
        return $this->hasOne(Lot::className(), ['id' => 'lot_id']);
    }
}
