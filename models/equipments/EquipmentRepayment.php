<?php

namespace app\models\equipments;


use app\models\laboratories\Laboratory;
use app\models\projects\Lot;
use app\models\projects\Risk;
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
    public $total;
    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    public static function tableName()
    {
        return 'equipment_repayment';
    }

    public static function getAllByLotID(int $id)
    {
        return self::find()->where(['lot_id' => $id])->all();
    }

    /**
     * Fait la jonction entre la table d'association et l'équipement, le matériel..
     * Créer un attribut "equipment" qui sera un objet Laboratory.
     */
    public function getEquipment()
    {
        return $this->hasOne(Equipment::class, ['id' => 'equipment_id']);
    }

    /**
     * Fait la jonction entre la table d'association et le reversement liées au lot.
     * Créer un attribut "repayment" qui sera un objet Laboratory.
     */
    public function getRisk()
    {
        return $this->hasOne(Risk::class, ['id' => 'risk_id']);
    }

    /**
     * Fait la jonction entre la table d'association et le reversement liées au lot.
     * Créer un attribut "repayment" qui sera un objet Laboratory.
     */
    public function getLot()
    {
        return $this->hasOne(Lot::class, ['id' => 'lot_id']);
    }

    public static function getAllEquipementRepayementGroupByLaboBylotID(int $lotid)
    {
        return $res = self::find()
            ->select('SUM(aqr.time_risk * aqr.price) as total,equipment.laboratory_id as id')
            ->from((['equipment_repayment as aqr']))
            ->joinWith('equipment')
            ->where(['aqr.lot_id' => $lotid])
            ->groupBy(['equipment.laboratory_id'])
            ->all();
    }
    public function getLaboratory()
    {
        return $res = self::find()
            ->select('SUM(time_risk * price) as total,laboratory_id as id')
            ->where(['lot_id' => $lotid])
            ->groupBy(['laboratory_id'])
            ->all();
        return $this->hasOne(Laboratory::className(), ['id' => 'laboratory_id'])
            ->via('equipment');
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
            'lot_id' => $this->lot_id,
            'risk_id' => $this->risk_id
        );
    }
}
