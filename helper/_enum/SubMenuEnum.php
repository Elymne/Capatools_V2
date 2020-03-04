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

    // Title sidenav Users.
    private const USER = 'USER';

    // Sub title.
    private const USER_CREATE = 'USER_CREATE';
    private const USER_LIST = 'USER_LIST';

    // Title nav Devis.
    private const DEVIS = 'DEVIS';

    // Sub title.
    private const DEVIS_CREATE = 'DEVIS_CREATE';
    private const DEVIS_LIST = 'DEVIS_LIST';
    private const DEVIS_ADD_COMPANY = 'DEVIS_ADD_COMPANY';
}
