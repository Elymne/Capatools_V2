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
     */
    const USER = 'USER';

    const USER_NONE = 'USER_NONE';
    const USER_CREATE = 'USER_CREATE';
    const USER_LIST = 'USER_LIST';
    const USER_UPDATE_DEVIS_PARAMETERS = "USER_UPDATE_DEVIS_PARAMETERS";
    const USER_UPDATE_EQUIPMENTS = "USER_UPDATE_EQUIPMENTS";

    /**
     * Devis menu.
     */
    const DEVIS = 'DEVIS';

    const DEVIS_NONE = 'DEVIS_NONE';
    const DEVIS_CREATE = 'DEVIS_CREATE';
    const DEVIS_LIST = 'DEVIS_LIST';

    /**
     * Company menu.
     */
    const COMPANY = 'COMPANY';

    const COMPANY_NONE = 'COMPANY_NONE';
    const COMPANY_INDEX = 'COMPANY_INDEX';
    const COMPANY_CREATE = 'COMPANY_CREATE';
    const COMPANY_UPDATE_CONTACTS = 'COMPANY_UPDATE_CONTACTS';
}
