<?php

namespace app\models\User;

use Yii;
use yii\db\ActiveRecord;

class Cellule extends ActiveRecord
{

    public static function tableName()
    {
        return 'Cellule';
    }

    public function getCapaidentity()
    {
        return $this->hasMany(Capaidentity::className(), ['Celluleid' => 'id']);
    }

    public static function findByAXX($AXXX)
    {
        return static::findOne(['identifiant' => $AXXX]);
    }
}
