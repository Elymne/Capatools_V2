<?php

namespace app\models\devis;

use yii\helpers\ArrayHelper;

class CompanyCreateForm extends Company
{

    public function rules()
    {
        return [
            [
                'name',
                'required',
                'message' => 'Indiquer le nom du client !'
            ],
            [
                'name',
                'clientAlreadyExists',
                'skipOnEmpty' => false,
                'skipOnError' => false
            ],
            [
                'tva',
                'required',
                'message' => 'Indiquez la TVA !'
            ],
            [
                'tva',
                'tvaAlreadyExists',
                'skipOnEmpty' => false,
                'skipOnError' => false
            ],
        ];
    }

    public function clientAlreadyExists($attribute, $params)
    {
        $companiesNames = ArrayHelper::map(Company::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        if (in_array($this->$attribute, $companiesNames)) {
            $this->addError($attribute, 'Ce client existe déjà !');
        }
    }

    public function tvaAlreadyExists($attribute, $params)
    {
        $companiesTva = ArrayHelper::map(Company::find()->all(), 'id', 'tva');
        $companiesTva = array_merge($companiesTva);

        if (in_array($this->$attribute, $companiesTva)) {
            $this->addError($attribute, 'Cette tva existe déjà !');
        }
    }

    public function wrongTvaFormat($attribute, $params)
    {
        // Promis, j'le fais bientôt.
    }
}
