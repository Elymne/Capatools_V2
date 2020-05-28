<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

/**
 * Classe modèle métier des status d'un jalon d'un devis..
 * Permet de faire des requêtes depuis la table milestone_status de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class MilestoneStatus extends ActiveRecord
{

    public static function tableName()
    {
        return 'milestone_status';
    }

    /**
     * Constante représentant les 3 status d'un jalon.
     */
    const ENCOURS = 1;
    const FACTURATIONENCOURS  = 2;
    const FACTURE = 3;

    /**
     * @deprecated
     * Constante que nous n'utilisons plus pour l'instant.
     */
    const ATTENTE_VALIDATION_OP = 4;
    const ATTENTE_VALIDATION_CL = 5;

    public static function getAll()
    {
        return static::find();
    }
}
