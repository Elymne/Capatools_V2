<?php

namespace app\models\projects;

use JsonSerializable;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des dépenses.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Investment extends ActiveRecord implements JsonSerializable
{

    public static function duplicateToLot(Investment $investment, $idlot)
    {
        $newInvestment = new Investment();
        $newInvestment->name = $investment->name;
        $newInvestment->price = $investment->price;
        $newInvestment->lot_id = $idlot;

        $newInvestment->save();
    }

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
        return $this->hasOne(Lot::class, ['id' => 'lot_id']);
    }

    /**
     * Fonction pour envoyer au format json les données de l'objet.
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'title' => $this->name,
            'price' => $this->price,
            'lot_id' => $this->lot_id
        );
    }
}
