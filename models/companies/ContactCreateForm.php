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
class ContactCreateForm extends Contact
{

    public function rules()
    {
        return [
            ['surname', 'required', 'message' => 'Indiquer le nom du contact !'],
            ['firstname', 'required', 'message' => 'Indiquer le prénom du contact !'],
            ['surname', 'required', 'message' => 'Indiquer le nom du contact !'],

            ['phone_number', 'required', 'message' => 'Indiquer le nom du client !'],
            ['phone_number', 'phoneAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],

            ['email', 'required', 'message' => 'Indiquer l\'email du client !'],
            ['email', 'emailAlreadyExists', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['email', 'email']
        ];
    }

    public function phoneAlreadyExists($attribute, $params)
    {
        $contactsPhone = ArrayHelper::map(Contact::find()->all(), 'id', 'phone_number');
        $contactsPhone = array_merge($contactsPhone);

        if (in_array($this->$attribute, $contactsPhone)) {
            $this->addError($attribute, 'Ce numéro de téléphone est déjà utilisé par un contact !');
        }
    }

    public function emailAlreadyExists($attribute, $params)
    {
        $contactsEmail = ArrayHelper::map(Contact::find()->all(), 'id', 'email');
        $contactsEmail = array_merge($contactsEmail);

        if (in_array($this->$attribute, $contactsEmail)) {
            $this->addError($attribute, 'Cet email est déjà utilisé sur par un contact !');
        }
    }
}
