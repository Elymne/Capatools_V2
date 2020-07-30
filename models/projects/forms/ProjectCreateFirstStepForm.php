<?php

namespace app\models\projects\forms;

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
     */
    public $combobox_type_checked = 0;
    public $combobox_lot_checked = 1;
    public $combobox_repayment_checked = 1;

    public $management_rate;

    public $company_name;
    public $contact_name;
    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            ['combobox_type_checked', 'required', 'message' => 'Le projet doit avoir un type'],
            ['combobox_lot_checked', 'required', 'message' => 'Make a choice'],
            ['combobox_repayment_checked', 'required', 'message' =>  'Vous devez cocher au moins un des deux choix proposés'],
            ['internal_name', 'required', 'message' => 'Vous devez préciser un nom pour le projet/brouillon']
        ];
    }


    /**
     * Check if client exists and return error if he don't.
     */
    public function noCompanyFound($attribute, $params)
    {
        $companiesNames = ArrayHelper::map(Contact::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        if (!in_array($this->$attribute, $companiesNames)) {
            $this->addError($attribute, 'Le client n\'existe pas.');
        }
    }

    /**
     * Check if contact exists and return error if he don't.
     */
    public function noContactFound($attribute, $params)
    {
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'surname');
        $companiesNames = array_merge($companiesNames);

        if (!in_array($this->$attribute, $companiesNames)) {
            $this->addError($attribute, 'Le client n\'existe pas.');
        }
    }
}
