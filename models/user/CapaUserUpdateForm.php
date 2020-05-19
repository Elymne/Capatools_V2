<?php

namespace app\models\user;

/**
 * Classe relative au modèle métier des utilisateurs.
 * Celle-ci permet de créer un formulaire de modification d'un utilisateur et de vérifier la validité des données inscrites dans les champs.
 * Elle permet aussi lorsque l'on veut créer un formulaire pour modifier un utilisateur, d'ajouter des champs qui n'existe pas dans la bdd.
 * ex : upfilename, pathfile, datept.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Administration ici).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class CapaUserUpdateForm extends CapaUser
{

    // Used to store index roles when validation in controller.
    public $stored_role_devis;
    public $stored_role_admin;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [

            // email required
            ['email', 'required', 'message' => 'Veulliez renseigner l\'email de l\'utilisateur'],
            ['username', 'required', 'message' => 'Veulliez renseigner le nom de l\'utilisateur'],
            ['cellule_id', 'safe'],
            ['cellule_id', 'required', 'message' => 'Veulliez selectionner la cellule de l\'utilisateur'],
            ['email', 'email', 'message' => 'L\'adresse email doit être valide.'],
            ['cellule_id', 'validateCelid', 'message' => 'Le nom de la cellule est inconnue'],
            ['stored_role_devis', 'safe'],
            ['stored_role_admin', 'safe']
        ];
    }
}
