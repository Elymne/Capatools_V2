<?php

namespace app\models\equipments;

use app\models\laboratories\Laboratory;
use app\models\projects\Repayment;
use JsonSerializable;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des matériels.
 * Permet de faire des requêtes depuis la table equipment de la db associée à l'app.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class EquipmentRepayment extends ActiveRecord implements JsonSerializable
{
    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    public static function tableName()
    {
        return 'equipment_repayment';
    }

    public static function getAllByRepaymentID(int $repaymentID)
    {
        return self::find()->where(['repayment_id' => $repaymentID])->all();
    }

    /**
     * Fait la jonction entre la table d'association et l'équipement, le matériel..
     * Créer un attribut "equipment" qui sera un objet Laboratory.
     */
    public function getEquipment()
    {
        return $this->hasOne(Equipment::className(), ['id' => 'equipment_id']);
    }

    /**
     * Fait la jonction entre la table d'association et le reversement.
     * Créer un attribut "repayment" qui sera un objet Laboratory.
     */
    public function getRepayment()
    {
        return $this->hasOne(Repayment::className(), ['id' => 'repayment_id']);
    }

    /**
     * Fonction pour envoyer au format json les données de l'objet.
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'nb_days' => $this->nb_days,
            'nb_hours' => $this->nb_hours,
            'price' => $this->price,
            'time_risk' => $this->time_risk,
            'equipment_id' => $this->equipment_id,
            'repayment_id' => $this->repayment_id,
            'risk_id' => $this->risk_id
        );
    }
}
