<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des type de status d'un devis..
 * Permet de faire des requêtes depuis la table devis_status de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class DevisStatus extends ActiveRecord
{

    public static function tableName()
    {
        return 'devis_status';
    }

    // Draft project.
    const AVANT_PROJET = 1;
    // Waiting for validation for ops.
    const ATTENTE_VALIDATION_OP = 2;
    // Waiting for validation for client.
    const ATTENTE_VALIDATION_CL = 3;
    // Ongoing project.
    const PROJET_EN_COURS = 4;
    // Canceled project.
    const PROJET_ANNULE  = 5;
    // Finished project
    const PROJETTERMINE = 6;


    public static function getAll()
    {
        return static::find();
    }
}
