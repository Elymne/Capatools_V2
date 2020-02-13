<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class Devisstatut extends ActiveRecord {
    
    public static function getAll() {
        return static::find();
    }

}
