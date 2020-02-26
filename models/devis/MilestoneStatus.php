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
    const ATTENTEVALIDATIONOP = 4;
    const ATTENTEVALIDATIONCL = 5;

    public static function getAll()
    {
        return static::find();
    }
}
