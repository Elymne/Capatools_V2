<?php

namespace app\models\user;

use yii\db\ActiveRecord;

class UserRightApplication extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_right_application';
    }

    public function getCapaUser()
    {
        return $this->hasOne(CapaUser::className(), ['id' => 'user_id']);
    }
}
