<?php

namespace app\models\User;
use Yii;
use yii\base\Security;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class userrightapplication extends ActiveRecord 
{

    public function getCapaidentity()
    {
        
        return $this->hasOne(Capaidentity::className(), ['id' => 'Userid']);
    }
}

