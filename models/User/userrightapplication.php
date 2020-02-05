<?php

namespace app\models\User;
use Yii;
use yii\db\ActiveRecord;

class userrightapplication extends ActiveRecord 
{
    public static function tableName()
    {
        return 'userrightapplication';
    }

    public function getCapaidentity()
    {
        
        return $this->hasOne(Capaidentity::className(), ['id' => 'Userid']);
    }
}

