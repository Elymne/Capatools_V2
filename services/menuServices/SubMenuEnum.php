<?php

namespace app\services\menuServices;

/**
 * Une classe d'enumération pour gérer les menus actifs.
 * Marche de paire avec la classe MenuSelectorHelper.
 */
class SubMenuEnum
{

    // None.
    const NONE = 'NONE';

    /**
     * Administration menu.
     * Correspond à la sélection principale du menu.
     */
    const ADMIN = 'ADMIN';

    // Correspond à une sous sélection du menu.
    const ADMIN_NONE = 'ADMIN_NONE';
    const ADMIN_CREATE_USER = 'ADMIN_CREATE_USER';
    const ADMIN_LIST_USER = 'ADMIN_LIST_USER';
    const ADMIN_UPDATE_DEVIS_PARAMETERS = "USER_UPDATE_DEVIS_PARAMETERS";
    const ADMIN_LIST_EQUIPMENTS = "USER_UPDATE_EQUIPMENTS";
    const ADMIN_LIST_LABORATORIES = "USER_LIST_LABORATORIES";
    const ADMIN_LIST_DOCUMENTS = "USER_LIST_DOCUMENTS";
    /**
     * Project menu.
     */
    const PROJECT = 'PROJECT';

    const PROJECT_NONE = 'PROJECT_NONE';
    const PROJECT_CREATE = 'PROJECT_CREATE';
    const PROJECT_LIST = 'PROJECT_LIST';
    const PROJECT_DRAFT = 'PROJECT_DRAFT';
    const PROJECT_MILESTONES = 'PROJECT_MILESTONES';

    /**
     * Company menu.
     */
    const COMPANY = 'COMPANY';

    const COMPANY_NONE = 'COMPANY_NONE';
    const COMPANY_INDEX = 'COMPANY_INDEX';
    const COMPANY_CREATE = 'COMPANY_CREATE';
    const COMPANY_UPDATE_CONTACTS = 'COMPANY_UPDATE_CONTACTS';
}
