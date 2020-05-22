<?php

namespace app\models\parameters;

/**
 * Classe relative au modèle métier des paramètres de devis.
 * Celle-ci permet de gérer un formulaire de modification des paramètres des devis et de vérifier la validité des données inscrites dans les champs.
 * Elle permet aussi lorsque l'on veut créer un formulaire pour modifier les paramètres de devis , d'ajouter des champs qui n'existe pas dans la bdd.
 * 
 * Cette classe est à utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Devis ici).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class DevisParameterUpdateForm extends DevisParameter
{

    public $cgu_fr_file;
    public $cgu_en_file;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['iban', 'bic', 'banking_domiciliation', 'address', 'legal_status', 'devis_note'], 'safe'],
            ['iban', 'required', 'message' => 'Indiquer l\'iban'],
            ['bic', 'required', 'message' => 'Indiquer le bic'],
            ['banking_domiciliation', 'required', 'message' => 'Indiquer la domiciliation bancaire'],
            ['address', 'required', 'message' => 'Indiquer l\'adresse'],
            ['legal_status', 'required', 'message' => 'Indiquer le status juridique'],
            ['devis_note', 'required', 'message' => 'Indiquer la note de devis'],

        ];
    }
}
