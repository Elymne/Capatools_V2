<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class DevisStatus extends ActiveRecord
{

    public static function tableName()
    {
        return 'devis_status';
    }

    const AVANTPROJET = 1;
    const PROJETENCOURS = 2;
    const PROJETANNULE  = 3;
    const PROJETTERMINE = 4;
    const ATTENTEVALIDATIONOP = 5;
    const ATTENTEVALIDATIONCL = 6;

    public static function getAll()
    {
        return static::find();
    }
}
