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
     * Fonction surchargée de la classe ActiveRecord, elle permet de vérifier l'intégrité des données dans un modèle.
     */
    public function rules()
    {
        return [
            ['type', 'required', 'message' => 'Veuillez renseigner le type d\'intervenant'],
            ['nb_days', 'required', 'message' => 'Veuillez définir le nombre de jours'],
            ['nb_hours', 'required', 'message' => 'Veuillez définir le nombre d\'heures'],
            ['price_day', 'required', 'message' => 'Veuillez définir le prix journalier'],
            ['risk', 'required', 'message' => 'Veuillez définir le taux d\'incertitude'],
            ['risk_day', 'required', 'message' => 'Veulliez définir le nombre de jours lié à l\'incertitude'],
            ['risk_hour', 'required', 'message' => 'Veulliez définir le nombre d\'heures lié à l\'incertitude'],
        ];
    }
}
