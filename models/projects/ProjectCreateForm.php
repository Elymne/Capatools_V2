<?php

namespace app\models\projects;

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
class ProjectCreateForm extends Project
{

    public $upfilename;
    public $pathfile;
    public $datept;

    public $company_name;
    public $contact_name;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [[], 'safe'],

            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['service_duration', 'required', 'message' => 'Indiquer le temps en heure du projet.'],
            ['service_duration_day', 'required', 'message' => 'Indiquer le en jour temps du projet.'],
            ['company_name', 'required', 'message' => 'Indiquer le nom du client.'],
            ['company_name', 'noCompanyFound', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['contact_name', 'required', 'message' => 'Indiquer le nom du client.'],
            ['contact_name', 'noContactFound', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['service_duration', 'integer', 'min' => 0, 'tooSmall' => 'La durée en heure de la prestation doit être supérieur à 0.', 'message' => 'La durée en heure de la prestation doit être un entier positif.'],
            ['service_duration_day', 'integer', 'min' => 0, 'tooSmall' => 'La durée en jour de la prestation doit être supérieur à 0.', 'message' => 'La durée en jour de la prestation doit être un entier positif.'],


            ['prospecting_time_day', 'integer', 'min' => 0, 'tooSmall' => 'La durée doit être supérieur à 0.', 'message' => 'La durée doit être un entier positif.'],
            ['signing_probability', 'required', 'message' => 'Indiquez la probabilité de signature !.'],


            [['upfilename'], 'file', 'skipOnEmpty' => true, 'maxSize' => 2000000, 'extensions' => 'pdf', 'tooBig' => 'Le document est trop gros {formattedLimit}', 'message' => 'Une proposition technique doit être associée au devis.'],
        ];
    }


    //TODO se souvenir à quoi sert cette fonction.
    public function upload()
    {
        if ($this->upfilename) {

            //J Save the file into upload path.
            $path = 'uploads/' . $this->id_capa;
            if (!is_dir($path)) {
                mkdir($path);
            }
            $pathfile = $path . '/' . $this->upfilename->baseName . '.' . $this->upfilename->extension;
            $result = true;
            //if(file_exists(pathfile))
            {
                ////Overright :)

            }
            if ($result) {

                $this->filename = $this->upfilename;

                $this->upfilename->saveAs($pathfile);
            }
            return true;
        }
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
