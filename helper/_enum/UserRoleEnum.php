<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Allow us to manage active menu.
 */
class UserRoleEnum extends Enum
{

    const PROJECT_MANAGER_DEVIS = 'projectManagerDevis';
    const OPERATIONAL_MANAGER_DEVIS = 'operationalManagerDevis';
    const ACCOUNTING_SUPPORT_DEVIS = 'accountingSupportDevis';

    const ADMINISTRATOR = 'administrator';
}
