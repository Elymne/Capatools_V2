<?php

namespace app\models\devis;

use yii\db\ActiveRecord;

class DeliveryType  extends ActiveRecord
{

    public static function getDeliveryTypes()
    {
        return DeliveryType::find()->asArray()->All();
    }
}
