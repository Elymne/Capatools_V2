<?php

namespace app\models\projects;


use yii\db\ActiveRecord;

/**
 * Classe modèle métier des lots.
 * Permet de faire des requêtes depuis la table devis de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectSimulate extends Project
{

    public function rules()
    {
        return [
            [['low_tjm_raison', 'low_tjm_description'], 'safe'],
            [['low_tjm_raison'], 'required', 'message' => 'Une Raison doit être sélectionnée pour valider le taux journalier'],
            [['low_tjm_description'], 'required', 'message' => 'Une raison doit être décrite'],

        ];
    }



    public $support_cost;
}
