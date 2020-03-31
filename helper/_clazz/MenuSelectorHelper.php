<?php

namespace app\helper\_clazz;

use app\helper\_enum\SubMenuEnum;
use Yii;

class MenuSelectorHelper
{

    static function setMenuAdminNone()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::USER_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::USER;
    }

    static function setMenuAdminIndex()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::USER_LIST;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::USER;
    }

    static function setMenuAdminCreate()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::USER_CREATE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::USER;
    }
}
