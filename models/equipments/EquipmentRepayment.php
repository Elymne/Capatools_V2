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
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            ['nb_days', 'required', 'message' => 'Veuillez renseigner le nombre de jours'],
            ['nb_days', 'integer', 'min' => 0, 'tooSmall' => 'Le nombre de jours doit être supérieur à 0', 'message' => 'Le nombre de jours doit être supérieur à 0'],
            ['nb_hours', 'required', 'message' => 'Veuillez renseigner le nombre d\'heures'],
            ['nb_hours', 'integer', 'min' => 0, 'tooSmall' => 'Le nombre d\'heures doit être supérieur à 0', 'message' => 'Le nombre d\'heures doit être supérieur à 0'],
            ['risk', 'required', 'message' => 'Veuillez spécifier la valeur d\'incertitude'],
            ['risk_days', 'required', 'message' => 'Veuillez renseigner le nombre de jours'],
            ['risk_days', 'integer', 'min' => 0, 'tooSmall' => 'Le nombre de jours doit être supérieur à 0', 'message' => 'Le nombre de jours doit être supérieur à 0'],
        ];
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
