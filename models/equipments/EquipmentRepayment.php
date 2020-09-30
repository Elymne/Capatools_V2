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

    public static function duplicateToLot(EquipmentRepayment $equip, $idlot)
    {
        $newEquipment = new EquipmentRepayment();
        $newEquipment->name = $equip->name;
        $newEquipment->daily_price = $equip->daily_price;
        $newEquipment->nb_days = $equip->nb_days;
        $newEquipment->nb_hours = $equip->nb_hours;
        $newEquipment->price = $equip->price;
        $newEquipment->time_risk = $equip->time_risk;
        $newEquipment->laboratory_id = $equip->laboratory_id;
        $newEquipment->lot_id = $idlot;
        $newEquipment->risk_id = $equip->risk_id;
        $newEquipment->risk_coefficient = $equip->risk_coefficient;

        $newEquipment->save();
    }

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
        return self::find()
            ->select('SUM(aqr.time_risk * aqr.price) as total, aqr.laboratory_id as id')
            ->from((['equipment_repayment as aqr']))
            ->joinWith('lot')
            ->where(['aqr.lot_id' => $lotid])
            ->groupBy(['aqr.laboratory_id'])
            ->all();
    }

    public function getAllEquipmentsRepayementGroupByLaboAndLotID(int $lotID)
    {
        return $res = self::find()
            ->select('SUM( price) as total,laboratory_id as id')
            ->where(['lot_id' => $lotID])
            ->groupBy(['laboratory_id'])
            ->all();
    }

    public function getLaboratory()
    {

        return $this->hasOne(Laboratory::class, ['id' => 'laboratory_id'])
            ->via('equipment');
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
            'lot_id' => $this->lot_id,
            'risk_id' => $this->risk_id
        );
    }
}
