<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class Milestone extends ActiveRecord
{

    public static function tableName()
    {
        return 'milestone';
    }

    public static function getAll()
    {
        return static::find();
    }
}
