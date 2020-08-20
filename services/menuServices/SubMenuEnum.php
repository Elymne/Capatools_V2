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
    const USER = 'USER';

    // Correspond à une sous sélection du menu.
    const USER_NONE = 'USER_NONE';
    const USER_CREATE = 'USER_CREATE';
    const USER_LIST = 'USER_LIST';
    const USER_UPDATE_DEVIS_PARAMETERS = "USER_UPDATE_DEVIS_PARAMETERS";
    const USER_UPDATE_EQUIPMENTS = "USER_UPDATE_EQUIPMENTS";

    /**
     * Project menu.
     */
    const PROJECT = 'PROJECT';

    const PROJECT_NONE = 'PROJECT_NONE';
    const PROJECT_CREATE = 'PROJECT_CREATE';
    const PROJECT_LIST = 'PROJECT_LIST';
    const PROJECT_DRAFT = 'PROJECT_DRAFT';

    /**
     * Company menu.
     */
    const COMPANY = 'COMPANY';

    const COMPANY_NONE = 'COMPANY_NONE';
    const COMPANY_INDEX = 'COMPANY_INDEX';
    const COMPANY_CREATE = 'COMPANY_CREATE';
    const COMPANY_UPDATE_CONTACTS = 'COMPANY_UPDATE_CONTACTS';
}
