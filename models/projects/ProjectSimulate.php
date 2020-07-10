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

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [];
    }
}
