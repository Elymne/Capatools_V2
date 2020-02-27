<?php

namespace app\models\devis;

class DevisCreateForm extends Devis
{

    public $company_name;
    public $company_tva;

    public function rules()
    {
        return [
            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire.'],
            ['company_name', 'required', 'message' => 'Indiquer lenom du client.'],
            ['company_tva', 'required', 'message' => 'Indiquer le numéro de TVA associé au client.'],
            ['delivery_type_id', 'required', 'message' => 'Indiquer le type de la prestation.'],

        ];
    }
}
