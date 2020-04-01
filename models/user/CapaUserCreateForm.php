<?php

namespace app\models\user;

class CapaUserCreateForm extends CapaUser
{

    // Used to store index roles when validation in controller.
    public $stored_role_devis;
    public $stored_role_admin;

    /**
     * {@inheritdoc}
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
