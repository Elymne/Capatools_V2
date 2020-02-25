<?php

namespace app\models\user;

use yii\db\ActiveRecord;

class UserRole extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_role';
    }

    public function getCapaUser()
    {
        return $this->hasOne(CapaUser::className(), ['id' => 'user_id']);
    }
}
