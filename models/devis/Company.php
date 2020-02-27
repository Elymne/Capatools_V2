<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class Company extends ActiveRecord
{

    public static function tableName()
    {
        return 'company';
    }

    public static function getAll()
    {
        return static::find();
    }
}
