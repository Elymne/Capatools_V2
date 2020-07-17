<?php

namespace app\models\projects\forms;

use app\models\equipments\EquipmentRepayment;

/**
 * Classe relative au modèle métier des dépenses.
 * Celle-ci permet de créer un formulaire de création de dépenses sur la création d'un projet et de vérifier la validité des données inscrites dans les champs.
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis un contrôleur.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectCreateEquipmentRepaymentForm extends EquipmentRepayment
{

    /**
     * Liste d'attributs relatif au formulaire.
     * (Pour stocker la valeur choisie dans les listes déroulantes).
     */
    public $equipmentSelected;
    public $riskSelected;
    public $timeRiskStringify;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['equipmentSelected', 'riskSelected', 'timeRiskStringify'], 'safe'],
            ['nb_days', 'required', 'message' => 'Veuillez renseigner le nombre de jours'],
            ['nb_days', 'integer', 'min' => 0, 'tooSmall' => 'Le nombre de jours doit être supérieur à 0', 'message' => 'Le nombre de jours doit être supérieur à 0'],
            ['nb_hours', 'required', 'message' => 'Veuillez renseigner le nombre d\'heures'],
            ['nb_hours', 'integer', 'min' => 0, 'tooSmall' => 'Le nombre d\'heures doit être supérieur à 0', 'message' => 'Le nombre d\'heures doit être supérieur à 0'],
            ['timeRiskStringify', 'required', 'message' => 'Le temps d\'incertitude n\'a pas généré'],
            ['price', 'required', 'message' => 'Le coût n\'a pas été généré'],
            ['price', 'integer', 'min' => 0, 'tooSmall' => 'Le temps d\'incertitude généré doit être supérieur à 0', 'message' => 'Le temps d\'incertitude généré doit être supérieur à 0'],
        ];
    }
}
