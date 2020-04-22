<?php

namespace app\models\companies;

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
