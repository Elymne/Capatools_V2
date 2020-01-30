<?php

namespace app\models\User;
use Yii;
use yii\db\ActiveRecord;

class Cellule extends ActiveRecord
{
    public function getCapaidentity()
    {
        return $this->hasMany(Capaidentity::className(), ['Celluleid' => 'id']);
    }

}