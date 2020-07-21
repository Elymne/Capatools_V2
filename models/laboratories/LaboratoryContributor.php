<?php

namespace app\models\laboratories;

use app\models\projects\Lot;
use JsonSerializable;
use yii\db\ActiveRecord;

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

    const TYPE_SEARCHER = "Chercheur";
    const TYPE_PROBATIONER = "Stagiaire";
    const TYPE_DOCTOR = "Post-docteur";
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

    /**
     * Fait la jonction entre un intervenant labo et son laboratoire.
     * Créer un attribut "laboratory" qui sera un objet de type Laboratory.
     */
    public function getLaboratory()
    {
        return $this->hasOne(Laboratory::className(), ['id' => 'laboratory_id']);
    }

    /**
     * Fait la jonction entre un intervenant labo et son laboratoire.
     * Créer un attribut "laboratory" qui sera un objet de type Laboratory.
     * 
     * //TODO Terminer cette fonction une fois la classe Payment développée.
     */
    public function getLot()
    {
        return $this->hasOne(Lot::className(), ['id' => 'lot_id']);
    }

    /**
     * Fonction pour envoyer au format json les données de l'objet.
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'type' => $this->type,
            'nb_days' => $this->nb_days,
            'nb_hours' => $this->nb_hours,
            'price' => $this->price,
            'time_risk' => $this->time_risk,
            'laboratory_id' => $this->laboratory_id,
            'repayment_id' => $this->repayment_id,
            'risk_id' => $this->risk_id
        );
    }
}
