<?php

namespace app\models\users;

/**
 * Classe relative au modèle métier des utilisateurs.
 * Celle-ci permet de créer un formulaire de création d'un utilisateur et de vérifier la validité des données inscrites dans les champs.
 * Elle permet aussi lorsque l'on veut créer un formulaire pour créer un utilisateur, d'ajouter des champs qui n'existe pas dans la bdd.
 * ex : upfilename, pathfile, datept.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Administration ici).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class CapaUserCreateForm extends CapaUser
{

    // Gestion de 6 checkboxs pour les rôles utilisateur.
    public $salary_role_checkbox = false;
    public $project_manager_role_checkbox = false;
    public $cellule_manager_role_checkbox = false;
    public $support_role_checkbox = false;
    public $human_ressources_role_checkbox = false;
    public $admin_role_checkbox = false;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [

            // email required
            ['email', 'required', 'message' => 'Veulliez renseigner l\'email de l\'utilisateur'],
            ['surname', 'required', 'message' => 'Veulliez renseigner le nom de l\'utilisateur'],
            ['firstname', 'required', 'message' => 'Veulliez renseigner le prénom de l\'utilisateur'],
            ['cellule_id', 'safe'],
            ['cellule_id', 'required', 'message' => 'Veulliez selectionner la cellule de l\'utilisateur'],
            ['price', 'required', 'message' => 'Indiquer le prix d\'intervention.'],
            ['price', 'integer', 'min' => 1, 'tooSmall' => 'Le prix d\'intervention doit être supérieur à 0.', 'message' => 'Le prix d\'intervention doit être positif.'],
            ['email', 'email', 'message' => 'L\'adresse email doit être valide.'],
            ['cellule_id', 'validateCelid', 'message' => 'Le nom de la cellule est inconnue'],
            ['salary_role_checkbox', 'safe'],
            ['project_manager_role_checkbox', 'safe'],
            ['cellule_manager_role_checkbox', 'safe'],
            ['support_role_checkbox', 'safe'],
            ['human_ressources_role_checkbox', 'safe'],
            ['admin_role_checkbox', 'safe'],
        ];
    }
}
