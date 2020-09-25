<?php

namespace app\services\menuServices;

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
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::ADMIN_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::ADMIN;
    }

    /**
     * Description :
     * - Déroule le menu Administration.
     * - Le sub-menu de la liste des utilisateurs est actif.
     */
    static function setMenuAdminIndex()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::ADMIN_LIST_USER;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::ADMIN;
    }

    /**
     * Description :
     * - Déroule le menu Administration.
     * - Le sub-menu de la modification des paramètres devis est actif.
     */
    static function setMenuDevisParameters()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::ADMIN_UPDATE_DEVIS_PARAMETERS;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::ADMIN;
    }

    /**
     * Description :
     * - Déroule le menu Administration.
     * - Le sub-menu de la liste des équipements.
     */
    static function setMenuEquipments()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::ADMIN_LIST_EQUIPMENTS;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::ADMIN;
    }

    /**
     * Description :
     * - Déroule le menu Administration.
     * - Le sub-menu de la liste des laboratoires.
     */
    static function setMenuLaboratories()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::ADMIN_LIST_LABORATORIES;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::ADMIN;
    }

    /**
     * Description :
     * - Déroule le menu Administration.
     * - Le sub-menu de la liste des docuements.
     */
    static function setMenuDocuments()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::ADMIN_LIST_DOCUMENTS;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::ADMIN;
    }
    /**
     * Description :
     * - Déroule le menu Devis.
     * - Aucuns sub-menu n'est actif.
     */
    static function setMenuProjectNone()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::PROJECT_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::PROJECT;
    }

    /**
     * Description :
     * - Déroule le menu Devis.
     * - Le sub-menu de la liste des devis est actif.
     */
    static function setMenuProjectIndex()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::PROJECT_LIST;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::PROJECT;
    }

    /**
     * Description :
     * - Déroule le menu Devis.
     * - Le sub-menu de la liste des devis est actif.
     */
    static function setMenuProjectDraft()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::PROJECT_DRAFT;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::PROJECT;
    }

    /**
     * Description :
     * - Déroule le menu Devis.
     * - Le sub-menu de la création d'un devis.
     */
    static function setMenuProjectCreate()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::PROJECT_CREATE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::PROJECT;
    }

    /**
     * Description :
     * - Déroule le menu Devis.
     * - Le sub-menu de la création d'un devis.
     */
    static function setMenuProjectMilestones()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::PROJECT_MILESTONES;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::PROJECT;
    }

    /**
     * Description :
     * - Déroule le menu Company.
     * - Aucun sub menu d'actif.
     */
    static function setMenuCompanyNone()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::COMPANY_NONE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::COMPANY;
    }

    /**
     * Description :
     * - Déroule le menu Company.
     * - Le sub-menu de la création d'une société est actif.
     */
    static function setMenuCompanyIndex()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::COMPANY_INDEX;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::COMPANY;
    }

    /**
     * Description :
     * - Déroule le menu Company.
     * - Le sub-menu de la création d'une société est actif.
     */
    static function setMenuCompanyCreate()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::COMPANY_CREATE;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::COMPANY;
    }

    /**
     * Description :
     * - Déroule le menu Company.
     * - Le sub-menu de la liste des contacts.
     */
    static function setMenuCompanyContacts()
    {
        Yii::$app->params['subServiceMenuActive'] = SubMenuEnum::COMPANY_UPDATE_CONTACTS;
        Yii::$app->params['serviceMenuActive'] = SubMenuEnum::COMPANY;
    }
}
