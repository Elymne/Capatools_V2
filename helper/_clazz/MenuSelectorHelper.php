<?php

namespace app\helper\_clazz;

use app\helper\_enum\SubMenuEnum;
use Yii;

/**
 * Classe utilisé pour définir quel onglet du menu est actif.
 * Si vous ajouter de nouveau onglet, pensez à créer une nouvelle fonction dans cette classe.
 * Pensez aussi à ajouter une nouvelle énumération dans la classe SubMenuEnum pour éviter les erreurs de misspelling.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class MenuSelectorHelper
{

    /**
     * Description :
     * - Déroule le menu Administration.
     * - Aucun sub-menu n'est actif.
     */
    static function setMenuAdminNone()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::USER_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::USER;
    }

    /**
     * Description :
     * - Déroule le menu Administration.
     * - Le sub-menu de la liste des utilisateurs est actif.
     */
    static function setMenuAdminIndex()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::USER_LIST;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::USER;
    }

    /**
     * Description :
     * - Déroule le menu Administration.
     * - Le sub-menu de la création d'une société est actif.
     */
    static function setMenuAdminAddCompany()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::USER_ADD_COMPANY;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::USER;
    }

    /**
     * Description :
     * - Déroule le menu Devis.
     * - Aucuns sub-menu n'est actif.
     */
    static function setMenuDevisNone()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
    }

    /**
     * Description :
     * - Déroule le menu Devis.
     * - Le sub-menu de la liste des devis est actif.
     */
    static function setMenuDevisIndex()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_LIST;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
    }

    /**
     * Description :
     * - Déroule le menu Devis.
     * - Le sub-menu de la création d'un devis.
     */
    static function setMenuDevisCreate()
    {
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::DEVIS;
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::DEVIS_CREATE;
    }
}
