<?php

namespace app\models\projects\forms;

use app\models\companies\Company;
use app\models\companies\Contact;
use app\models\projects\Project;
use yii\helpers\ArrayHelper;

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
     * Gestion des radio buttons.
     */
    public $radiobutton_type_selected = 1;

    public $company_name;
    public $contact_email;
    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [["company_name", "contact_email"], "safe"],
            ['radiobutton_type_selected', 'required', 'message' => 'Le projet doit avoir un type'],
            ['internal_name', 'required', 'message' => 'Vous devez préciser un nom pour le projet/brouillon'],
            ['company_name', 'noCompanyFound'],
            ['contact_email', 'noContactFound'],
            ['company_name', 'required', 'message' => 'Vous devez préciser une société'],
            ['contact_email', 'required', 'message' => 'Vous devez préciser un mail de contact'],

        ];
    }


    /**
     * Check if client exists and return error if he don't.
     */
    public function noCompanyFound($attribute, $params)
    {
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
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
        $contact_email = ArrayHelper::map(Contact::find()->all(), 'id', 'email');
        $contact_email = array_merge($contact_email);

        if (!in_array($this->$attribute, $contact_email)) {
            $this->addError($attribute, 'Le contact n\'existe pas.');
        }
    }
}
