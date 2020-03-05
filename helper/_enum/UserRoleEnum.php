<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Allow us to manage active menu.
 */
class UserRoleEnum extends Enum
{

    private const PROJECT_MANAGER_DEVIS = 'projectManagerDevis';
    private const OPERATIONAL_MANAGER_DEVIS = 'operationalManagerDevis';
    private const ACCOUNTING_SUPPORT_DEVIS = 'accountingSupportDevis';

    private const ADMINISTRATOR = 'administrator';
}
