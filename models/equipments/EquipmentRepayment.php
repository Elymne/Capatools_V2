<?php

namespace app\models\equipments;

use app\models\laboratories\Laboratory;
use app\models\projects\Repayment;
use yii\db\ActiveRecord;

/**
 * Classe modèle métier des matériels.
 * Permet de faire des requêtes depuis la table equipment de la db associée à l'app.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class EquipmentRepayment extends ActiveRecord
{

    /**
     * Utilisé pour définir quelle table est associée à cette classe.
     */
    public static function tableName()
    {
        return 'equipment_repayment';
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
}
