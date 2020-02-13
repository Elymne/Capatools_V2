<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class Devistatut extends ActiveRecord {
    
    public static function getAll() {
        return static::find();
    }

}
