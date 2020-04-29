<?php

namespace app\models\companies;

use yii\helpers\ArrayHelper;

class CompanyCreateForm extends Company
{

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Indiquer le nom du client !'],
            ['name', 'clientAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['address', 'required', 'message' => 'Indiquer l\'addresse client !'],
            ['address', 'addressAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['phone', 'required', 'message' => 'Indiquer le nom du client !'],
            ['phone', 'phoneAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['email', 'required', 'message' => 'Indiquer l\'email du client !'],
            ['email', 'emailAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['email', 'email'],

            ['siret', 'required', 'message' => 'Indiquer le siret du client !'],
            ['siret', 'siretAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],


            ['type', 'required',  'message' => 'Il doit y avoir un type de sélectionné !'],
            ['tva', 'tvaRequired', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['tva', 'tvaAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],
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

    public function addressAlreadyExists($attribute, $params)
    {
        $companiesAddress = ArrayHelper::map(Company::find()->all(), 'id', 'address');
        $companiesAddress = array_merge($companiesAddress);

        if (in_array($this->$attribute, $companiesAddress)) {
            $this->addError($attribute, 'Cette addresse est déjà utilisé sur un client !');
        }
    }

    public function phoneAlreadyExists($attribute, $params)
    {
        $companiesPhone = ArrayHelper::map(Company::find()->all(), 'id', 'phone');
        $companiesPhone = array_merge($companiesPhone);

        if (in_array($this->$attribute, $companiesPhone)) {
            $this->addError($attribute, 'Ce numéro de téléphone est déjà utilisé sur un client !');
        }
    }

    public function emailAlreadyExists($attribute, $params)
    {
        $companiesEmail = ArrayHelper::map(Company::find()->all(), 'id', 'email');
        $companiesEmail = array_merge($companiesEmail);

        if (in_array($this->$attribute, $companiesEmail)) {
            $this->addError($attribute, 'Cet email est déjà utilisé sur un client !');
        }
    }

    public function siretAlreadyExists($attribute, $params)
    {
        $companiesSiret = ArrayHelper::map(Company::find()->all(), 'id', 'siret');
        $companiesSiret = array_merge($companiesSiret);

        if (in_array($this->$attribute, $companiesSiret)) {
            $this->addError($attribute, 'Ce siret est déjà utilisé sur un client !');
        }
    }

    public function tvaRequired($attribute, $params)
    {
        $companyType = $this->type;

        if ($companyType == 0) {
            if ($this->tva == null) $this->addError($attribute, 'Vous devez préciser la tva !');
        }
    }

    public function tvaAlreadyExists($attribute, $params)
    {
        $companiesTva = ArrayHelper::map(Company::find()->all(), 'id', 'tva');
        $companiesTva = array_merge($companiesTva);

        if (in_array($this->$attribute, $companiesTva) && $this->$attribute != null) {
            $this->addError($attribute, 'Cette tva existe déjà !');
        }
    }

    public function wrongTvaFormat($attribute, $params)
    {
        // Promis, j'le fais bientôt.
    }
}
