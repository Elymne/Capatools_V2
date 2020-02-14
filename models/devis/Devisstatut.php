<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class Devisstatut extends ActiveRecord {
    
    public const AVANTPROJET       = 0;
    public const PROJETENCOURS       = 1;
    public const PROJETANNULE       = 2;
    public const PROJETTERMINE = 3;
    public const ATTENTEVALIDATIONOP = 4;
    public const ATTENTEVALIDATIONCL = 5;



    public static function getAll() {
        return static::find();
    }

}
