<?php

namespace app\models\laboratories;

use app\models\projects\Lot;
use JsonSerializable;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Classe modèle métier des colaborateurs des laboratoires Capacités.
 * Permet de faire des requêtes depuis la table laboratoryCOntributor de la db associée à l'app.
 * Les attributs sont les suivants : 
 *  - id
 *  - type
 *  - nb_days
 *  - nb_hours
 *  - price_day
 *  - price_hour
 *  - risk
 *  - risk_day
 *  - risk_hour
 *  - laboratory_id
 *  - payment_id
 *  - laboratory
 *  - payment
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class LaboratoryContributor extends ActiveRecord implements JsonSerializable
{

    public $total;
    const TYPE_SEARCHER = "chercheur";
    const TYPE_PROBATIONER = "stagiaire";
    const TYPE_DOCTOR = "post-docteur";
    const TYPES = [
        self::TYPE_SEARCHER,
        self::TYPE_PROBATIONER,
        self::TYPE_DOCTOR
    ];

    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    static function tableName()
    {
        return 'laboratory_contributor';
    }

    public static function getAllByLaboratoryID(int $laboratoryID)
    {
        return self::find()->where(['laboratory_id' => $laboratoryID])->all();
    }

    public static function getAllByLotID(int $lotID)
    {
        return self::find()->where(['lot_id' => $lotID])->all();
    }

    public static function getAllContributionGroupByLaboBylotID(int $lotid)
    {
        return $res = self::find()
            ->select('SUM(price) as total,laboratory_id as id')
            ->where(['lot_id' => $lotid])
            ->groupBy(['laboratory_id'])
            ->all();
    }


    /**
     * Fait la jonction entre un intervenant labo et son laboratoire.
     * Créer un attribut "laboratory" qui sera un objet de type Laboratory.
     */
    public function getLaboratory()
    {
        return $this->hasOne(Laboratory::class, ['id' => 'laboratory_id']);
    }

    /**
     * Fait la jonction entre un intervenant labo et son laboratoire.
     * Créer un attribut "laboratory" qui sera un objet de type Laboratory.
     * 
     */
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
            'name' => $this->name,
            'daily_price' => $this->daily_price,
            'nb_days' => $this->nb_days,
            'nb_hours' => $this->nb_hours,
            'price' => $this->price,
            'time_risk' => $this->time_risk,
            'laboratory_id' => $this->laboratory_id,
            'lot_id' => $this->lot_id,
            'risk_id' => $this->risk_id
        );
    }
}
