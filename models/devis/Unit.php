<?php

namespace app\models\devis;

use \yii\db\ActiveRecord;

class Unit extends ActiveRecord {

    public static function getAll() {
        return static::find();
    }

    public function getDevis() {
        return $this->hasMany(Devis::className(), ['unit_id' => 'id']);
    }
    
}
