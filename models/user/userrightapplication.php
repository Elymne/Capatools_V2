<?php

namespace app\models\user;

use Yii;
use yii\db\ActiveRecord;

class userrightapplication extends ActiveRecord
{
    public static function tableName()
    {
        return 'UserRightApplication';
    }

    public function getCapaUser()
    {
        return $this->hasOne(CapaUser::className(), ['id' => 'Userid']);
    }
}
