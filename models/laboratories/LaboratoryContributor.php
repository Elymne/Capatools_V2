<?php

namespace app\models\laboratories;

use app\models\projects\Repayment;
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
class LaboratoryContributor extends ActiveRecord
{

    const TYPE_SEARCHER = "Chercheur";
    const TYPE_PROBATIONER = "Stagiaire";
    const TYPE_DOCTOR = "Post-docteur";

    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    static function tableName()
    {
        return 'laboratory_contributor';
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
    public function getRepayment()
    {
        return $this->hasOne(Repayment::className(), ['id' => 'repayment_id']);
    }
}
