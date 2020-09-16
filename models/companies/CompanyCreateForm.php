<?php

namespace app\models\companies;

use app\services\companyServices\CompanyHttpRequest;
use app\services\countryServices\CountryCSVRequest;
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
            ['name', 'nameChecker', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['email', 'required', 'message' => 'Indiquer l\'email de la société !'],
            ['email', 'emailChecker', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['email', 'email'],

            ['country', 'required', 'message' => 'Indiquer le pays !'],
            ['country', 'countryChecker', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['city', 'required', 'message' => 'Indiquer la ville !'],

            ['postal_code', 'required', 'message' => 'Indiquer le code postal !'],
            ['postal_code', 'string', 'message' => 'Indiquer le code postal !'],
            ['postal_code', 'postalCodeChecker', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['tva', 'tvaChecker', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['tva', 'string', 'min' => 13, 'max' => 16],

            ['type', 'required',  'message' => 'Il doit y avoir un type de sélectionné !'],
        ];
    }

    /**
     * Liste de vérifications personnalisés effectuées sur le champs - name :
     *  - Vérification que le nom d'entreprise n'existe pas déjà en bdd.
     */
    public function nameChecker($attribute, $params)
    {
        $companiesNames = ArrayHelper::map(self::find()->all(), 'id', 'name');
        $companiesNames = array_merge($companiesNames);

        if (in_array($this->$attribute, $companiesNames)) {
            $this->addError($attribute, 'Cette société existe déjà !');
        }
    }

    /**
     * Liste de vérifications personnalisés effectuées sur le champs - email :
     *  - Vérification que l'email n'existe pas déjà en bdd.
     */
    public function emailChecker($attribute, $params)
    {
        $companiesEmail = ArrayHelper::map(Company::find()->all(), 'id', 'email');
        $companiesEmail = array_merge($companiesEmail);

        if (in_array($this->$attribute, $companiesEmail)) {
            $this->addError($attribute, 'Cet email est déjà utilisé sur un client !');
        }
    }

    /**
     * Liste de vérifications personnalisés effectuées sur le champs - tva :
     *  - Vérification que la tva est bien celle de l'entreprise inséré dans le champ non (dans le cas où celle-ci existerait sur l'api).
     *  - Vérification que la tva est inscrite dans le champ dans le cas où le type d'entreprise n'est pas égale à 0.
     *  - Vérification que la tva n'existe pas déjà en bdd.
     *  - Vérification que le format de la tva soit correcte.
     */
    public function tvaChecker($attribute, $params)
    {

        $companyData = CompanyHttpRequest::getUniqueCompanyFromName($this->name);

        if ($companyData != null && $companyData->tva != null && $this->tva != $companyData->tva) {
            $this->addError(
                $attribute,
                "Vous êtes en train d'ajouter une société avec la mauvaise tva, la société existante : "
                    . $this->name . " a la tva suivante : "
                    . $companyData->tva
            );
        }

        $companyType = $this->type;
        if ($companyType == 0 && $this->tva == null) {
            $this->addError($attribute, 'Vous devez préciser la tva !');
        }

        $companiesTva = array_merge(ArrayHelper::map(Company::find()->all(), 'id', 'tva'));
        if (in_array($this->$attribute, $companiesTva) && $this->$attribute != null) {
            $this->addError($attribute, 'Cette tva existe déjà !');
        }

        if (preg_match('^[A-Za-z]{2,4}(?=.{2,12}$)[-_\s0-9]*(?:[a-zA-Z][-_\s0-9]*){0,2}^', $this->tva)) {
            $this->addError($attribute, 'Mauvais format de tva');
        }
    }

    /**
     * Liste de vérifications personnalisés effectuées sur le champs - postal_code :
     *  - Vérification que le code postal corresponde bien au code postal de l'entreprise existante (dans le cas où elle est récupérable depuis l'api REST).
     */
    public function postalCodeChecker($attribute, $params)
    {

        $companyData = CompanyHttpRequest::getUniqueCompanyFromName($this->name);
        if ($companyData != null && $companyData->postalCode != null &&  $this->postal_code != $companyData->postalCode) {
            $this->addError(
                $attribute,
                "Vous êtes en train d'ajouter une société avec le mauvais code postal, la société existante : " . $this->name . " a le code postal suivant : " . $companyData->postalCode
            );
        }
    }

    /**
     * Liste de vérifications personnalisés effectuées sur le champs - postal_code :
     *  - Vérification que le pays incrit existe réellement.
     *  - Vérification lorsque l'on rentre une tva Française que le pays sélectionné est la France.
     */
    public function countryChecker($attribute, $params)
    {

        if (!\in_array($this->country, CountryCSVRequest::getCountries())) {
            $this->addError($attribute, "Le pays que vous avez inscris n'existe pas.");
        }

        $companyData = CompanyHttpRequest::getUniqueCompanyFromName($this->name);
        if ($companyData != null && $this->country != "France") {
            $this->addError($attribute, "La société que vous êtes en train d'ajouter est Française.");
        }
    }
}
