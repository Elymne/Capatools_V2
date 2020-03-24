<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class MilestoneStatus extends ActiveRecord
{

    public static function tableName()
    {
        return 'milestone_status';
    }

    const ENCOURS = 1;
    const FACTURATIONENCOUR  = 2;
    const FACTURE = 3;

    // Not used.
    const ATTENTE_VALIDATION_OP = 4;
    const ATTENTE_VALIDATION_CL = 5;

    public static function getAll()
    {
        return static::find();
    }
}
