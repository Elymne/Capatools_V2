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

    const TYPE_EXTERNAL_DELIVERY = "Prestation externe";
    const TYPE_CONSUMABLE = "Consommable";
    const TYPE_INTERNAL_DELIVERY = "Prestation interne";
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

    public function getLot()
    {
        return $this->hasOne(Lot::className(), ['id' => 'lot_id']);
    }
}
