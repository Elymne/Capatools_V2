<?php

namespace app\models\devis;

use yii\base\Model;
use yii\web\UploadedFile;

class DevisCreateForm extends Devis {
    


    public $companyname;
    public $companytva;

    public function rules()
    {
        return [
            [['filename'], 'file', 'skipOnEmpty' => false,'maxSize' => 2000000, 'extensions' => 'pdf','tooBig'=> 'Le document est trop gros {formattedLimit}','message' => 'Une proposition technique doit être associée au devis.'],
            [['filename'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
            [['filename'], 'validatepresencefile'],
            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['service_duration', 'required', 'message' => 'Indiquer le temps du projet.'],
            ['companyname', 'required', 'message' => 'Indiquer lenom du client.'],
            ['companytva', 'required', 'message' => 'Indiquer le numéro de TVA associé au client.'],
            ['service_duration', 'integer','min'=>0, 'tooSmall' => 'La durée de la prestation doit être supérieur à 0.','message' => 'La durée de la prestation doit être un entier positif.'],

        ];
    }
    



    public function validatepresencefile()
    {
        $path = 'uploads/'.$id_capa;

        Modal::begin([
            'header' => '<h2>Hello world</h2>',
            'toggleButton' => ['label' => 'click me'],
        ]);
    
        echo 'Say hello...';
    
        Modal::end(); 
    }

    public function upload()
    {
        if ($this->validate()) {
            //Je sauvegarde le fichier dans le répertoire uploads/CAPID/
            $path = 'uploads/'.$id_capa;
            if(!file_exists($path))
            {
                mk_dir($path);
            }
            if(!file_exists)
            $this->Filename->saveAs($path.'/'. $this->File->baseName . '.' . $this->File->extension);
            return true;
        } else {
            return false;
        }
    }

}
