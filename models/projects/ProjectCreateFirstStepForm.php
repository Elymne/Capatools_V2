<?php

namespace app\models\projects;

use app\models\projects\Project;

/**
 * Classe relative au modèle métier des devis.
 * Celle-ci permet de créer un formulaire de création de devis et de vérifier la validité des données inscrites dans les champs.
 * Elle permet aussi lorsque l'on veut créer un formulaire pour créer un devis, d'ajouter des champs qui n'existe pas dans la bdd.
 * ex : upfilename, pathfile, datept.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Devis ici).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectCreateFirstStepForm extends Project
{

    /**
     * Gestion combobox.
     * Check par défaut sur le n°1.
     */
    public $combobox_type_checked = 1;
    public $combobox_lot_checked = 1;
    public $combobox_repayment_checked = 1;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            ['combobox_type_checked', 'required', 'message' => 'Le projet doit avoir un type'],
            ['combobox_lot_checked', 'required', 'message' => 'Vous devez cocher au moins un des deux choix proposés'],
            ['combobox_repayment_checked', 'required', 'message' =>  'Vous devez cocher au moins un des deux choix proposés'],
        ];
    }
}
