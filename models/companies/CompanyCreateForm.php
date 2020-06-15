<?php

namespace app\models\companies;

use yii\helpers\ArrayHelper;

/**
 * Classe relative au modèle métier des sociétés.
 * Celle-ci permet lorsque l'on souhaite ajouter une nouvelle société, de vérifier la validité des données rentrées et de créer un formulaire à partir
 * des champs de la table.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class CompanyCreateForm extends Company
{

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Indiquer le nom de la société !'],
            ['name', 'clientAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['email', 'required', 'message' => 'Indiquer l\'email de la société !'],
            ['email', 'emailAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['email', 'email'],

            ['country', 'required', 'message' => 'Indiquer le pays !'],
            ['city', 'required', 'message' => 'Indiquer la ville !'],
            ['postal_code', 'required', 'message' => 'Indiquer le code postal !'],

            ['tva', 'tvaRequired', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['tva', 'tvaAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['type', 'required',  'message' => 'Il doit y avoir un type de sélectionné !'],
        ];
    }

    public function clientAlreadyExists($attribute, $params)
    {
        $companiesNames = ArrayHelper::map(self::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        if (in_array($this->$attribute, $companiesNames)) {
            $this->addError($attribute, 'Cette société existe déjà !');
        }
    }

    public function addressAlreadyExists($attribute, $params)
    {
        $companiesAddress = ArrayHelper::map(Company::find()->all(), 'id', 'address');
        $companiesAddress = array_merge($companiesAddress);

        if (in_array($this->$attribute, $companiesAddress)) {
            $this->addError($attribute, 'Cette addresse est déjà utilisé par une société !');
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

    /**
     * //TODO 
     * Méthode à faire pour lancer une vérification de la tva (sa syntaxe)
     */
    public function tvaChecker($attribute, $params)
    {
        if (false) {
            $this->addError($attribute, 'Mauvaise numéro de tva');
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
}
