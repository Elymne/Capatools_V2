<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class ProjectManager extends ActiveRecord {
    
    public static function getAll() {
        return static::find();
    }

}
