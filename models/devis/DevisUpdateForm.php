<?php

namespace app\models\devis;

use yii\base\Model;
use yii\web\UploadedFile;

class DevisUpdateForm extends Devis {
    
    public $upfilename;

    public function rules()
    {
        return [
            [['upfilename'], 'file', 'skipOnEmpty' => true,'maxSize' => 2000000, 'extensions' => 'pdf','tooBig'=> 'Le document est trop gros {formattedLimit}','message' => 'Une proposition technique doit être associée au devis.'],
            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['service_duration', 'required', 'message' => 'Indiquer le temps du projet.'],
            ['company[name]', 'required', 'message' => 'Indiquer lenom du client.'],
            ['company[tva]', 'required', 'message' => 'Indiquer le numéro de TVA associé au client.'],
            ['service_duration', 'integer','min'=>0, 'tooSmall' => 'La durée de la prestation doit être supérieur à 0.','message' => 'La durée de la prestation doit être un entier positif.'],

        ];
    }
    


    public function upload()
    {
        if ($this->validate()) {
            //Je sauvegarde le fichier dans le répertoire uploads/CAPID/
            $path = 'uploads/'.$id_capa;
            if(!is_dir($path))
            {
                mk_dir($path);
            }
            if(!file_exists)
            {

            }
            
            $this->Filename->saveAs($path.'/'. $this->File->baseName . '.' . $this->File->extension);
            return true;
        } else {
            return false;
        }
    }

}
