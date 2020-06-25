<?php

namespace app\models\projects\forms;

use app\models\projects\Consumable;

/**
 * Classe relative au modèle métier des dépenses.
 * Celle-ci permet de créer un formulaire de création de dépenses sur la création d'un projet et de vérifier la validité des données inscrites dans les champs.
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis un contrôleur.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectCreateConsumableForm extends Consumable
{

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            ['title', 'required', 'message' => 'Vous devez inscrire une description'],
            ['price', 'required', 'message' => 'Vous devez inscrire un prix'],
            ['type', 'required', 'message' => 'Vous devez sélectionner un type de consommable'],
        ];
    }
}
