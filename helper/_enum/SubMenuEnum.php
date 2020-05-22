<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Allow us to manage active menu.
 */
class SubMenuEnum extends Enum
{

    // None.
    const NONE = 'NONE';

    // Sub title.
    const USER = 'USER';

    const USER_NONE = 'USER_NONE';
    const USER_CREATE = 'USER_CREATE';
    const USER_LIST = 'USER_LIST';
    const USER_ADD_COMPANY = 'USER_ADD_COMPANY';
    const USER_UPDATE_DEVIS_PARAMETERS = "USER_UPDATE_DEVIS_PARAMETERS";

    // Sub title.
    const DEVIS = 'DEVIS';

    const DEVIS_NONE = 'DEVIS_NONE';
    const DEVIS_CREATE = 'DEVIS_CREATE';
    const DEVIS_LIST = 'DEVIS_LIST';
}
