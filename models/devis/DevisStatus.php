<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class DevisStatus extends ActiveRecord
{

    public static function tableName()
    {
        return 'devis_status';
    }

    // Draft project.
    const AVANT_PROJET = 1;
    // Ongoing project.
    const PROJET_EN_COURS = 2;
    // Canceled project.
    const PROJET_ANNULE  = 3;
    // Finished project
    const PROJETTERMINE = 4;
    // Waiting for validation for ops.
    const ATTENTE_VALIDATION_OP = 5;
    // Waiting for validation for client.
    const ATTENTE_VALIDATION_CL = 6;

    public static function getAll()
    {
        return static::find();
    }
}
