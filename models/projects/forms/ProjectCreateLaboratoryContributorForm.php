<?php

namespace app\models\projects\forms;

use app\models\laboratories\LaboratoryContributor;

/**
 * Classe relative au modèle métier des dépenses.
 * Celle-ci permet de créer un formulaire de création de dépenses sur la création d'un projet et de vérifier la validité des données inscrites dans les champs.
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis un contrôleur.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectCreateLaboratoryContributorForm extends LaboratoryContributor
{

    /**
     * Liste d'attributs relatif au formulaire.
     * (Pour stocker la valeur choisie dans les listes déroulantes).
     */
    public $riskSelected;
    public $timeRiskStringify;

    /**
     * Fonction surchargée de la classe ActiveRecord, elle permet de vérifier l'intégrité des données dans un modèle.
     */
    public function rules()
    {
        return [
            [['riskSelected', 'timeRiskStringify'], 'safe'],
            ['name', 'required', 'message' => 'Veuillez renseigner le type d\'intervenant'],
            ['daily_price', 'required', 'message' => 'Le coût n\'a pas été généré'],
            ['daily_price', 'double', 'min' => 0, 'tooSmall' => 'Le coût généré doit être supérieur à 0', 'message' => 'Le coût généré doit être supérieur à 0'],
            ['nb_days', 'required', 'message' => 'Veuillez définir le nombre de jours'],
            ['nb_days', 'integer', 'min' => 0, 'tooSmall' => 'Le nombre de jours doit être supérieur à 0', 'message' => 'Le nombre de jours doit être supérieur à 0'],
            ['nb_hours', 'required', 'message' => 'Veuillez définir le nombre d\'heures'],
            ['nb_hours', 'integer', 'min' => 0, 'tooSmall' => 'Le nombre d\'heures doit être supérieur à 0', 'message' => 'Le nombre d\'heures doit être supérieur à 0'],
            ['price', 'required', 'message' => 'Le coût n\'a pas été généré'],
            ['price', 'double', 'min' => 0, 'tooSmall' => 'Le coût généré doit être supérieur à 0', 'message' => 'Le coût généré doit être supérieur à 0'],
            ['timeRiskStringify', 'required', 'message' => 'Le temps d\'incertitude n\'a pas été généré'],
        ];
    }

    /**
     * Permet de récupérer la bonne clé pour la liste sélectionnable, à utiliser sur la vue.
     */
    public function getSelectedType(): int
    {
        switch ($this->type) {
            case null:
                return 0;
                break;
            case self::TYPE_SEARCHER:
                return 0;
                break;
            case self::TYPE_PROBATIONER:
                return 1;
                break;
            case self::TYPE_DOCTOR:
                return 2;
                break;
            default:
                return 0;
        }
    }

    /**
     * A utiliser pour associer la bonne clé lié à la liste sélectionnable pour la vue.
     * Cette fonction ne marche que parce que les valeurs des id risks sont auto incrémenté.
     */
    public function setSelectedRisk()
    {
        $this->riskSelected = $this->risk_id - 1;
    }
}
