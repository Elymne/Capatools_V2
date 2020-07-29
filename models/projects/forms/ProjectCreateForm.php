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
class ProjectCreateForm extends Project
{

    public $upfilename;
    public $pathfile;
    public $datept;
    public $proba;
    public $file;
    public $thematique;
    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [[], 'safe'],

            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['signing_probability', 'required', 'message' => 'Indiquez la probabilité de signature !.'],
            [['upfilename'], 'file', 'skipOnEmpty' => true, 'maxSize' => 2000000, 'extensions' => 'pdf', 'tooBig' => 'Le document est trop gros {formattedLimit}', 'message' => 'Une proposition technique doit être associée au devis.'],
        ];
    }


    //chage le fichier
    public function upload()
    {
        if ($this->file) {

            //J Save the file into upload path.
            $path = 'uploads/' . $this->id_capa;
            if (!is_dir($path)) {
                mkdir($path);
            }
            $pathfile = $path . '/' . $this->file->baseName . '.' . $this->file->extension;
            $result = true;
            //if(file_exists(pathfile))
            {
                ////Overright :)

            }
            if ($result) {


                $this->file->saveAs($pathfile);
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
