<?php

namespace app\models\projects;

use JsonSerializable;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des consommables.
 * Permet de faire des requêtes depuis la table consumable de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Consumable extends ActiveRecord implements JsonSerializable
{

    public $total;
    /**
     * Petite note ici qui a son importance.
     * Sur l'application, on dicerne deux types de consommables :
     *  les consommables par défaut que l'on va simplement appeler "consommable"
     *  les consommables qui seront définie comme des dépenses éventuelles que l'on va appeler "expense"
     * 
     * Pour résumer simplement, au niveau de l'affichage, on va séparer les consommables qui sont de type : TYPE_SECONDARY_INVESTMENT avec le reste.
     */
    // Consommable par défaut.
    const TYPE_EXTERNAL_DELIVERY = "Sous traitance externe";
    const TYPE_CONSUMABLE = "Consommable & déplacement";
    const TYPE_INTERNAL_DELIVERY = "Prestation interne";
    // Dépenses éventuelles.
    const TYPE_SECONDARY_INVESTMENT = "Investissement éventuels";

    const TYPES = [
        self::TYPE_EXTERNAL_DELIVERY,
        self::TYPE_CONSUMABLE,
        self::TYPE_INTERNAL_DELIVERY
    ];

    public static function tableName()
    {
        return 'consumable';
    }

    public static function getAllConsummablesByLotID(int $lotID)
    {
        return self::find()->where(['lot_id' => $lotID, 'type' => !self::TYPE_SECONDARY_INVESTMENT])->all();
    }

    public static function getAllExpensesByLotID(int $lotID)
    {
        return self::find()->where(['lot_id' => $lotID, 'type' => self::TYPE_SECONDARY_INVESTMENT])->all();
    }

    public static function  getAllExternalGroupByTitleBylotID(int $lotID)
    {
        return $res = self::find()
            ->select('SUM(price) as total,title')
            ->where(['lot_id' => $lotID, 'type' => self::TYPE_EXTERNAL_DELIVERY])
            ->groupBy(['title'])
            ->all();
    }

    public static function  getAllInternalGroupByTitleBylotID(int $lotID)
    {
        return $res = self::find()
            ->select('SUM(price) as total,title')
            ->where(['lot_id' => $lotID, 'type' => self::TYPE_INTERNAL_DELIVERY])
            ->groupBy(['title'])
            ->all();
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
            'title' => $this->title,
            'price' => $this->price,
            'type' => $this->type,
            'lot_id' => $this->lot_id
        );
    }
}
