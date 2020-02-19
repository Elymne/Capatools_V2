<?php

namespace app\models\devis;

use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

class Typeprestation  extends ActiveRecord {

    public static function getlisteTypePrestation()
    {
                return Typeprestation::find()->asArray()->All();
    }

}
