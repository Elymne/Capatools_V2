<?php

namespace app\models\devis;

use app\models\users\CapaUser;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Classe modèle métier des affectations projets.
 * Permet de faire des requêtes depuis la table delivery_type de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class Contributor  extends ActiveRecord
{
    /**
     * Utilisé pour définir quelle table est associé à cette classe.
     */
    public static function tableName()
    {
        return 'contributor';
    }

    public $username;

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [['capa_user_id', 'devis_id', 'nb_day'], 'safe'],
            ['username', 'required', 'message' => 'Indiquer le nom de l\'intervenant.'],
            ['username', 'noUserFound', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['nb_day', 'integer', 'min' => 1, 'tooSmall' => 'Le nombre de jours doit être supérieur à 0.', 'message' => 'Le nombre de jours doit être positif.'],
        ];
    }

    /**
     * L'utilité de cette fonction de vérification est de savoir si l'utilisateur rentré existe bien.
     */
    public function noUserFound($attribute, $params)
    {
        $capaUserNames = ArrayHelper::map(CapaUser::find()->all(), 'id', 'username');
        $capaUserNames = array_merge($capaUserNames);

        if (!in_array($this->$attribute, $capaUserNames)) {
            $this->addError($attribute, 'Cet utilisateur n\'existe pas.');
        }
    }
}
