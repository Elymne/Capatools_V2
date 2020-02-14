<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class Devisstatut extends ActiveRecord {
    
    const AVANTPROJET       = 0;
    const PROJETENCOURS       = 1;
    const PROJETANNULE       = 2;
    const PROJETTERMINE = 3;
    const ATTENTEVALIDATIONOP = 4;
    const ATTENTEVALIDATIONCL = 5;



    public static function getAll() {
        return static::find();
    }

}
