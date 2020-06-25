<?php

namespace app\models\projects\forms;

use app\models\projects\Repayment;
use Yii;

/**
 * Classe relative au modèle métier des dépenses.
 * Celle-ci permet de créer un formulaire de création de dépenses sur la création d'un projet et de vérifier la validité des données inscrites dans les champs.
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis un contrôleur.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectCreateRepaymentForm extends Repayment
{

    /**
     * Liste d'attributs relatif au formulaire.
     */
    public $laboratorySelected;

    /**
     * Fonction surchargée de la classe ActiveRecord, elle permet de vérifier l'intégrité des données dans un modèle.
     */
    public function rules()
    {
        return [
            ['type', 'required', 'message' => 'Veuillez renseigner le laboratoire']
        ];
    }
}
