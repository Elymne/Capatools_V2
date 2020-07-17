<?php

namespace app\models\projects;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des consommables.
 * Permet de faire des requêtes depuis la table consumable de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Consumable extends ActiveRecord
{

    /**
     * Petite note ici qui a son importance.
     * Sur l'application, on dicerne deux types de consommables :
     *  les consommables par défaut que l'on va simplement appeler "consommable"
     *  les consommables qui seront définie comme des dépenses éventuelles que l'on va appeler "expense"
     * 
     * Pour résumer simplement, au niveau de l'affichage, on va séparer les consommables qui sont de type : TYPE_SECONDARY_INVESTMENT avec le reste.
     */
    // Consommable par défaut.
    const TYPE_EXTERNAL_DELIVERY = "Prestation externe";
    const TYPE_CONSUMABLE = "Consommable";
    const TYPE_INTERNAL_DELIVERY = "Prestation interne";
    // Dépenses éventuelles.
    const TYPE_SECONDARY_INVESTMENT = "Investissement éventuels";

    const TYPES = [
        1 => self::TYPE_EXTERNAL_DELIVERY,
        2 => self::TYPE_CONSUMABLE,
        3 => self::TYPE_INTERNAL_DELIVERY
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

    public function getLot()
    {
        return $this->hasOne(Lot::className(), ['id' => 'lot_id']);
    }
}
