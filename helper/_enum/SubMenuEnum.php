<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Allow us to manage active menu.
 */
class SubMenuEnum extends Enum
{

    // None.
    private const NONE = 'NONE';

    // Sub title.
    private const USER_NONE = 'USER_NONE';
    private const USER_CREATE = 'USER_CREATE';
    private const USER_LIST = 'USER_LIST';

    // Sub title.
    private const DEVIS_NONE = 'DEVIS_NONE';
    private const DEVIS_CREATE = 'DEVIS_CREATE';
    private const DEVIS_LIST = 'DEVIS_LIST';
    private const DEVIS_ADD_COMPANY = 'DEVIS_ADD_COMPANY';
}
