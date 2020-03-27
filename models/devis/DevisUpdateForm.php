<?php

namespace app\models\devis;

use yii\helpers\ArrayHelper;

class DevisUpdateForm extends Devis
{

    public $upfilename;
    public $pathfile;
    public $datept;

    public $company_name;

    public function rules()
    {
        return [
            [['upfilename'], 'file', 'skipOnEmpty' => true, 'maxSize' => 2000000, 'extensions' => 'pdf', 'tooBig' => 'Le document est trop gros {formattedLimit}', 'message' => 'Une proposition technique doit être associée au devis.'],
            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['service_duration', 'required', 'message' => 'Indiquer le temps du projet.'],
            ['company_name', 'required', 'message' => 'Indiquer le nom du client.'],
            ['company_name', 'noClientFound', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['service_duration', 'integer', 'min' => 0, 'tooSmall' => 'La durée de la prestation doit être supérieur à 0.', 'message' => 'La durée de la prestation doit être un entier positif.'],
            //['price', 'required', 'message' => 'Indiquer le prix de la prestation.'],
            //['price', 'double', 'min' => 1, 'tooSmall' => 'Le prix de la prestation doit être supérieur à 0.', 'message' => 'Le prix de la prestation doit être positif.'],
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
    public function noClientFound($attribute, $params)
    {
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        if (!in_array($this->$attribute, $companiesNames)) {
            $this->addError($attribute, 'Le client n\'existe pas.');
        }
    }
}
