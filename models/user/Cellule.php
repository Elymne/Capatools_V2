<?php

namespace app\models\user;

use Yii;
use yii\db\ActiveRecord;

class Cellule extends ActiveRecord
{

    public static function tableName()
    {
        return 'cellule';
    }

    public function getCapaidentity()
    {
        return $this->hasMany(Capaidentity::className(), ['Celluleid' => 'id']);
    }

    public static function findByAXX($AXXX)
    {
        return static::findOne(['identity' => $AXXX]);
    }
}
