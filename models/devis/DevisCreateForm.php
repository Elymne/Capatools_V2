<?php

namespace app\models\devis;

use yii\base\Model;
use yii\web\UploadedFile;

class DevisCreateForm extends Devis
{



    public $companyname;
    public $companytva;

    public function rules()
    {
        return [
            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['companyname', 'required', 'message' => 'Indiquer lenom du client.'],
            ['companytva', 'required', 'message' => 'Indiquer le numéro de TVA associé au client.'],
            ['delivery_type_id', 'required', 'message' => 'Indiquer le type de la prestation.'],

        ];
    }
}
