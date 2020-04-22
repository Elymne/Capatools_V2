<?php

namespace app\helper\_clazz;

use app\helper\_enum\SubMenuEnum;
use Yii;

/**
 * Classe utilisé pour définir quel obglet du menu est actif.
 * Si vous ajouter de nouveau onglet, pensez à créer une nouvelle émthode dans cette classe ainsi.
 * Pensez aussi à ajouter une nouvelle énumération dans la classe SubMenuEnum.
 */
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

    static function setMenuAdminAddCompany()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::USER_ADD_COMPANY;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::USER;
    }

    static function setMenuDevisNone()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
    }

    static function setMenuDevisIndex()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_LIST;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
    }

    static function setMenuDevisCreate()
    {
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_CREATE;
    }
}
