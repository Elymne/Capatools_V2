<?php

namespace app\models\projects;

use yii\helpers\ArrayHelper;
use app\models\companies\Company;
use app\models\projects\Project;

/**
 * Classe relative au modèle métier des devis.
 * Celle-ci permet de créer un formulaire de modification de devis et de vérifier la validité des données inscrites dans les champs.
 * Elle permet aussi lorsque l'on veut créer un formulaire pour modifier un devis, d'ajouter des champs qui n'existe pas dans la bdd.
 * Cette classe ressemble exactement à DevisCreateForm mais nous la gardons tout de même dans le cas où le formulaire changerait par rapport
 * à celle de la création d'un devis.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Devis ici).
 * ex : upfilename, pathfile, datept.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectUpdateForm extends Project
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
            [['upfilename'], 'file', 'skipOnEmpty' => true, 'maxSize' => 2000000, 'extensions' => 'pdf', 'tooBig' => 'Le document est trop gros {formattedLimit}', 'message' => 'Une proposition technique doit être associée au devis.'],
            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['service_duration', 'required', 'message' => 'Indiquer le temps du projet.'],
            ['company_name', 'required', 'message' => 'Indiquer le nom du client.'],
            ['company_name', 'noCompanyFound', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['service_duration', 'integer', 'min' => 0, 'tooSmall' => 'La durée de la prestation doit être supérieur à 0.', 'message' => 'La durée de la prestation doit être un entier positif.'],
            ['delivery_type_id', 'required', 'message' => 'Indiquer le type de la prestation !'],
        ];
    }


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
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        if (!in_array($this->$attribute, $companiesNames)) {
            $this->addError($attribute, 'Le client n\'existe pas.');
        }
    }
}
