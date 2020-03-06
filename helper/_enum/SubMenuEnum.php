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
    const USER_NONE = 'USER_NONE';
    const USER_CREATE = 'USER_CREATE';
    const USER_LIST = 'USER_LIST';

    // Sub title.
    const DEVIS_NONE = 'DEVIS_NONE';
    const DEVIS_CREATE = 'DEVIS_CREATE';
    const DEVIS_LIST = 'DEVIS_LIST';
    const DEVIS_ADD_COMPANY = 'DEVIS_ADD_COMPANY';
}
