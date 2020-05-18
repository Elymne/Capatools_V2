<?php

namespace app\models\devis;

use app\models\companies\Company;
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
class DevisCreateForm extends Devis
{

    public $upfilename;
    public $pathfile;
    public $datept;

    public $company_name;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['payment_conditions', 'payment_details', 'unit_price', 'quantity', 'task_description'], 'safe'],
            [['upfilename'], 'file', 'skipOnEmpty' => true, 'maxSize' => 2000000, 'extensions' => 'pdf', 'tooBig' => 'Le document est trop gros {formattedLimit}', 'message' => 'Une proposition technique doit être associée au devis.'],
            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['service_duration', 'required', 'message' => 'Indiquer le temps en heure du projet.'],
            ['service_duration_day', 'required', 'message' => 'Indiquer le en jour temps du projet.'],
            ['company_name', 'required', 'message' => 'Indiquer le nom du client.'],
            ['company_name', 'noClientFound', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['service_duration', 'integer', 'min' => 0, 'tooSmall' => 'La durée en heure de la prestation doit être supérieur à 0.', 'message' => 'La durée en heure de la prestation doit être un entier positif.'],
            ['service_duration_day', 'integer', 'min' => 0, 'tooSmall' => 'La durée en jour de la prestation doit être supérieur à 0.', 'message' => 'La durée en jour de la prestation doit être un entier positif.'],
            ['validity_duration', 'integer', 'min' => 0, 'tooSmall' => 'La durée de validité doit être supérieur à 0.', 'message' => 'La durée de validité doit être un entier positif.'],
            ['price', 'integer', 'min' => 0, 'tooSmall' => 'Le prix doit être supérieur à 0.', 'message' => 'Le prix doit être un entier positif.'],
            ['delivery_type_id', 'required', 'message' => 'Indiquer le type de la prestation !'],
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
    public function noClientFound($attribute, $params)
    {
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        if (!in_array($this->$attribute, $companiesNames)) {
            $this->addError($attribute, 'Le client n\'existe pas.');
        }
    }
}
