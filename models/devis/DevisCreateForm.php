<?php

namespace app\models\devis;

use app\models\companies\Company;
use yii\helpers\ArrayHelper;

class DevisCreateForm extends Devis
{

    // This field is inserted here because it doesn't exist on Devis model. Tis a Company attribute.
    public $company_name;

    public function rules()
    {
        return [
            ['internal_name', 'required', 'message' => 'Un nom de projet est obligatoire !'],
            [
                'company_name',
                'required',
                'message' => 'Indiquer le nom du client !'
            ],
            [
                'company_name',
                'noClientFound',
                'skipOnEmpty' => false,
                'skipOnError' => false
            ],
            [
                'delivery_type_id',
                'required', 'message' => 'Indiquer le type de la prestation !'
            ],

        ];
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


//Company::find()->where([$model->company_name => $model->company_name])->one() != null;
